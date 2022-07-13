<?php

namespace App\View\Components;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

/**
 * Class ActionsBar
 * @package App\View\Component
 */
class ActionsBar extends Component
{
    /**
     * @var bool
     */
    public bool $filter;

    /**
     * @var string|null
     */
    public ?string $route;

    /**
     * @var string|null
     */
    public ?string $name;

    /**
     * @var int|null
     */
    public ?int $user;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(bool $filter = false, string $route = null, string $name = null, int $user = null)
    {
        $this->filter = $filter;
        $this->route = $route;
        $this->name = $name;
        $this->user = $user;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return Application|Factory|View
     */
    public function render()
    {
        return view('components.actions-bar');
    }
}
