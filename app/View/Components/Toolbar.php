<?php

namespace App\View\Components;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

/**
 * Class Toolbar
 * @package App\View\Components
 */
class Toolbar extends Component
{
    /**
     * @var string|null
     */
    public string|null $page;

    /**
     * @var string|null
     */
    public string|null $link;

    /**
     * @var int|null
     */
    public int|null $id;

    /**
     * @var bool|mixed
     */
    public mixed $icon;

    /**
     * Toolbar constructor.
     * @param string|null $page
     * @param string|null $link
     */
    public function __construct(string $page = null, string $link = null, int $id = null, $icon = true)
    {
        $this->page = $page;
        $this->link = $link;
        $this->id = $id;
        $this->icon = $icon;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return Application|Factory|View
     */
    public function render()
    {
        return view('components.toolbar');
    }
}
