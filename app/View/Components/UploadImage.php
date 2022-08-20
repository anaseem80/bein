<?php

namespace App\View\Components;

use Illuminate\View\Component;

class UploadImage extends Component
{

    public $type;
    public $object;
    public $deleteImage;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($type,$object,$deleteImage)
    {
        $this->type=$type;
        $this->object=$object;
        $this->deleteImage=$deleteImage;

    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.upload-image');
    }
}
