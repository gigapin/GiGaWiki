<?php

namespace App\View\Components;

use Illuminate\View\Component;

class SettingBox extends Component
{

    /**
     * @var string
     */
    public string $title;

    /**
     * @var string
     */
    public string $type;

    /**
     * @var string
     */
    public string $name;

    /**
     * @var string|null
     */
    public ?string $value;

    /**
     * @var string|null
     */
    public ?string $link;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(string $title, string $type, string $name, string $value = null, string $link = null)
    {
        $this->title = $title;
        $this->type = $type;
        $this->name = $name;
        $this->value = $value;
        $this->link = $link;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.setting-box');
    }
}
