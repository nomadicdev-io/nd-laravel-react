<?php

namespace App\View\Components\Forms;

use Illuminate\View\Component;

class Textarea extends Component
{
    public $title;
    public $id;
    public $required;
    public $name;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($title, $id,$required)
        {
          
            $this->title = $title;
            $this->id = $id;
            $this->required = $id;
            $this->name = $name;
        }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.forms.textarea');
    }
}
