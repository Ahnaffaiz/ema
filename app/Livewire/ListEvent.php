<?php

namespace App\Livewire;

use App\Models\Event;
use App\Models\Host;
use Illuminate\Support\Facades\Storage;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

class ListEvent extends Component
{
    use WithPagination;

    public $search = '';
    public $dateFilter = 'upcoming'; // Default to upcoming

    // Modal properties
    public $showModal = false;
    public $modalId = 'eventDetailModal';
    public $modalSize = 'lg';
    public $modalTitle = 'Event Details';
    public $modalSaveLabel = 'Close';
    public $modalSaveFunction = 'closeModal';
    public $modalCancelFunction = 'closeModal';
    public $modalSaveButtonColor = 'secondary';

    // Selected event for modal
    public $selectedEvent = null;

    // Delete confirmation
    public $eventToDelete = null;

    #[Title('Event List')]

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingDateFilter()
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = Event::with(['user', 'host', 'activities'])
            ->where('name', 'like', '%' . $this->search . '%');

        if ($this->dateFilter) {
            switch ($this->dateFilter) {
                case 'upcoming':
                    $query->where('start_date', '>', now());
                    break;
                case 'ongoing':
                    $query->where('start_date', '<=', now())
                          ->where('end_date', '>=', now());
                    break;
                case 'past':
                    $query->where('end_date', '<', now());
                    break;
                case 'all':
                    // No additional filter for 'all'
                    break;
                case 'registration_open':
                    $query->where('registration_start_date', '<=', now())
                          ->where('registration_end_date', '>=', now());
                    break;
            }
        }

        // Dynamic ordering based on filter type
        if ($this->dateFilter === 'upcoming') {
            $events = $query->orderBy('start_date', 'asc')->paginate(12); // Earliest upcoming first
        } else {
            $events = $query->orderBy('start_date', 'desc')->paginate(12); // Latest first for others
        }
        $hosts = Host::all();

        return view('livewire.list-event', [
            'events' => $events,
            'hosts' => $hosts,
        ]);
    }

    public function create()
    {
        return redirect()->route('events.create');
    }

    public function edit($id)
    {
        return redirect()->route('events.edit', $id);
    }

    public function viewDetails($id)
    {
        $this->selectedEvent = Event::with(['user', 'host', 'activities'])->findOrFail($id);
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->selectedEvent = null;
    }

    public function confirmDelete($id)
    {
        $this->eventToDelete = $id;

        LivewireAlert::title('Are you sure you want to delete this event?')
            ->text('This action cannot be undone. All related activities and registrations will also be deleted.')
            ->withConfirmButton('Yes, delete it!')
            ->withCancelButton('Cancel')
            ->onConfirm('deleteEvent')
            ->warning()
            ->show();
    }

    public function deleteEvent()
    {
        try {
            $event = Event::findOrFail($this->eventToDelete);

            // Delete event image if exists
            if ($event->image) {
                Storage::disk('public')->delete($event->image);
            }

            // Delete the event (cascade will handle related records)
            $event->delete();

            LivewireAlert::title('Event deleted successfully!')
                ->position('top-end')
                ->timer(3000)
                ->toast()
                ->success()
                ->show();

            $this->eventToDelete = null;

        } catch (\Exception $e) {
            LivewireAlert::title('Error!')
                ->text('Failed to delete the event: ' . $e->getMessage())
                ->position('top-end')
                ->timer(5000)
                ->toast()
                ->error()
                ->show();
        }
    }

    public function toggleStatus($id)
    {
        try {
            $event = Event::findOrFail($id);

            // Only toggle between active and inactive
            if ($event->status === 'active') {
                $event->status = 'inactive';
            } else {
                // For both 'inactive' and 'cancelled' status, set to 'active'
                $event->status = 'active';
            }

            $event->save();

            LivewireAlert::title('Event status updated!')
                ->position('top-end')
                ->timer(3000)
                ->toast()
                ->success()
                ->show();

        } catch (\Exception $e) {
            LivewireAlert::title('Error!')
                ->text('Failed to update event status: ' . $e->getMessage())
                ->position('top-end')
                ->timer(5000)
                ->toast()
                ->error()
                ->show();
        }
    }

    public function cancelEvent($id)
    {
        try {
            $event = Event::findOrFail($id);
            $event->status = 'cancelled';
            $event->save();

            LivewireAlert::title('Event cancelled successfully!')
                ->position('top-end')
                ->timer(3000)
                ->toast()
                ->success()
                ->show();

        } catch (\Exception $e) {
            LivewireAlert::title('Error!')
                ->text('Failed to cancel event: ' . $e->getMessage())
                ->position('top-end')
                ->timer(5000)
                ->toast()
                ->error()
                ->show();
        }
    }

    public function clearFilters()
    {
        $this->reset(['search', 'dateFilter']);
        $this->resetPage();
    }

    public function getEventStatusBadge($status)
    {
        return match($status) {
            'active' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300',
            'inactive' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300',
            'cancelled' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300',
            default => 'bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-300',
        };
    }
}
