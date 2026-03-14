<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

class ComponentServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::component('input-text', \App\View\Components\Forms\InputText::class);
        Blade::component('input-password', \App\View\Components\Forms\InputPassword::class);
        Blade::component('input-number', \App\View\Components\Forms\InputNumber::class);
        Blade::component('input-checkbox', \App\View\Components\Forms\InputCheckbox::class);
        Blade::component('input-select', \App\View\Components\Forms\InputSelect::class);
        Blade::component('input-textarea', \App\View\Components\Forms\InputTextarea::class);
        Blade::component('input-flatpickr', \App\View\Components\Forms\InputFlatpickr::class);
        Blade::component('input-tinymce', \App\View\Components\Forms\InputTinymce::class);
        Blade::component('input-file', \App\View\Components\Forms\InputFile::class);
        Blade::component('input-radio', \App\View\Components\Forms\InputRadio::class);
        Blade::component('input-custom-number', \App\View\Components\Forms\InputCustomNumber::class);
        Blade::component('input-potpis', \App\View\Components\Forms\InputPotpis::class);
        Blade::component('tabs', \App\View\Components\Tabs::class);
        Blade::component('tab', \App\View\Components\Tab::class);
        Blade::component('permission-link', \App\View\Components\PermissionLink::class);
        Blade::component('lang-flag', \App\View\Components\LangFlag::class);
    }
}
