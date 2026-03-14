<?php

namespace App\View\Components\Forms;

use Illuminate\View\Component;

class InputRadio extends Component
{
    public $id;
    public $label;
    public $name;
    public $value;
    public $modelValue;
    public $required;
    public $disabled;
    public $readonly;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        $id = '',
        $label = '',
        $name = '',
        $value = '',
        $modelValue = '',
        $required = false,
        $disabled = false,
        $readonly = false
    ) {
        $this->id = $id;
        $this->label = $label;
        $this->name = $name;
        $this->value = $value;
        $this->modelValue = $modelValue;
        $this->required = $required;
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
        return view('components.forms.input-radio');
    }
}
