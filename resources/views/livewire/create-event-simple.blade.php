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

                    <!-- Description Section -->
                    <div class="space-y-2">
                        <label class="flex items-center text-sm font-medium text-gray-300">
                            <i class="mr-2 text-gray-400 bx bx-text"></i>
                            Event Description
                        </label>
                        <div class="overflow-hidden transition-all duration-200 border rounded-lg bg-zinc-800/50 backdrop-blur-sm border-zinc-700/50 focus-within:ring-2 focus-within:ring-blue-500 focus-within:border-blue-500">
                            <div
                                id="quill-editor-{{ uniqid() }}"
                                wire:ignore.self
                                class="min-h-[200px]"
                                x-data="{
                                    quill: null,
                                    content: @entangle('desc'),
                                    init() {
                                        this.quill = new Quill(this.$el, {
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
                                            placeholder: 'Describe your event details, agenda, what attendees can expect...'
                                        });

                                        // Set initial content
                                        if (this.content) {
                                            this.quill.root.innerHTML = this.content;
                                        }

                                        // Listen for changes
                                        this.quill.on('text-change', () => {
                                            this.content = this.quill.root.innerHTML;
                                        });

                                        // Apply dark theme
                                        this.applyDarkTheme();
                                    },
                                    applyDarkTheme() {
                                        setTimeout(() => {
                                            const editor = this.$el.querySelector('.ql-editor');
                                            if (editor) {
                                                editor.style.backgroundColor = 'rgba(39, 39, 42, 0.8)';
                                                editor.style.color = '#f3f4f6';
                                                editor.style.border = 'none';
                                                editor.style.minHeight = '200px';
                                                editor.style.fontSize = '14px';
                                                editor.style.lineHeight = '1.6';
                                                editor.style.padding = '16px';
                                            }

                                            const toolbar = this.$el.querySelector('.ql-toolbar');
                                            if (toolbar) {
                                                toolbar.style.backgroundColor = 'rgba(63, 63, 70, 0.8)';
                                                toolbar.style.border = 'none';
                                                toolbar.style.borderBottom = '1px solid rgba(82, 82, 91, 0.5)';
                                                toolbar.style.borderTopLeftRadius = '6px';
                                                toolbar.style.borderTopRightRadius = '6px';
                                                toolbar.style.padding = '8px';
                                            }

                                            const buttons = this.$el.querySelectorAll('.ql-toolbar button, .ql-toolbar .ql-picker-label');
                                            buttons.forEach(button => {
                                                button.style.color = '#d1d5db';
                                                button.style.padding = '4px';
                                                button.style.margin = '2px';
                                                button.style.borderRadius = '4px';
                                            });
                                        }, 100);
                                    }
                                }"
                            ></div>
                        </div>
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
<!-- Alpine.js -->
<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

<style>
    .ql-container {
        border-bottom-left-radius: 6px !important;
        border-bottom-right-radius: 6px !important;
        border: none !important;
    }

    .ql-toolbar {
        border-top-left-radius: 6px !important;
        border-top-right-radius: 6px !important;
        border: none !important;
    }

    .ql-editor.ql-blank::before {
        color: #9ca3af !important;
        font-style: normal !important;
        opacity: 0.7 !important;
        left: 16px !important;
        right: 16px !important;
    }
</style>
@endpush
