@if($isHeader)
    <li class="px-5 py-3 text-xs font-medium text-gray-500 cursor-default leading-[18px] group-data-[sidebar-size=sm]:hidden block" data-key="t-menu">{{ $title }}</li>
@else
    <li>
        @if(!$hasDropdown)
            <a href="{{ $link ?? 'javascript:void(0);' }}" class="block py-2.5 px-6 text-sm font-medium text-gray-950 transition-all duration-150 ease-linear hover:text-violet-500 dark:text-gray-300 dark:active:text-white dark:hover:text-white">
                @if($icon)
                    <i data-feather="{{ $icon }}" fill="#545a6d33"></i>
                @endif
                <span data-key="t-{{ strtolower($title) }}"> {{ $title }}</span>
                @if($badge)
                    <span class="px-2 py-0.5 font-medium {{ $badgeClass }} rounded-full text-10 badge text-end group-data-[sidebar-size=sm]:hidden">{{ $badge }}</span>
                @endif
            </a>
        @else
            <a href="javascript: void(0);" aria-expanded="false" class="block py-2.5 px-6 text-sm font-medium text-gray-950 transition-all duration-150 ease-linear nav-menu hover:text-violet-500 dark:text-gray-300 dark:active:text-white dark:hover:text-white">
                @if($icon)
                    <i data-feather="{{ $icon }}" class="align-middle" fill="#545a6d33"></i>
                @endif
                <span data-key="t-{{ strtolower($title) }}">{{ $title }}</span>
                @if($badge)
                    <span class="px-2 py-0.5 font-medium {{ $badgeClass }} rounded-full text-10 badge text-end group-data-[sidebar-size=sm]:hidden">{{ $badge }}</span>
                @endif
            </a>
            <ul>
                {{ $slot }}
            </ul>
        @endif
    </li>
@endif
