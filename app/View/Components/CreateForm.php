<?php

namespace App\View\Components;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

/**
 * Class CreateForm
 * @package App\View\Components
 */
class CreateForm extends Component
{
    /**
     * @var string
     */
    public string $model;

    /**
     * @var null|string
     */
    public ?string $link;

    /**
     * @var null|string
     */
    public ?string $name;

    /**
     * @var int|null
     */
    public ?int $id;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(string $model, string $link = null, string $name = null, int $id = null)
    {
        $this->model = $model;
        $this->link = $link;
        $this->name = $name;
        $this->id = $id;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return Application|Factory|View
     */
    public function render()
    {
        return view('components.create-form');
    }
}
