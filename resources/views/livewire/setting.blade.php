<div>
    <div class="card dark:bg-zinc-800 dark:border-zinc-600">
        <div class="flex justify-between p-5 border-b card-header border-gray-50 dark:border-zinc-600 middle">
            <h5 class="text-gray-600 uppercase dark:text-gray-100">School Settings</h5>
        </div>
        <div class="card-body">
            <div class="flex flex-col">
                <div>
                    <h6 class="mb-1 text-gray-700 text-15 dark:text-gray-100">General Information</h6>
                    <p class="text-gray-600 card-text dark:text-zinc-100">Manage school information and appearance</p>
                </div>

                <form wire:submit.prevent="save" class="mt-6 space-y-5">
                    <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
                        <!-- School Name -->
                        <div>
                            <x-form-input name="school_name" label="School Name" placeholder="Enter school name" required="true" hasIcon="true">
                                <x-slot:icon>
                                    <i class="text-gray-500 bx bx-building dark:text-gray-400"></i>
                                </x-slot:icon>
                            </x-form-input>
                        </div>

                        <!-- Email -->
                        <div>
                            <x-form-input name="email" label="Email" type="email" placeholder="Enter email address" hasIcon="true">
                                <x-slot:icon>
                                    <i class="text-gray-500 bx bx-envelope dark:text-gray-400"></i>
                                </x-slot:icon>
                            </x-form-input>
                        </div>

                        <!-- Phone Number -->
                        <div>
                            <x-form-input name="phone" label="Phone Number" placeholder="Enter phone number" hasIcon="true">
                                <x-slot:icon>
                                    <i class="text-gray-500 bx bx-phone dark:text-gray-400"></i>
                                </x-slot:icon>
                            </x-form-input>
                        </div>

                        <!-- Logo -->
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">School Logo (1:1)</label>
                            <div class="relative flex items-center space-x-4">
                                <div class="flex items-center justify-center w-24 h-24 overflow-hidden bg-gray-100 border border-gray-300 rounded-md dark:bg-zinc-700 dark:border-zinc-600">
                                    @if($current_logo)
                                        <img src="{{ Storage::url($current_logo) }}" alt="Current Logo" class="object-cover w-full h-full">
                                    @else
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 text-gray-400 dark:text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    @endif
                                </div>
                                <div class="flex-1">
                                    <div class="relative">
                                        <label for="logo-upload" class="inline-flex items-center px-4 py-2 text-xs font-semibold tracking-widest text-gray-700 uppercase transition duration-150 ease-in-out bg-white border border-gray-300 rounded-md shadow-sm cursor-pointer dark:bg-zinc-700 dark:border-zinc-600 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-zinc-600 focus:outline-none">
                                            <i class="mr-2 text-gray-500 bx bx-upload dark:text-gray-400"></i>
                                            <span>Choose Logo</span>
                                            <input id="logo-upload" type="file" wire:model="logo" class="sr-only" accept="image/*">
                                        </label>
                                        @if($logo)
                                            <div class="flex mt-1">
                                                <div class="flex-1 text-sm text-gray-600 truncate dark:text-gray-300">
                                                    {{ $logo->getClientOriginalName() }}
                                                </div>
                                                <button type="button" wire:click="$set('logo', null)" class="text-red-500 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300 focus:outline-none">
                                                    <i class="bx bx-trash"></i>
                                                </button>
                                            </div>
                                        @else
                                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">PNG, JPG, GIF up to 1MB (preferably square image)</p>
                                        @endif
                                        @error('logo') <span class="block mt-1 text-sm text-red-500">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Chairman (Kepala Sekolah) -->
                        <div>
                            <x-form-input name="chairman" label="Chairman (Kepala Sekolah)" placeholder="Enter chairman name" required="true" hasIcon="true">
                                <x-slot:icon>
                                    <i class="text-gray-500 bx bx-user dark:text-gray-400"></i>
                                </x-slot:icon>
                            </x-form-input>
                        </div>

                        <!-- NIP -->
                        <div>
                            <x-form-input name="nip" label="NIP" placeholder="Enter NIP" hasIcon="true">
                                <x-slot:icon>
                                    <i class="text-gray-500 bx bx-id-card dark:text-gray-400"></i>
                        </x-button-default>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
