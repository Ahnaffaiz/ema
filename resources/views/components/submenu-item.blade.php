@props([
    'title' => '',
    'link' => '#',
    'active' => false
])

<li>
    <a href="{{ $link }}"
       class="block py-2 px-12 text-sm font-medium text-gray-700 transition-all duration-150 ease-linear hover:text-violet-500 dark:text-gray-400 dark:hover:text-white {{ $active ? 'text-violet-500 dark:text-white' : '' }}">
        {{ $title }}
    </a>
</li>
