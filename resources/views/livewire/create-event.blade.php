<div class="min-h-screen">
    <div class="mx-auto">
        <!-- Header -->
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-100">{{ $isEditMode ? 'Edit Event' : 'Create Event' }}</h1>
                <p class="mt-2 text-gray-400">{{ $isEditMode ? 'Update your event details' : 'Set up your new event in minutes' }}</p>
            </div>
            <button
                wire:click="$dispatch('navigateBack')"
                class="flex items-center gap-2 px-4 py-2 text-sm font-medium text-gray-300 transition-all duration-200 border rounded-lg bg-zinc-800/50 backdrop-blur-sm border-zinc-700/50 hover:border-zinc-600/70 hover:bg-zinc-800/70"
            >
                <i class="bx bx-arrow-back"></i>
                Back to Events
            </button>
        </div>

        <!-- Main Form Card -->
        <div class="overflow-hidden border shadow-2xl rounded-2xl bg-zinc-800/30 backdrop-blur-sm border-zinc-700/50">
            <div class="p-8">
                <form wire:submit.prevent="saveEvent" class="space-y-8">
                    <!-- Event Details Section -->
                <div class="space-y-6">
                    <h2 class="flex items-center text-xl font-semibold text-gray-100">
                        <i class="mr-3 text-blue-400 bx bx-calendar-event"></i>
                        Event Details
                    </h2>

                    <!-- Event Name -->
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-300">Event Name</label>
                        <input
                            type="text"
                            wire:model="name"
                            placeholder="Enter your event name"
                            class="w-full px-4 py-3 text-gray-100 placeholder-gray-400 transition-all duration-200 border rounded-lg bg-zinc-800/50 backdrop-blur-sm border-zinc-700/50 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            required
                        >
                        @if($errors->has('name'))
                            <span class="text-sm text-red-400">{{ $errors->first('name') }}</span>
                        @endif
                    </div>

                    <!-- Event Image -->
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-300">Event Image</label>
                        <div class="flex items-center justify-center w-full">
                            <label class="flex flex-col items-center justify-center w-full h-32 border-2 border-dashed rounded-lg cursor-pointer border-zinc-600 hover:border-zinc-500 bg-zinc-800/30 hover:bg-zinc-800/50">
                                @if($image)
                                    <img src="{{ $image->temporaryUrl() }}" class="object-cover w-full h-full rounded-lg">
                                @else
                                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                        <i class="mb-2 text-3xl text-zinc-400 bx bx-image-add"></i>
                                        <p class="text-sm text-zinc-400">Click to upload event image</p>
                                    </div>
                                @endif
                                <input type="file" wire:model="image" accept="image/*" class="hidden" />
                            </label>
                        </div>
                        @if($errors->has('image'))
                            <span class="text-sm text-red-400">{{ $errors->first('image') }}</span>
                        @endif
                    </div>

                    <!-- Host Selection -->
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-300">Event Host</label>
                        <select
                            wire:model="host_id"
                            class="w-full px-4 py-3 text-gray-100 transition-all duration-200 border rounded-lg bg-zinc-800/50 backdrop-blur-sm border-zinc-700/50 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            required
                        >
                            <option value="">Select a host</option>
                            @foreach($hosts as $host)
                                <option value="{{ $host->id }}">{{ $host->name }}</option>
                            @endforeach
                        </select>
                        @if($errors->has('host_id'))
                            <span class="text-sm text-red-400">{{ $errors->first('host_id') }}</span>
                        @endif
                    </div>

                    <!-- Status -->
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-300">Status</label>
                        <select
                            wire:model="status"
                            class="w-full px-4 py-3 text-gray-100 transition-all duration-200 border rounded-lg bg-zinc-800/50 backdrop-blur-sm border-zinc-700/50 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            required
                        >
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                            <option value="cancelled">Cancelled</option>
                        </select>
                        @if($errors->has('status'))
                            <span class="text-sm text-red-400">{{ $errors->first('status') }}</span>
                        @endif
                    </div>

                    <!-- Short Link -->
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-300">Short Link (Optional)</label>
                        <div class="flex transition-all duration-200 border rounded-lg border-zinc-700/50 bg-zinc-800/50 backdrop-blur-sm focus-within:ring-2 focus-within:ring-blue-500 focus-within:border-blue-500">
                            <span class="inline-flex items-center px-3 text-sm text-gray-300 border-r rounded-l-lg bg-zinc-700/50 border-zinc-600/50">
                                ema.id/
                            </span>
                            <input
                                type="text"
                                wire:model.live.debounce.500ms="short_link"
                                placeholder="my-event-link"
                                class="flex-1 px-4 py-3 text-gray-100 placeholder-gray-400 bg-transparent border-0 focus:ring-0 focus:outline-none"
                            />
                            <button
                                type="button"
                                wire:click="generateShortLink"
                                class="inline-flex items-center px-3 py-3 text-sm font-medium text-gray-300 transition-all duration-200 border-l rounded-r-lg bg-zinc-700/50 border-zinc-600/50 hover:bg-zinc-600/50"
                                title="Generate from event name"
                            >
                                <i class="text-sm bx bx-refresh"></i>
                            </button>
                        </div>
                        @if($errors->has('short_link'))
                            <span class="text-sm text-red-400">{{ $errors->first('short_link') }}</span>
                        @endif
                        <p class="text-xs text-gray-400">
                            Optional. Use only letters, numbers, hyphens, and underscores. Leave empty for no short link.
                        </p>
                    </div>
                </div>

                <!-- Date & Time Section -->
                <div class="space-y-6">
                    <h2 class="flex items-center text-xl font-semibold text-gray-100">
                        <i class="mr-3 text-green-400 bx bx-time"></i>
                        Date & Time
                    </h2>

                    <!-- Registration Dates -->
                    <div class="p-4 border rounded-lg border-zinc-700/50 bg-zinc-800/20">
                        <h3 class="mb-4 text-lg font-medium text-gray-200">Registration Period</h3>
                        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                            <div class="space-y-2">
                                <label class="block text-sm font-medium text-gray-300">Registration Start Date</label>
                                <input
                                    type="datetime-local"
                                    wire:model="registration_start_date"
                                    class="w-full px-4 py-3 text-gray-100 transition-all duration-200 border rounded-lg bg-zinc-800/50 backdrop-blur-sm border-zinc-700/50 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                    required
                                >
                                @if($errors->has('registration_start_date'))
                                    <span class="text-sm text-red-400">{{ $errors->first('registration_start_date') }}</span>
                                @endif
                            </div>

                            <div class="space-y-2">
                                <label class="block text-sm font-medium text-gray-300">Registration End Date</label>
                                <input
                                    type="datetime-local"
                                    wire:model="registration_end_date"
                                    class="w-full px-4 py-3 text-gray-100 transition-all duration-200 border rounded-lg bg-zinc-800/50 backdrop-blur-sm border-zinc-700/50 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                    required
                                >
                                @if($errors->has('registration_end_date'))
                                    <span class="text-sm text-red-400">{{ $errors->first('registration_end_date') }}</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Event Dates -->
                    <div class="p-4 border rounded-lg border-zinc-700/50 bg-zinc-800/20">
                        <h3 class="mb-4 text-lg font-medium text-gray-200">Event Period</h3>
                        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                            <div class="space-y-2">
                                <label class="block text-sm font-medium text-gray-300">Event Start Date</label>
                                <input
                                    type="datetime-local"
                                    wire:model="start_date"
                                    class="w-full px-4 py-3 text-gray-100 transition-all duration-200 border rounded-lg bg-zinc-800/50 backdrop-blur-sm border-zinc-700/50 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                    required
                                >
                                @if($errors->has('start_date'))
                                    <span class="text-sm text-red-400">{{ $errors->first('start_date') }}</span>
                                @endif
                            </div>

                            <div class="space-y-2">
                                <label class="block text-sm font-medium text-gray-300">Event End Date</label>
                                <input
                                    type="datetime-local"
                                    wire:model="end_date"
                                    class="w-full px-4 py-3 text-gray-100 transition-all duration-200 border rounded-lg bg-zinc-800/50 backdrop-blur-sm border-zinc-700/50 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                    required
                                >
                                @if($errors->has('end_date'))
                                    <span class="text-sm text-red-400">{{ $errors->first('end_date') }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Location Section -->
                <div class="space-y-6">
                    <h2 class="flex items-center text-xl font-semibold text-gray-100">
                        <i class="mr-3 text-purple-400 bx bx-map"></i>
                        Location
                    </h2>

                    <!-- Location Type Toggle -->
                    <div class="flex p-1 space-x-1 border rounded-lg bg-zinc-800/50 backdrop-blur-sm border-zinc-700/50">
                        <button
                            type="button"
                            wire:click="$set('location_type', 'physical')"
                            class="flex-1 px-4 py-2 text-sm font-medium rounded-md transition-all duration-200 {{ $location_type === 'physical' ? 'bg-blue-600 text-white shadow-lg' : 'text-gray-400 hover:text-gray-200 hover:bg-zinc-700/50' }}"
                        >
                            <i class="mr-2 bx bx-building"></i>
                            Physical Location
                        </button>
                        <button
                            type="button"
                            wire:click="$set('location_type', 'virtual')"
                            class="flex-1 px-4 py-2 text-sm font-medium rounded-md transition-all duration-200 {{ $location_type === 'virtual' ? 'bg-blue-600 text-white shadow-lg' : 'text-gray-400 hover:text-gray-200 hover:bg-zinc-700/50' }}"
                        >
                            <i class="mr-2 bx bx-video"></i>
                            Virtual Event
                        </button>
                    </div>

                    @if($location_type === 'physical')
                        <div class="space-y-4">
                            <!-- Venue Address -->
                            <div class="space-y-2">
                                <label class="block text-sm font-medium text-gray-300">Venue Address</label>
                                <input
                                    type="text"
                                    wire:model="location_address"
                                    placeholder="Enter venue address or location"
                                    class="w-full px-4 py-3 text-gray-100 placeholder-gray-400 transition-all duration-200 border rounded-lg bg-zinc-800/50 backdrop-blur-sm border-zinc-700/50 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                >
                                @if($errors->has('location_address'))
                                    <span class="text-sm text-red-400">{{ $errors->first('location_address') }}</span>
                                @endif
                            </div>

                            <!-- Google Maps URL -->
                            <div class="space-y-2">
                                <label class="block text-sm font-medium text-gray-300">Google Maps Link (Optional)</label>
                                <input
                                    type="url"
                                    wire:model="location_url"
                                    placeholder="https://maps.google.com/..."
                                    class="w-full px-4 py-3 text-gray-100 placeholder-gray-400 transition-all duration-200 border rounded-lg bg-zinc-800/50 backdrop-blur-sm border-zinc-700/50 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                >
                                @if($errors->has('location_url'))
                                    <span class="text-sm text-red-400">{{ $errors->first('location_url') }}</span>
                                @endif
                                <p class="text-xs text-gray-400">
                                    Paste a Google Maps link for easy navigation
                                </p>
                            </div>
                            <p class="text-xs text-gray-400">
                                Optional GPS coordinates for precise location mapping
                            </p>
                        </div>
                    @else
                        <div class="space-y-4">
                            <!-- Meeting Link -->
                            <div class="space-y-2">
                                <label class="block text-sm font-medium text-gray-300">Meeting Link</label>
                                <input
                                    type="url"
                                    wire:model="location_url"
                                    placeholder="https://zoom.us/j/... or meeting platform link"
                                    class="w-full px-4 py-3 text-gray-100 placeholder-gray-400 transition-all duration-200 border rounded-lg bg-zinc-800/50 backdrop-blur-sm border-zinc-700/50 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                >
                                @if($errors->has('location_url'))
                                    <span class="text-sm text-red-400">{{ $errors->first('location_url') }}</span>
                                @endif
                                <p class="text-xs text-gray-400">
                                    Zoom, Google Meet, Teams, or other video conferencing link
                                </p>
                            </div>

                            <!-- Platform Details -->
                            <div class="space-y-2">
                                <label class="block text-sm font-medium text-gray-300">Platform Details (Optional)</label>
                                <input
                                    type="text"
                                    wire:model="location_address"
                                    placeholder="e.g., Meeting ID: 123-456-789, Passcode: abc123"
                                    class="w-full px-4 py-3 text-gray-100 placeholder-gray-400 transition-all duration-200 border rounded-lg bg-zinc-800/50 backdrop-blur-sm border-zinc-700/50 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                >
                                @if($errors->has('location_address'))
                                    <span class="text-sm text-red-400">{{ $errors->first('location_address') }}</span>
                                @endif
                                <p class="text-xs text-gray-400">
                                    Additional details like meeting ID, passcode, or platform instructions
                                </p>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Event Options Section -->
                <div class="space-y-6">
                    <h2 class="flex items-center text-xl font-semibold text-gray-100">
                        <i class="mr-3 text-orange-400 bx bx-cog"></i>
                        Event Options
                    </h2>

                    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                        <!-- Ticket Price -->
                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-gray-300">Ticket Price</label>
                            <div class="relative">
                                <span class="absolute flex items-center text-sm text-gray-300 left-3 top-4">
                                    Rp
                                </span>
                                <input
                                    type="number"
                                    step="1000"
                                    wire:model="ticket_price"
                                    placeholder="0 (Free event)"
                                    class="w-full py-3 pl-10 pr-4 text-gray-100 placeholder-gray-400 transition-all duration-200 border rounded-lg bg-zinc-800/50 backdrop-blur-sm border-zinc-700/50 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                >
                            </div>
                            @if($errors->has('ticket_price'))
                                <span class="text-sm text-red-400">{{ $errors->first('ticket_price') }}</span>
                            @endif
                            <p class="text-xs text-gray-400">
                                Leave empty or set to 0 for free events
                            </p>
                        </div>

                        <!-- Capacity -->
                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-gray-300">Capacity</label>
                            <input
                                type="number"
                                wire:model="capacity"
                                placeholder="Unlimited"
                                class="w-full px-4 py-3 text-gray-100 placeholder-gray-400 transition-all duration-200 border rounded-lg bg-zinc-800/50 backdrop-blur-sm border-zinc-700/50 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            >
                            @if($errors->has('capacity'))
                                <span class="text-sm text-red-400">{{ $errors->first('capacity') }}</span>
                            @endif
                        </div>
                    </div>

                    <!-- Event Settings -->
                    <div class="space-y-4">
                        <div class="flex items-center p-4 transition-all duration-200 border rounded-lg border-zinc-700/50 hover:border-zinc-600/70 hover:bg-zinc-800/40">
                            <input
                                type="checkbox"
                                id="require_approval"
                                wire:model="require_approval"
                                class="w-5 h-5 text-blue-600 transition-colors duration-200 bg-transparent border-2 rounded border-zinc-600 focus:ring-blue-500 focus:ring-2"
                            >
                            <label for="require_approval" class="ml-3 text-gray-300 cursor-pointer">
                                <span class="font-medium">Require Approval</span>
                                <span class="block text-sm text-gray-400">Manually approve each registration</span>
                            </label>
                        </div>

                        <div class="flex items-center p-4 transition-all duration-200 border rounded-lg border-zinc-700/50 hover:border-zinc-600/70 hover:bg-zinc-800/40">
                            <input
                                type="checkbox"
                                id="is_public"
                                wire:model="is_public"
                                class="w-5 h-5 text-blue-600 transition-colors duration-200 bg-transparent border-2 rounded border-zinc-600 focus:ring-blue-500 focus:ring-2"
                            >
                            <label for="is_public" class="ml-3 text-gray-300 cursor-pointer">
                                <span class="font-medium">Public Event</span>
                                <span class="block text-sm text-gray-400">Anyone can discover and view this event</span>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Description Section -->
                <div class="space-y-6">
                    <h2 class="flex items-center text-xl font-semibold text-gray-100">
                        <i class="mr-3 text-pink-400 bx bx-edit"></i>
                        Description
                    </h2>

                    <div class="space-y-2">
                        <label class="flex items-center text-sm font-medium text-gray-300">
                            <i class="mr-2 text-gray-400 bx bx-text"></i>
                            Event Description
                        </label>
                        <div class="overflow-hidden transition-all duration-200 border rounded-lg bg-zinc-800/50 backdrop-blur-sm border-zinc-700/50 focus-within:ring-2 focus-within:ring-blue-500 focus-within:border-blue-500">
                            <div
                                id="quill-editor"
                                wire:ignore.self
                                class="min-h-[200px]"
                                data-description="{{ $desc }}"
                            ></div>
                        </div>
                        <textarea
                            wire:model.live.debounce.500ms="desc"
                            id="desc-input"
                            class="hidden"
                        ></textarea>
                        @if($errors->has('desc'))
                            <span class="flex items-center text-sm text-red-400">
                                <i class="mr-1 bx bx-error-circle"></i>
                                {{ $errors->first('desc') }}
                            </span>
                        @endif
                        <p class="flex items-start text-xs text-gray-400">
                            <i class="mr-2 mt-0.5 bx bx-info-circle"></i>
                            <span>Describe your event in detail - include agenda, schedule, what attendees can expect, requirements, and any important information participants should know.</span>
                        </p>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex justify-end gap-4 pt-6">
                    <button
                        type="button"
                        wire:click="$dispatch('navigateBack')"
                        class="px-6 py-3 text-sm font-medium text-gray-300 transition-all duration-200 border rounded-lg bg-zinc-800/50 backdrop-blur-sm border-zinc-700/50 hover:border-zinc-600/70 hover:bg-zinc-800/70"
                    >
                        Cancel
                    </button>
                    <button
                        type="submit"
                        class="flex items-center gap-2 px-6 py-3 text-sm font-medium text-white transition-all duration-200 bg-gradient-to-r from-blue-500 to-blue-600 rounded-lg hover:from-blue-600 hover:to-blue-700 shadow-sm hover:shadow-md transform hover:-translate-y-0.5"
                        wire:loading.attr="disabled"
                    >
                        <i class="bx bx-save" wire:loading.remove wire:target="saveEvent"></i>
                        <i class="bx bx-loader bx-spin" wire:loading wire:target="saveEvent"></i>
                        <span wire:loading.remove wire:target="saveEvent">{{ $isEditMode ? 'Update Event' : 'Create Event' }}</span>
                        <span wire:loading wire:target="saveEvent">{{ $isEditMode ? 'Updating...' : 'Creating...' }}</span>
                    </button>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<!-- Quill.js CSS -->
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">

<!-- Quill.js JS -->
<script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>

<script>
(function() {
    let quill = null;
    let isInitialized = false;
    let initializationAttempts = 0;
    const maxAttempts = 3;

    function destroyQuill() {
        if (quill) {
            try {
                // Save current content before destroying
                const currentContent = quill.root.innerHTML;
                const hiddenInput = document.getElementById('desc-input');
                if (hiddenInput && currentContent) {
                    hiddenInput.value = currentContent;
                }

                // Remove all event listeners
                quill.off('text-change');
                quill = null;
                console.log('Quill editor destroyed and content preserved');
            } catch (e) {
                console.log('Error destroying Quill:', e);
            }
        }
        isInitialized = false;
    }    function initializeQuillEditor() {
        const editorElement = document.getElementById('quill-editor');

        // Prevent multiple initializations
        if (isInitialized || !editorElement || initializationAttempts >= maxAttempts) {
            return;
        }

        // Check if already has Quill content
        if (editorElement.querySelector('.ql-toolbar') || editorElement.classList.contains('ql-container')) {
            console.log('Quill already initialized, skipping...');
            return;
        }

        initializationAttempts++;

        try {
            // Preserve existing content if any (important for validation failures)
            let existingContent = '';
            const hiddenInput = document.getElementById('desc-input');
            if (hiddenInput && hiddenInput.value) {
                existingContent = hiddenInput.value;
            }

            // Clear any existing content in the editor element
            editorElement.innerHTML = '';

            // Initialize Quill editor
            quill = new Quill('#quill-editor', {
                theme: 'snow',
                modules: {
                    toolbar: [
                        [{ 'header': [1, 2, 3, false] }],
                        ['bold', 'italic', 'underline', 'strike'],
                        [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                        [{ 'indent': '-1'}, { 'indent': '+1' }],
                        ['link'],
                        [{ 'align': [] }],
                        [{ 'color': [] }, { 'background': [] }],
                        ['clean']
                    ]
                },
                placeholder: 'Describe your event details, agenda, what attendees can expect, and any important information...'
            });

            // Set content - prioritize hidden input (preserved content) over initial content
            const initialContent = @json($desc ?? '');
            const contentToSet = existingContent || initialContent;

            if (contentToSet && contentToSet.trim() !== '' && contentToSet !== '<p><br></p>') {
                quill.root.innerHTML = contentToSet;
                // Sync with hidden input
                if (hiddenInput) {
                    hiddenInput.value = contentToSet;
                }
            }

            // Sync Quill editor content with Livewire (with debouncing)
            let debounceTimer;
            quill.on('text-change', function(delta, oldDelta, source) {
                if (source === 'user') {
                    clearTimeout(debounceTimer);
                    debounceTimer = setTimeout(() => {
                        const html = quill.root.innerHTML;
                        const hiddenInput = document.getElementById('desc-input');
                        if (hiddenInput) {
                            hiddenInput.value = html;
                            // Use Livewire's set method to update the property
                            if (typeof @this !== 'undefined') {
                                @this.set('desc', html);
                            }
                        }
                    }, 300); // Reduced debounce time
                }
            });

            // Apply dark theme styles
            setTimeout(() => {
                applyDarkTheme();
            }, 100);

            isInitialized = true;
            console.log('Quill editor initialized successfully', {
                attempt: initializationAttempts,
                hasContent: !!contentToSet
            });

        } catch (error) {
            console.error('Failed to initialize Quill editor:', error);
            isInitialized = false;
        }
    }

    function applyDarkTheme() {
        const quillContainer = document.querySelector('#quill-editor');
        if (!quillContainer) return;

        // Style the editor content area
        const editor = quillContainer.querySelector('.ql-editor');
        if (editor) {
            editor.style.backgroundColor = 'rgba(39, 39, 42, 0.8)';
            editor.style.color = '#f3f4f6';
            editor.style.border = 'none';
            editor.style.minHeight = '200px';
            editor.style.fontSize = '14px';
            editor.style.lineHeight = '1.6';
            editor.style.padding = '16px';
        }

        // Style the toolbar
        const toolbar = quillContainer.querySelector('.ql-toolbar');
        if (toolbar) {
            toolbar.style.backgroundColor = 'rgba(63, 63, 70, 0.8)';
            toolbar.style.border = 'none';
            toolbar.style.borderBottom = '1px solid rgba(82, 82, 91, 0.5)';
            toolbar.style.borderTopLeftRadius = '6px';
            toolbar.style.borderTopRightRadius = '6px';
            toolbar.style.padding = '8px';
        }

        // Style toolbar buttons and elements
        const toolbarButtons = quillContainer.querySelectorAll('.ql-toolbar button, .ql-toolbar .ql-picker-label');
        toolbarButtons.forEach(button => {
            button.style.color = '#d1d5db';
            button.style.padding = '4px';
            button.style.margin = '2px';
            button.style.borderRadius = '4px';
            button.style.transition = 'all 0.2s ease';

            button.addEventListener('mouseenter', function() {
                this.style.color = '#ffffff';
                this.style.backgroundColor = 'rgba(75, 85, 99, 0.5)';
            });
            button.addEventListener('mouseleave', function() {
                if (!this.classList.contains('ql-active')) {
                    this.style.color = '#d1d5db';
                    this.style.backgroundColor = 'transparent';
                }
            });
        });

        // Style active states
        const activeButtons = quillContainer.querySelectorAll('.ql-toolbar .ql-active');
        activeButtons.forEach(button => {
            button.style.backgroundColor = 'rgba(59, 130, 246, 0.3)';
            button.style.color = '#ffffff';
        });

        // Style SVG icons
        const svgElements = quillContainer.querySelectorAll('.ql-toolbar svg');
        svgElements.forEach(svg => {
            svg.style.fill = 'currentColor';
            svg.style.stroke = 'currentColor';
        });

        // Style picker dropdowns
        const pickerOptions = quillContainer.querySelectorAll('.ql-picker-options');
        pickerOptions.forEach(picker => {
            picker.style.backgroundColor = '#27272a';
            picker.style.border = '1px solid #52525b';
            picker.style.borderRadius = '6px';
            picker.style.boxShadow = '0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05)';
        });

        // Style picker items
        const pickerItems = quillContainer.querySelectorAll('.ql-picker-item');
        pickerItems.forEach(item => {
            item.style.color = '#d1d5db';
            item.style.padding = '6px 12px';
            item.addEventListener('mouseenter', function() {
                this.style.backgroundColor = 'rgba(59, 130, 246, 0.1)';
                this.style.color = '#ffffff';
            });
            item.addEventListener('mouseleave', function() {
                this.style.backgroundColor = 'transparent';
                this.style.color = '#d1d5db';
            });
        });
    }

    // Initialize when DOM is ready
    function initWhenReady() {
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initializeQuillEditor);
        } else {
            initializeQuillEditor();
        }
    }

    // Handle Livewire navigation
    if (typeof Livewire !== 'undefined') {
        // Livewire v3 hooks
        document.addEventListener('livewire:navigated', function() {
            destroyQuill();
            initializationAttempts = 0;
            setTimeout(initializeQuillEditor, 200);
        });

        // Listen for morph updates (when form validation fails and component re-renders)
        Livewire.hook('morph.updated', ({ el, component }) => {
            if (el.querySelector && el.querySelector('#quill-editor') && !isInitialized) {
                destroyQuill();
                initializationAttempts = 0;
                setTimeout(initializeQuillEditor, 200);
            }
        });

        // Listen for component updates (important for form validation failures)
        Livewire.hook('component.updated', ({ component, updateType }) => {
            // Check if the quill editor element exists but is not initialized
            const editorElement = document.getElementById('quill-editor');
            if (editorElement && !isInitialized) {
                destroyQuill();
                initializationAttempts = 0;
                setTimeout(initializeQuillEditor, 300);
            }
        });

        // Listen for request finished (after form submission, successful or failed)
        Livewire.hook('request.finished', ({ component, updateType }) => {
            // Wait a bit for DOM to settle, then check if editor needs re-initialization
            setTimeout(() => {
                const editorElement = document.getElementById('quill-editor');
                if (editorElement && !isInitialized) {
                    destroyQuill();
                    initializationAttempts = 0;
                    setTimeout(initializeQuillEditor, 100);
                }
            }, 100);
        });

        // Listen for form validation errors
        document.addEventListener('livewire:validation-error', function(event) {
            setTimeout(() => {
                const editorElement = document.getElementById('quill-editor');
                if (editorElement && !isInitialized) {
                    destroyQuill();
                    initializationAttempts = 0;
                    setTimeout(initializeQuillEditor, 200);
                }
            }, 150);
        });
    }

    // Initialize the editor
    initWhenReady();

    // Prevent double initialization by checking window load
    window.addEventListener('load', function() {
        if (!isInitialized && initializationAttempts === 0) {
            setTimeout(initializeQuillEditor, 100);
        }
    });

    // Additional safety net - check every few seconds if editor needs re-initialization
    setInterval(() => {
        const editorElement = document.getElementById('quill-editor');
        if (editorElement && !isInitialized && initializationAttempts < maxAttempts) {
            // Only try if the element exists but has no quill content
            if (!editorElement.querySelector('.ql-toolbar') && !editorElement.classList.contains('ql-container')) {
                console.log('Safety net: Re-initializing Quill editor');
                setTimeout(initializeQuillEditor, 100);
            }
        }
    }, 2000); // Check every 2 seconds

})();
</script>

<!-- Custom CSS for enhanced styling -->
<style>
    /* Prevent double toolbars and ensure proper styling */
    #quill-editor .ql-toolbar {
        position: relative !important;
        z-index: 1 !important;
    }

    #quill-editor .ql-container {
        border-bottom-left-radius: 6px !important;
        border-bottom-right-radius: 6px !important;
        border: none !important;
    }

    #quill-editor .ql-toolbar {
        border-top-left-radius: 6px !important;
        border-top-right-radius: 6px !important;
        border: none !important;
    }

    #quill-editor .ql-editor {
        padding: 16px !important;
        min-height: 200px !important;
    }

    #quill-editor .ql-editor.ql-blank::before {
        color: #9ca3af !important;
        font-style: normal !important;
        opacity: 0.7 !important;
        left: 16px !important;
        right: 16px !important;
    }

    /* Prevent toolbar duplication */
    #quill-editor > .ql-toolbar ~ .ql-toolbar {
        display: none !important;
    }

    /* Scrollbar styling for the editor */
    #quill-editor .ql-editor::-webkit-scrollbar {
        width: 8px;
    }

    #quill-editor .ql-editor::-webkit-scrollbar-track {
        background: rgba(39, 39, 42, 0.5);
        border-radius: 4px;
    }

    #quill-editor .ql-editor::-webkit-scrollbar-thumb {
        background: rgba(107, 114, 128, 0.5);
        border-radius: 4px;
    }

    #quill-editor .ql-editor::-webkit-scrollbar-thumb:hover {
        background: rgba(107, 114, 128, 0.7);
    }

    /* Ensure consistent button styling */
    #quill-editor .ql-toolbar button:hover,
    #quill-editor .ql-toolbar button:focus,
    #quill-editor .ql-toolbar button.ql-active {
        color: #ffffff !important;
        background-color: rgba(59, 130, 246, 0.2) !important;
        border-radius: 4px !important;
    }

    /* Dropdown styling improvements */
    #quill-editor .ql-picker.ql-expanded .ql-picker-options {
        border-color: rgba(59, 130, 246, 0.5) !important;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04) !important;
        z-index: 1000 !important;
    }

    /* Ensure toolbar stays visible */
    #quill-editor .ql-toolbar {
        visibility: visible !important;
        opacity: 1 !important;
        display: block !important;
    }

    /* Fix toolbar button spacing */
    #quill-editor .ql-toolbar .ql-formats {
        margin-right: 8px;
    }

    #quill-editor .ql-toolbar .ql-formats:last-child {
        margin-right: 0;
    }
</style>
@endpush
