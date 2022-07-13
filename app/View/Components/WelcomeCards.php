<?php

namespace App\View\Components;

use Illuminate\View\Component;

class WelcomeCards extends Component
{
    // /**
    //  * @var string
    //  */
    // public string $name;

    // /**
    //  * @var string
    //  */
    // public string $description;

    // /**
    //  * @var string
    //  */
    // public string $author;

    // /**
    //  * @var string
    //  */
    // public string $date;

    // /**
    //  * @var string
    //  */
    // public string $slug;

    // /**
    //  * @var string
    //  */
    // public string $url;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(public string $name, public string $description, public string $author, public string $date, public string $slug, public string $url)
    {
        // $this->name = $name;
        // $this->description = $description;
        // $this->author = $author;
        // $this->date = $date;
        // $this->slug = $slug;
        // $this->url = $url;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.welcome-cards');
    }
}
