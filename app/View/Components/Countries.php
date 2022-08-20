<?php

namespace App\View\Components;

use App\Models\Country;
use Illuminate\View\Component;

class Countries extends Component
{
    public $countries;
    public $other;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        $countries = Country::orderBy('name', 'ASC')->get();
        $other = [];
        for ($i = 0; $i < count($countries); $i++) {
            if ($countries[$i]->name == 'أخرى') {
                $other = $countries[$i];
                unset($countries[$i]);
            }
        }
        $this->countries = $countries;
        $this->other = $other;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.countries');
    }
}
