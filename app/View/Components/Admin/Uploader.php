<?php

namespace App\View\Components\Admin;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Uploader extends Component
{
    /**
     * Create a new component instance.
     */
    public $uploaderData;
    public function __construct($uploaderData)
    {
        $this->uploaderData=$uploaderData;
        
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
         $uploaderData =$this->uploaderData;
        
        return view('components.admin.uploader',$uploaderData);
    }
}
