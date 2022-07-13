<?php

namespace App\View\Components;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

/**
 * Class Buttons
 * @package App\View\Components
 */
class Buttons extends Component
{
    /**
     * @var string
     */
    public string $link;

    /**
     * @var string|null
     */
    public ?string $id;

    /**
     * @var string|null
     */
    public ?string $page;

    /**
     * @var string|null
     */
    public ?string $new;

    /**
     * @var bool
     */
    public bool $delete;

    /**
     * @var bool
     */
    public bool $edit;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(string $link, string $page = null, string $new = null, string $id = null, bool $delete = false, bool $edit = false)
    {
        $this->link = $link;
        $this->id = $id;
        $this->page = $page;
        $this->new = $new;
        $this->delete = $delete;
        $this->edit = $edit;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return Application|Factory|View
     */
    public function render()
    {
        return view('components.buttons');
    }
}
