<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ChildToothChart extends Component
{
    public $nameAttr;
    public $selectedteeth;
    /**
     * Create a new component instance.
     */
    public function __construct($nameAttr, $selectedteeth = "")
    {
        $this->nameAttr = $nameAttr;
        $this->selectedteeth = $selectedteeth;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.child-tooth-chart');
    }
}
