<?php

namespace App\View\Components\Forms;

use Illuminate\View\Component;

class InputSelect extends Component
{
    public $label;
    public $name;
    public $value;
    public $required;
    public $items;
    public $disabled;
    public $readonly;
    public $minimumInputLength;
    public $multiple;
    public $emptyOption;
    public $tags;
    public $mesto;
    public $id;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        $label = '', 
        $name = '', 
        $value = '', 
        $required = false, 
        $items=[], 
        $disabled = false, 
        $readonly = false,
        $minimumInputLength = 0,
        $multiple=false,
        $emptyOption = false,
        $tags = false,
        $mesto = false,
        $id = '')
    {
        $this->label = $label;
        $this->name = $name;
        $this->value = $value;
        $this->required = $required;
        $this->items = $items;
        $this->disabled = $disabled;
        $this->readonly = $readonly;
        $this->minimumInputLength = $minimumInputLength;
        $this->multiple = $multiple;
        $this->emptyOption = $emptyOption && !($this->disabled||$this->readonly);
        $this->tags = $tags;
        $this->mesto = $mesto;
        $this->id = $id;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.forms.input-select');
    }
}
