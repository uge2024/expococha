<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Header extends Component
{
    public $datospagina;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($datospagina)
    {
        $this->datospagina = $datospagina;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.header');
    }
}
