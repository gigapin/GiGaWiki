<?php

namespace App\View\Components;

use Illuminate\View\Component;

/**
 * Class ListMainBlock
 * @package App\View\Components
 */
class ListMainBlock extends Component
{
    /**
     * @var string
     */
    public string $route;

    /**
     * @var string
     */
    public string $name;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(string $route, string $name)
    {
        $this->route = $route;
        $this->name = $name;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.list-main-block');
    }
}
