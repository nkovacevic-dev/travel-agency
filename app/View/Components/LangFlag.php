<?php

namespace App\View\Components;

use Illuminate\View\Component;

class LangFlag extends Component
{
    public $lang;
    public $lang_class;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($lang = null)
    {
        $this->lang = \Str::upper($lang ?? $this->detect_lang());
        switch ($this->lang) {
            case 'SR':
                $this->lang_class = 'rs';
                break;
            case 'EN':
                $this->lang_class = 'us';
                break;
            case 'BS':
                $this->lang_class = 'ba';
                break;
            case 'JA':
                $this->lang_class = 'jp';
                break;
            case 'HI':
                $this->lang_class = 'in';
                break;
            case 'AR':
                $this->lang_class = 'sa';
                break;
            case 'CZ':
                $this->lang_class = 'cz';
                break;
            case 'DA':
                $this->lang_class = 'dk';
                break;
            case 'GA':
                $this->lang_class = 'ie';
                break;
            case 'KA':
                $this->lang_class = 'ge';
                break;
            case 'SV':
                $this->lang_class = 'se';
                break;
            case 'UK':
                $this->lang_class = 'ua';
                break;
            case 'ZH':
                $this->lang_class = 'cn';
                break;
                default:
                $this->lang_class = \Str::lower($this->lang);
                break;
            }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.lang-flag');
    }

    public function detect_lang()
    {
        return app()->getLocale();

        // if (auth()->user()) {
        //     session()->put('locale', auth()->user()->default_language ?: config('app.locale'));
        // }
        // if (session()->has('locale') && isset(config('languages')[session('locale')])) {
        // 	app()->setLocale(session('locale'));
        // 	return $next($request);
        // }

        // app()->setLocale(config('app.fallback_locale'));

        // return $next($request);
    }
}
