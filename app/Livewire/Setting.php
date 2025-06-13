<?php

namespace App\Livewire;

use App\Models\Setting as ModelSetting;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Title;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;

class Setting extends Component
{
    use WithFileUploads;

    public $school_name;
    public $address;
    public $phone;
    public $email;
    public $current_logo;
    public $logo;
    public $chairman;
    public $nip;
    public $setting_id;

    protected $rules = [
        'school_name' => 'required|string|max:255',
        'address' => 'nullable|string',
        'phone' => 'nullable|string|max:20',
        'email' => 'nullable|email|max:255',
        'logo' => 'nullable|image|max:1024',
        'chairman' => 'required|string|max:255',
        'nip' => 'nullable|string|max:50',
    ];

    #[Title('School Settings')]
    public function mount()
    {
        $setting = ModelSetting::first();
        if ($setting) {
            $this->setting_id = $setting->id;
            $this->school_name = $setting->school_name;
            $this->address = $setting->address;
            $this->phone = $setting->phone;
            $this->email = $setting->email;
            $this->current_logo = $setting->logo;
            $this->chairman = $setting->chairman;
            $this->nip = $setting->nip;
        }
    }

    public function save()
    {
        $this->validate();

        try {
            $data = [
                'school_name' => $this->school_name,
                'address' => $this->address,
                'phone' => $this->phone,
                'email' => $this->email,
                'chairman' => $this->chairman,
                'nip' => $this->nip,
            ];

            // Handle logo upload if provided
            if ($this->logo) {
                // Remove old logo if it exists
                if ($this->current_logo && Storage::exists('public/' . $this->current_logo)) {
                    Storage::delete('public/' . $this->current_logo);
                }

                // Store the new logo
                $path = $this->logo->store('logos', 'public');
                $data['logo'] = str_replace('public/', '', $path);
                $this->current_logo = $data['logo'];
            }

            if ($this->setting_id) {
                // Update existing settings
                $setting = ModelSetting::find($this->setting_id);
                $setting->update($data);
                $message = 'School settings updated successfully!';
            } else {
                // Create new settings
                ModelSetting::create($data);
                $message = 'School settings created successfully!';
                // Get the newly created setting for next edit
                $this->setting_id = ModelSetting::first()->id;
            }

            // Reset the file input
            $this->logo = null;

            LivewireAlert::title($message)
                ->position('top-end')
                ->timer(3000)
                ->toast()
                ->success()
                ->show();

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

    public function render()
    {
        return view('livewire.setting');
    }
}
