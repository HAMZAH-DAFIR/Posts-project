<?php

namespace App\View\Components;

use Illuminate\View\Component;

class DateUser extends Component
{
    public $date;
    public $name;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($date,$name=null)
    {
        $this->date=$date->diffForHumans();
        $this->name=$name;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.date-user');
    }
}
