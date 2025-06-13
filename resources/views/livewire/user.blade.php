<div>
    <div class="card dark:bg-zinc-800 dark:border-zinc-600">
        <div class="flex justify-between p-5 border-b card-header border-gray-50 dark:border-zinc-600 middle">
            <h5 class="text-gray-600 uppercase dark:text-gray-100">User Management</h5>
            <div class="flex flex-row gap-2">
                <x-button-default variant="primary" loading-target="create" wire:click="openModal('md', 'saveUser', 'cancelModal', 'Save User')">
                    Create User
                </x-button-default>
            </div>
        </div>
        <div class="card-body">
            <div class="flex flex-row items-center justify-between">
                <div>
                    <h6 class="mb-1 text-gray-700 text-15 dark:text-gray-100">User List</h6>
                    <p class="text-gray-600 card-text dark:text-zinc-100">Manage all users in the system</p>
                </div>
                <x-form-input name="search" label="" placeholder="Type Name or Email..." required="true" hasIcon="true" iconClass="bx bx-search-alt text-gray-600 dark:text-gray-200"  autocomplete="false"/>
            </div>
            <div class="mt-6">
                <div class="overflow-x-auto">
                    <table class="w-full min-w-full table-auto">
                        <thead class="bg-gray-50 dark:bg-zinc-700">
                            <tr>
                                <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-700 uppercase dark:text-gray-300">
                                    No
                                </th>
                                <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-700 uppercase dark:text-gray-300">
                                    Name
                                </th>
                                <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-700 uppercase dark:text-gray-300">
                                    Email
                                </th>
                                <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-700 uppercase dark:text-gray-300">
                                    Role
                                </th>
                                <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-700 uppercase dark:text-gray-300">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200 dark:bg-zinc-800 dark:divide-zinc-600">
                            @foreach($users as $user)
                            <tr>
                                <td class="px-6 py-4 text-sm text-gray-900 whitespace-nowrap dark:text-gray-100">{{($users->currentpage() - 1) * $users->perpage() + $loop->index + 1}}</td>
                                <td class="px-6 py-4 text-sm text-gray-900 whitespace-nowrap dark:text-gray-100">
                                    {{ $user->name }}
                                    @if (Auth::user()->id == $user->id)
                                        <span class="px-2.5 py-0.5 text-xs rounded-full font-medium bg-blue-100 text-blue-800 dark:bg-blue-800 dark:text-blue-100">
                                            Me
                                        </span>

                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap dark:text-gray-300">{{ $user->email }}</td>
                                <td class="flex gap-2 px-6 py-4 text-sm text-gray-500 whitespace-nowrap dark:text-gray-300">
                                    @foreach($user->roles as $role)
                                        @if ($role->name == 'admin')
                                            <span class="px-2.5 py-0.5 text-xs rounded-full font-medium bg-red-100 text-red-800 dark:bg-red-800 dark:text-red-100">
                                                {{ $role->name }}
                                            </span>
                                        @elseif ($role->name == 'student')
                                            <span class="px-2.5 py-0.5 text-xs rounded-full font-medium bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100">
                                                {{ $role->name }}
                                            </span>
                                        @elseif ($role->name == 'teacher')
                                            <span class="px-2.5 py-0.5 text-xs rounded-full font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-800 dark:text-yellow-100">
                                                {{ $role->name }}
                                            </span>
                                        @endif
                                    @endforeach
                                </td>
                                <td class="px-6 py-4 text-sm font-medium whitespace-nowrap">
                                    <div class="flex space-x-2">
                                        <button wire:click="edit({{ $user->id }})" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-200">
                                            <i class="bx bx-pencil"></i>
                                        </button>
                                        @if (Auth::user()->id != $user->id)
                                        <button wire:click="confirmDelete({{ $user->id }})" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-200">
                                                <i class=" bx bx-trash-alt"></i>
                                        </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>

    <!-- Dynamic Modal Component -->
    <x-dynamic-modal
        :id="$modalId"
        :size="$modalSize"
        :title="$modalTitle"
        :save-label="$modalSaveLabel"
        :save-function="$modalSaveFunction"
        :cancel-function="$modalCancelFunction"
        :save-button-color="$modalSaveButtonColor"
        :is-open="$showModal">

        <div class="space-y-4">
            <div class="space-y-3">
                <x-form-input name="name" label="Name" placeholder="Enter name" required="true" hasIcon="true"/>
                <x-form-input name="email" label="Email" type="email" placeholder="Enter user email" required="true" hasIcon="true"/>
                <x-form-input name="password" label="Password" type="password" placeholder="{{ $isEditMode ? 'Leave blank to keep current password' : 'Enter user password' }}" required="{{ !$isEditMode }}" hasIcon="true"/>

                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Roles</label>
                    <div class="space-y-2">
                        @foreach ($roles as $role)
                            <div class="flex items-center gap-2">
                                <input class="rounded form-checkbox" type="checkbox" id="{{ strtolower($role->name) }}" value="{{ $role->name }}" wire:model="role_ids">
                                <label class="ms-1.5" for="{{ strtolower($role->name) }}">{{ $role->name }}</label>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </x-dynamic-modal>
</div>
