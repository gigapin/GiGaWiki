<?php

namespace App\View\Components;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Cards extends Component
{

    /**
     * @var string
     */
    public string $title;

    /**
     * @var string
     */
    public string $body;

    /**
     * @var string
     */
    public string $slug;

    /**
     * @var string|null
     */
    public ?string $image;

    /**
     * @var string
     */
    public string $model;

    /**
     * @var string|null
     */
    public ?string $parent;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(string $model, string $title, string $body, string $slug, string $image = null, string $parent = null)
    {
        $this->model = $model;
        $this->title = $title;
        $this->body = $body;
        $this->slug = $slug;
        $this->image = $image;
        $this->parent = $parent;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return Application|Factory|View
     */
    public function render()
    {
        return view('components.cards');
    }
}
