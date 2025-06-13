@props([
    'id' => 'dynamicModal',
    'size' => 'md',
    'title' => 'Modal Title',
    'saveLabel' => 'Save',
    'cancelLabel' => 'Cancel',
    'saveFunction' => '',
    'cancelFunction' => '',
    'saveButtonColor' => 'violet',
    'isOpen' => false,
    'backdropColor' => 'black',
    'backdropOpacity' => '75',
    'backdropBlur' => true,
    'closeOnBackdropClick' => true,
    'zIndex' => '50'
])

@php
$sizeClass = [
    'sm' => 'sm:max-w-sm',
    'md' => 'sm:max-w-md',
    'lg' => 'sm:max-w-xl',
    'xl' => 'sm:max-w-4xl',
][$size ?? 'md'];
@endphp

<div class="relative {{ $isOpen ? '' : 'hidden' }} modal" id="{{ $id }}" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <!-- Backdrop -->
    <div class="fixed inset-0 z-40 bg-black opacity-75 dark:opacity-80" style="pointer-events: auto;"
         @if($closeOnBackdropClick)
         onclick="document.getElementById('{{ $id }}').classList.add('hidden'); if(typeof {{ $cancelFunction }} === 'function') {{ $cancelFunction }}();"
         @endif>
    </div>

    <!-- Modal Content Container -->
    <div class="fixed inset-0 z-50 overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="relative w-full {{ $sizeClass }} mx-auto animate-translate">
                <div class="relative overflow-hidden text-left transition-all transform bg-white rounded-lg shadow-xl dark:bg-zinc-700">
                    <div class="bg-white dark:bg-zinc-700">
                        <!-- Modal Header -->
                        <div class="flex items-center p-4 border-b rounded-t border-gray-50 dark:border-zinc-600">
                            <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-100">
                                {{ $title }}
                            </h3>
                            <button class="inline-flex items-center px-2 py-1 text-sm text-gray-400 border-transparent rounded-lg btn hover:bg-gray-50/50 hover:text-gray-900 dark:text-gray-100 ltr:ml-auto rtl:mr-auto dark:hover:bg-zinc-600" type="button" wire:click="{{ $cancelFunction }}" data-tw-dismiss="modal">
                                <i class="text-xl text-gray-500 mdi mdi-close dark:text-zinc-100/60"></i>
                            </button>
                        </div>

                        <!-- Modal Body -->
                        <div class="p-6 space-y-6 ltr:text-left rtl:text-right dark:text-gray-200">
                            {{ $slot }}
                        </div>

                        <!-- Modal Footer -->
                        <div class="flex items-center gap-3 p-5 space-x-2 border-t rounded-b border-gray-50 dark:border-zinc-600">
                            @if($saveFunction)
                            <button
                                type="button"
                                wire:click="{{ $saveFunction }}"
                                class="inline-flex justify-center w-full px-4 py-2 text-base font-medium text-white bg-{{ $saveButtonColor }}-500 border border-transparent rounded-md shadow-sm btn hover:bg-{{ $saveButtonColor }}-600 focus:outline-none focus:ring-2 focus:ring-{{ $saveButtonColor }}-500 sm:w-auto sm:text-sm"
                            >
                                {{ $saveLabel }}
                            </button>
                            @endif

                            <button
                                type="button"
                                class="inline-flex justify-center w-full px-4 py-2 text-base font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm btn dark:text-gray-100 hover:bg-gray-50/50 focus:outline-none focus:ring-2 focus:ring-gray-500/30 sm:w-auto sm:text-sm dark:bg-zinc-700 dark:border-zinc-600 dark:hover:bg-zinc-600 dark:focus:bg-zinc-600 dark:focus:ring-zinc-700 dark:focus:ring-gray-500/20"
                                wire:click="{{ $cancelFunction }}"
                                data-tw-dismiss="modal"
                            >
                                {{ $cancelLabel }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Ensure backdrop is visible */
#{{ $id }} .fixed.inset-0.bg-black {
    position: fixed;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    background-color: #000;
}
</style>
