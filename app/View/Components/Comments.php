<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Comments extends Component
{
    public $item;
    public $type;
    public $manager;
    public $user;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($item,$type)
    {
        $this->item=$item;
        $this->type=$type;
        $this->user=auth()->user();
        $this->manager=false;
        if($this->user){
            if($this->user->role=='admin'||$this->user->role=='owner'){
                $this->manager=true;
            }else{
                $this->manager=0;  
            }
        }else{
            $this->manager=0;
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.comments');
    }
}
