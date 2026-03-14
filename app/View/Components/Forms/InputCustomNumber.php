<?php

namespace App\View\Components\Forms;

use Illuminate\View\Component;

class InputCustomNumber extends Component
{
    public $label;
    public $name;
    public $value;
    public $required;
    public $disabled;
    public $readonly;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($name,$label = "", $required = false, $value = "",$disabled = false, $readonly = false)
    {
        $this->name = $name;
        $this->label = $label;
        $this->required = $required;
        $this->value = $value;
        $this->disabled = $disabled;
        $this->readonly = $readonly;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.forms.input-custom-number');
    }
}
