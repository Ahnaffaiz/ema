<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class MenuItem extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $title,
        public string $icon = '',
        public ?string $link = null,
        public bool $hasDropdown = false,
        public string $badge = '',
        public string $badgeClass = 'bg-red-50 text-red-500',
        public bool $isHeader = false
    ) {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.menu-item');
    }
}
