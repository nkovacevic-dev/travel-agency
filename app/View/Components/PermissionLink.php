<?php

namespace App\View\Components;

use Illuminate\View\Component;

class PermissionLink extends Component
{
    public $route_name;
    public $url;
    public $label;
    public $class;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($routename, $url, $label, $class="")
    {
        $this->route_name = $routename;
        $this->url = $url;
        $this->label = $label;
        $this->class = $class;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.permission-link');
    }
}
