<?php

namespace App\View\Components\Forms;

use Illuminate\View\Component;

class InputTextarea extends Component
{
    public $label;
    public $name;
    public $value;
    public $required;
    public $readonly;
    public $disabled;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($label = 'a', $name = '', $value = '', $required = false, $disabled = false, $readonly = false)
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
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.forms.input-textarea');
    }
}
