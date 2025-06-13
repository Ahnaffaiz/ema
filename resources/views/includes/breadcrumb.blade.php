<div class="grid grid-cols-1 pb-6">
    <div class="md:flex items-center justify-end px-[2px]">
        <nav class="flex" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 ltr:md:space-x-3 rtl:md:space-x-0">
                @if ($subtitle != 'default')
                <li class="inline-flex items-center">
                    <a href="{{ route($subRoute) }}" class="inline-flex items-center text-sm text-gray-800 hover:text-gray-900 dark:text-zinc-100 dark:hover:text-white">
                        {{ $subtitle }}
                    </a>
                </li>
                @endif
                <li>
                    <div class="flex items-center rtl:mr-2">
                        @if ($subtitle != 'default')
                            <i class="font-semibold text-gray-600 align-middle far fa-angle-right text-13 rtl:rotate-180 dark:text-zinc-100"></i>
                        @endif
                        <a href="#" class="text-sm font-medium text-gray-500 ltr:ml-2 rtl:mr-2 ltr:md:ml-2 rtl:md:mr-2 dark:text-gray-100">{{ $title }}</a>
                    </div>
                </li>
            </ol>
        </nav>
    </div>
</div>
