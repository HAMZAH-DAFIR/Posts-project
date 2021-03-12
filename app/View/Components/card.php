<?php

namespace App\View\Components;

use Illuminate\View\Component;

class card extends Component
{
    public $items;
    public $count;
    public $prop;
    public $type;
    public $route;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($items,$count,$prop,$type,$route=null)
    {
        $this->items=$items;
        $this->count=$count;
        $this->prop=$prop;
        $this->type=$type;
        $this->route=$route;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.card');
    }
}
