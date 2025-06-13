<li>
    @if(!$hasChildren)
        <a href="{{ $link }}" class="pl-[52.8px] pr-6 py-[6.4px] block text-[13.5px] font-medium text-gray-950 transition-all duration-150 ease-linear hover:text-violet-500 dark:text-gray-300 dark:active:text-white dark:hover:text-white">{{ $title }}</a>
    @else
        <a href="javascript: void(0);" aria-expanded="false" class="block py-[6.4px] pr-6 text-sm font-medium text-gray-950 transition-all duration-150 ease-linear nav-menu pl-[52.8px] hover:text-violet-500 dark:text-gray-300 dark:active:text-white dark:hover:text-white">
            <span data-key="t-apps">{{ $title }}</span>
        </a>
        <ul>
            {{ $slot }}
        </ul>
    @endif
</li>
