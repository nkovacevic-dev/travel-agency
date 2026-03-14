<?php

namespace App\View\Components\Forms;

use Illuminate\View\Component;

class InputText extends Component
{
    public $label;
    public $name;
    public $value;
    public $required;
    public $disabled;
    public $readonly;
    public $id;
    public $placeholder;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($label = '', $name = '', $id = '', $value = '', $required = false, $disabled=false, $readonly=false, $placeholder = '')
    {
        $this->label = $label;
        $this->name = $name;
        $this->value = $value;
        $this->required = $required;
        $this->disabled = $disabled;
        $this->readonly = $readonly;
        $this->id = $id;
        $this->placeholder = $placeholder;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.forms.input-text');
    }
}
