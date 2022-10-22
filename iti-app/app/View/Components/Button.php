<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Button extends Component
{
    public $typee;
    public $msg;
    /**
     * Create a new component instance.
     *@param  string  $typee
     *@param  string  $msg
     * @return void
     */
    public function __construct($typee ,$msg)
    {
        //
        $this->typee = $typee;
        $this->msg = $msg;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.button');
    }
}
