<button
    type="{{ $type }}"
    {{ $attributes->merge(['class' => 'btn ' . $variantClasses() . ' ' . $class]) }}
    {!! $loadingAttributes() !!}
    {!! $loadingTargetDirective() !!}
>
    @if ($icon)
        <i class="align-middle {{ $icon }} text-16 ltr:mr-1 rtl:ml-1 {{ $iconAnimationClass() }} @if($loadingTarget) wire:loading.class.remove='hidden' wire:loading.class='inline-block' wire:target='{{ $loadingTarget }}' @endif"></i>
        @if($loadingTarget)
            <i class="align-middle bx bx-loader text-16 ltr:mr-1 rtl:ml-1 animate-spin hidden wire:loading.class.remove='hidden' wire:loading.class='inline-block' wire:target="{{ $loadingTarget }}"></i>
        @endif
    @endif

    @if ($variant === 'link')
        <span class="transition-all duration-100 ease-in-out group-hover:border-b group-hover:border-violet-500">{{ $slot }}</span>
    @else
        <span class="align-middle">{{ $slot }}</span>
    @endif
</button>
