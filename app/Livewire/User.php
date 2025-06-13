<?php

namespace App\Livewire;

use App\Models\User as UserModel;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Title;
use Spatie\Permission\Models\Role;

class User extends Component
{
    use WithPagination;

    // User data properties
    public $name;
    public $email;
    public $password;
    public $roles;
    public $role_ids = [];
    public $userId;

    public $search = '';

    // Original modal properties
    public $isModalOpen = false;
    public $isEditMode = false;

    // Dynamic modal properties
    public $showModal = false;
    public $modalId = 'dynamicUserModal';
    public $modalSize = 'md';
    public $modalTitle = 'User Management';
    public $modalSaveLabel = 'Save';
    public $modalSaveFunction = 'saveUser';
    public $modalCancelFunction = 'cancelModal';
    public $modalSaveButtonColor = 'violet';
    // New backdrop properties
    public $backdropColor = 'black';
    public $backdropOpacity = '50';
    public $backdropBlur = false;
    public $closeOnBackdropClick = true;
    public $zIndex = '50';

    #[Title('User Management')]

    public function mount()
    {
        $this->roles = Role::all();
    }

    public function render()
    {
        $users = UserModel::with('roles')
                ->where('name', 'like', '%' . $this->search . '%')
                ->orWhere('email', 'like', '%' . $this->search . '%')
                ->paginate(10);
        $roles = Role::all();

        return view('livewire.user', [
            'users' => $users,
            'roles' => $roles
        ]);
    }

    public function create()
    {
        $this->resetInputFields();
        $this->openModal();
        $this->isEditMode = false;
    }

    public function closeModal()
    {
        $this->isModalOpen = false;
    }

    // Dynamic modal methods
    public function openModal(
        $size = 'md',
        $saveFunction = 'saveUser',
        $cancelFunction = 'cancelModal',
        $saveLabel = 'Save',
        $saveButtonColor = 'violet',
        $title = 'User Management',
        $backdropOptions = []
    ) {
        $this->modalSize = $size;
        $this->modalSaveFunction = $saveFunction;
        $this->modalCancelFunction = $cancelFunction;
        $this->modalSaveLabel = $saveLabel;
        $this->modalSaveButtonColor = $saveButtonColor;
        $this->modalTitle = $title;

        // Apply backdrop options if provided
        if (!empty($backdropOptions)) {
            if (isset($backdropOptions['color'])) {
                $this->backdropColor = $backdropOptions['color'];
            }
            if (isset($backdropOptions['opacity'])) {
                $this->backdropOpacity = $backdropOptions['opacity'];
            }
            if (isset($backdropOptions['blur'])) {
                $this->backdropBlur = $backdropOptions['blur'];
            }
            if (isset($backdropOptions['closeOnClick'])) {
                $this->closeOnBackdropClick = $backdropOptions['closeOnClick'];
            }
            if (isset($backdropOptions['zIndex'])) {
                $this->zIndex = $backdropOptions['zIndex'];
            }
        }

        $this->showModal = true;
    }

    public function saveUser()
    {
        $this->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email' . ($this->userId ? ",$this->userId" : ''),
        ]);

        if ($this->userId) {
            $user = UserModel::find($this->userId);
            $user->update([
                'name' => $this->name,
                'email' => $this->email,
                'password' => $this->password ? Hash::make($this->password) : $user->password,
            ]);

            // Update roles if needed
            if (!empty($this->role_ids)) {
                $user->syncRoles($this->role_ids);
            } else {
                // Remove all roles if none selected
                $user->syncRoles([]);
            }

            // Show success alert with SweetAlert2
            LivewireAlert::title('User updated successfully!')
                ->position('top-end')
                ->timer(3000)
                ->toast()
                ->success()
                ->show();
        } else {
            // Create a random password if none provided
            $password = $this->password ?? \Illuminate\Support\Str::random(10);

            $user = UserModel::create([
                'name' => $this->name,
                'email' => $this->email,
                'password' => Hash::make($password),
            ]);

            // Assign roles if needed
            if (!empty($this->role_ids)) {
                $user->assignRole($this->role_ids);
            }

            // Show success alert with SweetAlert2
            LivewireAlert::title('User created successfully!')
                ->position('top-end')
                ->timer(3000)
                ->toast()
                ->success()
                ->show();
        }

        $this->cancelModal();
    }

    public function cancelModal()
    {
        $this->showModal = false;
        $this->resetInputFields();
    }

    private function resetInputFields()
    {
        $this->name = '';
        $this->email = '';
        $this->password = '';
        $this->roles = [];
        $this->userId = '';
    }

    public function edit($id)
    {
        $user = UserModel::findOrFail($id);
        $this->userId = $id;
        $this->name = $user->name;
        $this->email = $user->email;

        // Get all roles assigned to the user
        $this->role_ids = $user->roles->pluck('name')->toArray();

        $this->isEditMode = true;

        $this->openModal();
    }

    public function confirmDelete($id)
    {
        LivewireAlert::title('Are you sure you want to delete this user?')
            ->withConfirmButton('Yes, delete it!', '#d33')
            ->withCancelButton('Cancel', '#3085d6')
            ->onConfirm('deleteUser', [$this->userId = $id])
            ->warning()
            ->show();

        $this->userId = $id;
    }

    public function deleteUser()
    {
        $user = UserModel::find($this->userId);

        if ($user) {
            $user->delete();
            LivewireAlert::title('User deleted successfully!')
                ->position('top-end')
                ->timer(3000)
                ->toast()
                ->success()
                ->show();
        }
    }
}
