<?php

namespace App\View\Components;

use Illuminate\View\Component;

/**
 * Class InputTitle
 * @package App\View\Components
 */
class InputTitle extends Component
{
    /**
     * @var string
     */
    public string $name;

    /**
     * @var string
     */
    public string $label;

    /**
     * @var mixed|null
     */
    public mixed $value;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(string $name, string $label, $value = null)
    {
        $this->name = $name;
        $this->label = $label;
        $this->value = $value;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.input-title');
    }
}
