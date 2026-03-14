<?php

namespace App\View\Components\Forms;

use Illuminate\View\Component;

class InputTinymce extends Component
{
    public $label;
    public $name;
    public $value;
    public $required;
    public $disabled;
    public $storePictureUrl;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($label = 'a', $name = '', $value = '', $required = false, $disabled = false, $storePictureUrl = null)
    {
        $this->label = $label;
        $this->name = $name;
        $this->value = $value;
        $this->required = $required;
        $this->disabled = $disabled;
        $this->storePictureUrl = $storePictureUrl;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.forms.input-tinymce');
    }
}
