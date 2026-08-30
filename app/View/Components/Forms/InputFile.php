<?php

namespace App\View\Components\Forms;

use Illuminate\View\Component;

class InputFile extends Component
{
    public $label;
    public $name;
    public $value;
    public $required;
    public $disabled;
    public $type;
    public $multiple;
    public $existing;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($label = '', $name = '', $value = '', $required = false, $disabled = false, $type = '', $multiple = false, $existing = [])
    {
        $this->label = $label;
        $this->name = $name;
        $this->value = $value;
        $this->required = $required;
        $this->disabled = $disabled;
        $this->type = $type;
        $this->multiple = $multiple;
        $this->existing = $existing ?? [];
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.forms.input-file');
    }
}
