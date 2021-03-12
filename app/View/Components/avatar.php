<?php

namespace App\View\Components;

use Illuminate\View\Component;

class avatar extends Component
{
    public $width;
    public $height;
    public $src;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($width,$height,$src=null)
    {
        $this->width=$width;
        $this->height=$height;
        $this->src=$src;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.avatar');
    }
}
