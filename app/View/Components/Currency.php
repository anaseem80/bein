<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Http\Controllers\SettingController;

class Currency extends Component
{
    public $currency;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->currency=SettingController::getSettingValue('currency');
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.currency');
    }
}
