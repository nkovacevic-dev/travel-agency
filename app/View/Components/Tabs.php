<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Tabs extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        view()->share('tabs_id', \Illuminate\Support\str::uuid());
        return view('components.tabs');
    }
}
