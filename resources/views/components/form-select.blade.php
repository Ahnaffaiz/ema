@props([
    'name',
    'label',
    'placeholder' => 'Select an option',
    'required' => false,
    'disabled' => false,
    'id' => null,
    'error' => false,
    'errorMessage' => '',
    'class' => '',
])

@php
    $id = $id ?? $name;
    $wireModel = $name ? "wire:model.live=$name" : '';
    $hasError = $error || $errors->has($name);
    $errorMsg = $errorMessage ?: ($errors->first($name) ?? 'Please select a valid option.');

    $selectClasses = $hasError
        ? 'block w-full py-2 pl-3 pr-10 mt-1 text-base border-red-500 rounded-md focus:outline-none focus:ring-red-500 focus:border-red-500 sm:text-sm dark:bg-zinc-700 dark:border-zinc-600 dark:text-white'
        : 'block w-full py-2 pl-3 pr-10 mt-1 text-base border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm dark:bg-zinc-700 dark:border-zinc-600 dark:text-white';
@endphp

<div class="mb-3 {{ $class }}">
    @if($label)
    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300" for="{{ $id }}">
        {{ $label }} {{ $required ? '*' : '' }}
    </label>
    @endif
    <select
        id="{{ $id }}"
        name="{{ $name }}"
        {!! $wireModel !!}
        {{ $required ? 'required' : '' }}
        {{ $disabled ? 'disabled' : '' }}
        {{ $attributes->merge(['class' => $selectClasses]) }}
    >
        {{ $slot }}
    </select>
    @if($hasError)
        <div class="mt-2 text-xs text-red-500">{{ $errorMsg }}</div>
    @endif
</div>
