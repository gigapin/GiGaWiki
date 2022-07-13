<?php

namespace App\View\Components;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

/**
 * Class Breadcrumb
 * @package App\View\Components
 */
class Breadcrumb extends Component
{
    /**
     * @var string
     */
    public string $link;

    /**
     * @var string
     */
    public string $name;

    /**
     * @var mixed|null
     */
    public mixed $value;

    /**
     * @var mixed|null
     */
    public mixed $project;

    /**
     * @var mixed|null
     */
    public mixed $route;

    /**
     * @var mixed|null
     */
    public mixed $root;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(string $link, string $name, $project = null, $route = null, $value = null, $root = null)
    {
        $this->link = $link;
        $this->name = $name;
        $this->value = $value;
        $this->project = $project;
        $this->route = $route;
        $this->root = $root;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return Application|Factory|View
     */
    public function render()
    {
        return view('components.breadcrumb');
    }
}
