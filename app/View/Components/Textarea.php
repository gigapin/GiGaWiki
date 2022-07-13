<?php

namespace App\View\Components;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

/**
 * Class Textarea
 * @package App\View\Components
 */
class Textarea extends Component
{
    /**
     * @var string
     */
    public string $name;

    /**
     * @var mixed|null
     */
    public mixed $content;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(string $name, $content = null)
    {
        $this->name = $name;
        $this->content = $content;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return Application|Factory|View
     */
    public function render()
    {
        return view('components.textarea');
    }
}
