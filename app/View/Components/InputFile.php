<?php

namespace App\View\Components;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

/**
 * Class InputFile
 * @package App\View\Components
 */
class InputFile extends Component
{
    /**
     * @var string
     */
    public string $label;

    /**
     * @var string
     */
    public string $name;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(string $label, string $name)
    {
        $this->label = $label;
        $this->name = $name;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return Application|Factory|View
     */
    public function render()
    {
        return view('components.input-file');
    }
}
