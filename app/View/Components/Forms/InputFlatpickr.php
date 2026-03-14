<?php

namespace App\View\Components\Forms;

use Illuminate\View\Component;

class InputFlatpickr extends Component
{
    public $label;
    public $name;
    public $value;
    public $required;
    public $disabled;
    public $controls;
    public $shorthand;
    public $datetime;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($label = '', $name = '', $value = '', $required = false, $disabled = false,
        $controls = true, $shorthand = false, $datetime = false)
    {
        $this->label = $label;
        $this->name = $name;
        $this->value = $value;
        $this->required = $required;
        $this->disabled = $disabled;
        $this->controls = $controls;
        $this->shorthand = $shorthand;
        $this->datetime = $datetime;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.forms.input-flatpickr');
    }
}
