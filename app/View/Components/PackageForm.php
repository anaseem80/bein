<?php

namespace App\View\Components;

use Illuminate\View\Component;

class PackageForm extends Component
{
    public $action;
    public $isSub;
    public $subAction;
    public $package;
    public $parentId;
    public $isParent;
    public $mainPackages;
    public $channels;
    public $devices;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($action, $isSub, $subAction,$package, $parentId, $isParent, $mainPackages, $channels, $devices)
    {
        $this->action = $action;
        $this->isSub = $isSub;
        $this->subAction = $subAction;
        $this->package = $package;
        $this->parentId = $parentId;
        $this->isParent = $isParent;
        $this->mainPackages = $mainPackages;
        $this->channels = $channels;
        $this->devices = $devices;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.package-form');
    }
}
