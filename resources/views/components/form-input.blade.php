@props([
    'name',
    'label',
    'type' => 'text',
    'placeholder' => '',
    'required' => false,
    'disabled' => false,
    'value' => null,
    'id' => null,
    'error' => false,
    'errorMessage' => '',
    'hasIcon' => false,
    'iconClass' => '',
    'class' => '',
])

@php
    $id = $id ?? $name;
    $wireModel = $name ? "wire:model.live=$name" : '';
    $hasError = $error || $errors->has($name);
    $errorMsg = $errorMessage ?: ($errors->first($name) ?? 'Please provide a valid input.');

    $inputClasses = $hasError
        ? 'w-full border-red-500 py-2.5 rounded text-sm text-gray-700 dark:text-gray-100 focus:ring focus:ring-red-50 dark:bg-zinc-700/50 dark:border-zinc-600 dark:placeholder:text-zinc-100/60 dark:focus:ring-red-500/10'
        : 'w-full py-2.5 rounded text-sm border-gray-300 text-gray-700 dark:text-gray-100 focus:ring focus:ring-violet-50 dark:bg-zinc-700/50 dark:border-zinc-600 dark:placeholder:text-zinc-100/60 dark:focus:ring-violet-500/10';
@endphp

<div class="mb-3">
    @if($label)
    <label class="block mb-2 font-medium text-gray-700 dark:text-gray-100" for="{{ $id }}">
        {{ $label }} {{ $required ? '*' : '' }}
    </label>
    @endif
    <div class="relative">
        <input
            type="{{ $type }}"
            id="{{ $id }}"
            name="{{ $name }}"
            {!! $wireModel !!}
            placeholder="{{ $placeholder }}"
            {{ $required ? 'required' : '' }}
            {{ $disabled ? 'disabled' : '' }}
            {{ $attributes->merge(['class' => $inputClasses]) }}
            {{ $class ? 'class=' . $class : '' }}
            class="text-gray-500 dark:text-gray-700"
        >
        @if ($hasIcon)
            <i class='absolute text-xl {{ $iconClass }} ltr:right-2 rtl:left-2 top-2 text-gray-500 dark:text-gray-700'></i>
        @endif
        @if($hasError && $hasIcon)
            <i class='absolute text-xl text-red-500 bx bx-error-circle ltr:right-2 rtl:left-2 top-2 '></i>
        @endif
    </div>
    @if($hasError)
        <div class="mt-2 text-xs text-red-500">{{ $errorMsg }}</div>
    @endif
</div>
