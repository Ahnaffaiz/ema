<?php

namespace App\View\Components;

use Illuminate\View\Component;

class ButtonDefault extends Component
{
    /**
     * The button type.
     *
     * @var string
     */
    public $type;

    /**
     * The button variant (primary, secondary, success, etc.).
     *
     * @var string
     */
    public $variant;

    /**
     * Additional classes to apply to the button.
     *
     * @var string
     */
    public $class;

    /**
     * The icon class to display in the button.
     *
     * @var string|null
     */
    public $icon;

    /**
     * Whether the icon should animate when loading.
     *
     * @var bool
     */
    public $animateIcon;

    /**
     * The loading target for wire:loading.
     *
     * @var string|null
     */
    public $loadingTarget;

    /**
     * Create a new component instance.
     *
     * @param  string  $type
     * @param  string  $variant
     * @param  string  $class
     * @param  string|null  $icon
     * @param  bool  $animateIcon
     * @param  string|null  $loadingTarget
     * @return void
     */
    public function __construct(
        $type = 'button',
        $variant = 'primary',
        $class = '',
        $icon = null,
        $animateIcon = false,
        $loadingTarget = null
    ) {
        $this->type = $type;
        $this->variant = $variant;
        $this->class = $class;
        $this->icon = $icon;
        $this->animateIcon = $animateIcon;
        $this->loadingTarget = $loadingTarget;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.button-default');
    }

    /**
     * Get the button classes based on the variant.
     *
     * @return string
     */
    public function variantClasses()
    {
        return match ($this->variant) {
            'primary' => 'text-white bg-violet-500 border-violet-500 hover:bg-violet-600 hover:border-violet-600 focus:bg-violet-600 focus:border-violet-600 focus:ring-violet-500/30 active:bg-violet-600 active:border-violet-600',
            'secondary' => 'text-white bg-gray-500 border-gray-500 hover:bg-gray-600 hover:border-gray-600 focus:bg-gray-600 focus:border-gray-600 focus:ring focus:ring-gray-500/30 active:bg-gray-600 active:border-gray-600',
            'success' => 'text-white bg-green-500 border-green-500 hover:bg-green-600 hover:border-green-600 focus:bg-green-600 focus:border-green-600 focus:ring focus:ring-green-500/30 active:bg-green-600 active:border-green-600',
            'info' => 'text-white bg-sky-500 border-sky-500 hover:bg-sky-600 hover:border-sky-600 focus:bg-sky-600 focus:border-sky-600 focus:ring focus:ring-sky-500/30 active:bg-sky-600 active:border-sky-600',
            'warning' => 'text-white bg-yellow-500 border-yellow-500 hover:bg-yellow-600 hover:border-yellow-600 focus:bg-yellow-600 focus:border-yellow-600 focus:ring focus:ring-yellow-500/30 active:bg-yellow-600 active:border-yellow-600',
            'danger' => 'text-white bg-red-500 border-red-500 hover:bg-red-600 hover:border-red-600 focus:bg-red-600 focus:border-red-600 focus:ring focus:ring-red-500/30 active:bg-red-600 active:border-red-600',
            'dark' => 'text-white bg-neutral-800 border-neutral-800 hover:bg-neutral-900 hover:border-neutral-900 focus:bg-neutral-900 focus:border-neutral-900 focus:ring focus:ring-neutral-500/30 active:bg-neutral-900 active:border-neutral-900',
            'light' => 'text-black bg-gray-50 border-gray-50 focus:bg-gray-300 focus:border-gray-300 focus:ring focus:ring-gray-500/30 active:bg-gray-300 active:border-gray-300',
            'link' => 'border-0 text-violet-500 group',
            default => 'text-white bg-violet-500 border-violet-500 hover:bg-violet-600 hover:border-violet-600 focus:bg-violet-600 focus:border-violet-600 focus:ring focus:ring-violet-500/30 active:bg-violet-600 active:border-violet-600',
        };
    }

    /**
     * Get the icon animation classes.
     *
     * @return string
     */
    public function iconAnimationClass()
    {
        return $this->animateIcon ? 'animate-spin' : '';
    }

    /**
     * Get the loading target attribute.
     *
     * @return string|null
     */
    public function loadingAttributes()
    {
        if ($this->loadingTarget) {
            return 'wire:loading.attr="disabled" wire:loading.class="opacity-75 cursor-wait"';
        }

        return '';
    }

    /**
     * Get the loading target directive.
     *
     * @return string|null
     */
    public function loadingTargetDirective()
    {
        if ($this->loadingTarget) {
            return "wire:target=\"{$this->loadingTarget}\"";
        }

        return '';
    }
}
