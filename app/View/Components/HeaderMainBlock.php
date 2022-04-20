<?php

namespace App\View\Components;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

/**
 * Class HeadermainBlock
 * @package App\View\Components
 */
class HeaderMainBlock extends Component
{
    /**
     * @var string
     */
    public string $title;

    /**
     * @var string|null
     */
    public ?string $description;

    /**
     * @var mixed|null
     */
    public ?string $featured;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(string $title, string $description = null, string $featured = null)
    {
        $this->title = $title;
        $this->description = $description;
        $this->featured = $featured;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return Application|Factory|View
     */
    public function render()
    {
        return view('components.header-main-block');
    }
}
