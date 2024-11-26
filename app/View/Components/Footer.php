<?php

namespace App\View\Components;

use App\Services\RubroService;
use Illuminate\View\Component;

class Footer extends Component
{
    public $datospagina;
    protected $rubroService;
    public $rubros;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($datospagina,RubroService $rubroService)
    {
        $this->datospagina = $datospagina;
        $this->rubroService = $rubroService;
        $this->rubros = $this->rubroService->getAllByAc();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.footer');
    }
}
