<?php

namespace App\Livewire;

use App\Models\Activity;
use App\Models\Event;
use App\Models\Host;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;

class CreateEvent extends Component
{
    use WithFileUploads;

    public $name = '';
    public $desc = '';
    public $image;
    public $registration_start_date = '';
    public $registration_end_date = '';
    public $start_date = '';
    public $end_date = '';
    public $ticket_price = '';
    public $require_approval = false;
    public $is_public = true;
    public $capacity = '';
    public $status = 'active';
    public $host_id = '';
    public $short_link = '';

    // Location fields
    public $location_type = '';
    public $location_address = '';
    public $location_url = '';

    // Activities
    public $activities = [];
    public $activity_name = '';
    public $activity_desc = '';
    public $activity_start_date = '';
    public $activity_end_date = '';
    public $activity_capacity = '';
    public $activity_ticket_price = '';

    // Modal properties
    public $showModal = false;
    public $modalId = 'eventModal';
    public $modalSize = 'xl';
    public $modalTitle = 'Create Event';
    public $modalSaveLabel = 'Save Event';
    public $modalSaveFunction = 'saveEvent';
    public $modalCancelFunction = 'cancelModal';
    public $modalSaveButtonColor = 'violet';

    // Edit mode
    public $eventId = null;
    public $isEditMode = false;

    // Rich text editor content
    public $richTextContent = '';

    #[Title('Create Event')]

    public function mount($id = null)
    {
        if ($id) {
            $this->loadEvent($id);
        }
    }

    public function render()
    {
        $hosts = Host::all();

        return view('livewire.create-event', [
            'hosts' => $hosts,
        ]);
    }

    public function loadEvent($id)
    {
        $event = Event::with(['activities'])->findOrFail($id);

        $this->eventId = $event->id;
        $this->name = $event->name;
        $this->desc = $event->desc;
        $this->registration_start_date = $event->registration_start_date->format('Y-m-d\TH:i');
        $this->registration_end_date = $event->registration_end_date->format('Y-m-d\TH:i');
        $this->start_date = $event->start_date->format('Y-m-d\TH:i');
        $this->end_date = $event->end_date->format('Y-m-d\TH:i');
        $this->ticket_price = $event->ticket_price;
        $this->require_approval = $event->require_approval;
        $this->is_public = $event->is_public;
        $this->capacity = $event->capacity;
        $this->status = $event->status;
        $this->host_id = $event->host_id;
        $this->activities = $event->activities->toArray();
        $this->richTextContent = $event->desc;
        $this->short_link = $event->short_link;
        $this->location_type = $event->location_type;
        $this->location_address = $event->location_address;
        $this->location_url = $event->location_url;

        $this->isEditMode = true;
        $this->modalTitle = 'Edit Event';
    }

    public function openModal()
    {
        $this->resetForm();
        $this->showModal = true;
    }

    public function cancelModal()
    {
        $this->resetForm();
        $this->showModal = false;
    }

    public function resetForm()
    {
        $this->reset([
            'name', 'desc', 'image', 'registration_start_date', 'registration_end_date',
            'start_date', 'end_date', 'ticket_price', 'require_approval', 'is_public',
            'capacity', 'status', 'host_id', 'activities',
            'activity_name', 'activity_desc', 'activity_start_date', 'activity_end_date',
            'activity_capacity', 'activity_ticket_price', 'eventId', 'isEditMode', 'richTextContent',
            'short_link', 'location_type', 'location_address', 'location_url',
        ]);
        $this->modalTitle = 'Create Event';
    }

    public function addActivity()
    {
        $this->validate([
            'activity_name' => 'required|string|max:255',
            'activity_desc' => 'nullable|string',
            'activity_start_date' => 'required|date',
            'activity_end_date' => 'required|date|after:activity_start_date',
            'activity_capacity' => 'nullable|integer|min:1',
            'activity_ticket_price' => 'nullable|numeric|min:0',
        ]);

        $this->activities[] = [
            'name' => $this->activity_name,
            'desc' => $this->activity_desc,
            'start_date' => $this->activity_start_date,
            'end_date' => $this->activity_end_date,
            'capacity' => $this->activity_capacity,
            'ticket_price' => $this->activity_ticket_price,
        ];

        $this->reset([
            'activity_name', 'activity_desc', 'activity_start_date',
            'activity_end_date', 'activity_capacity', 'activity_ticket_price'
        ]);

        LivewireAlert::title('Activity added successfully!')
            ->position('top-end')
            ->timer(3000)
            ->toast()
            ->success()
            ->show();
    }

    public function removeActivity($index)
    {
        unset($this->activities[$index]);
        $this->activities = array_values($this->activities);
    }

    public function saveEvent()
    {
        $uniqueRule = $this->isEditMode ? 'unique:events,short_link,' . $this->eventId : 'unique:events,short_link';

        $this->validate([
            'name' => 'required|string|max:255',
            'registration_start_date' => 'required|date',
            'registration_end_date' => 'required|date|after:registration_start_date',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'ticket_price' => 'nullable|numeric|min:0',
            'capacity' => 'nullable|integer|min:1',
            'host_id' => 'required|exists:hosts,id',
            'image' => 'nullable|image|max:2048',
            'short_link' => 'nullable|string|max:255|regex:/^[a-zA-Z0-9_-]+$/|' . $uniqueRule,
            'location_type' => 'nullable|in:physical,virtual',
            'location_address' => 'required_if:location_type,physical|nullable|string|max:500',
            'location_url' => 'nullable|url|max:500',
        ]);

        try {
            $imagePath = null;
            if ($this->image) {
                $imagePath = $this->image->store('events', 'public');
            }

            if ($this->isEditMode) {
                $event = Event::findOrFail($this->eventId);

                // Delete old image if new one is uploaded
                if ($imagePath && $event->image) {
                    Storage::disk('public')->delete($event->image);
                }

                $event->update([
                    'name' => $this->name,
                    'desc' => $this->desc,
                    'image' => $imagePath ?: $event->image,
                    'registration_start_date' => $this->registration_start_date,
                    'registration_end_date' => $this->registration_end_date,
                    'start_date' => $this->start_date,
                    'end_date' => $this->end_date,
                    'ticket_price' => $this->ticket_price,
                    'require_approval' => $this->require_approval,
                    'is_public' => $this->is_public,
                    'capacity' => $this->capacity,
                    'status' => $this->status,
                    'host_id' => $this->host_id,
                    'short_link' => $this->short_link,
                    'location_type' => $this->location_type,
                    'location_address' => $this->location_address,
                    'location_url' => $this->location_url,
                ]);

                // Delete existing activities
                $event->activities()->delete();
            } else {
                $event = Event::create([
                    'user_id' => Auth::id(),
                    'name' => $this->name,
                    'desc' => $this->desc,
                    'image' => $imagePath,
                    'registration_start_date' => $this->registration_start_date,
                    'registration_end_date' => $this->registration_end_date,
                    'start_date' => $this->start_date,
                    'end_date' => $this->end_date,
                    'ticket_price' => $this->ticket_price,
                    'require_approval' => $this->require_approval,
                    'is_public' => $this->is_public,
                    'capacity' => $this->capacity,
                    'status' => $this->status,
                    'host_id' => $this->host_id,
                    'short_link' => $this->short_link,
                    'location_type' => $this->location_type,
                    'location_address' => $this->location_address,
                    'location_url' => $this->location_url,
                ]);
            }

            // Create activities
            foreach ($this->activities as $activityData) {
                Activity::create([
                    'event_id' => $event->id,
                    'name' => $activityData['name'],
                    'desc' => $activityData['desc'],
                    'start_date' => $activityData['start_date'],
                    'end_date' => $activityData['end_date'],
                    'capacity' => $activityData['capacity'],
                    'ticket_price' => $activityData['ticket_price'],
                ]);
            }

            LivewireAlert::title($this->isEditMode ? 'Event updated successfully!' : 'Event created successfully!')
                ->position('top-end')
                ->timer(3000)
                ->toast()
                ->success()
                ->show();

            $this->cancelModal();
            return redirect()->route('events.list');

        } catch (\Exception $e) {
            LivewireAlert::title('Error!')
                ->text($e->getMessage())
                ->position('top-end')
                ->timer(5000)
                ->toast()
                ->error()
                ->show();
        }
    }

    public function updatedShortLink()
    {
        // Only validate if short_link is not empty
        if (!empty($this->short_link)) {
            $this->validateOnly('short_link', [
                'short_link' => 'nullable|string|max:255|regex:/^[a-zA-Z0-9_-]+$/' . ($this->isEditMode ? '|unique:events,short_link,' . $this->eventId : '|unique:events,short_link'),
            ]);
        } else {
            // Clear any existing errors for short_link when field is empty
            $this->resetErrorBag('short_link');
        }
    }

    public function generateShortLink()
    {
        if (empty($this->name)) {
            LivewireAlert::title('Event name required')
                ->text('Please enter an event name first to generate a short link.')
                ->position('top-end')
                ->timer(3000)
                ->toast()
                ->warning()
                ->show();
            return;
        }

        // Generate short link from event name
        $baseShortLink = \Illuminate\Support\Str::slug($this->name, '-');
        $shortLink = $baseShortLink;
        $counter = 1;

        // Check for uniqueness and append number if necessary
        while (Event::where('short_link', $shortLink)
                   ->when($this->isEditMode, function($query) {
                       return $query->where('id', '!=', $this->eventId);
                   })
                   ->exists()) {
            $shortLink = $baseShortLink . '-' . $counter;
            $counter++;
        }

        $this->short_link = $shortLink;

        LivewireAlert::title('Short link generated!')
            ->text('Generated: ema.id/' . $shortLink)
            ->position('top-end')
            ->timer(3000)
            ->toast()
            ->success()
            ->show();
    }
}
