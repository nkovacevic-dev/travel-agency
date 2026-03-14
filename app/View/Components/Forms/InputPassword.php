<?php

namespace App\View\Components\Forms;

use Illuminate\View\Component;

class InputPassword extends Component
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
    public function __construct($label = '', $name = '', $value = '', $required = false, $disabled=false, $readonly=false)
    {
        $this->label = $label;
        $this->name = $name;
        $this->value = $value;
        $this->required = $required;
        $this->disabled = $disabled;
        $this->readonly = $readonly;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.forms.input-password');
    }
}
