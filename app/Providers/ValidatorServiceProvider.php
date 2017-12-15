<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ValidatorServiceProvider extends ServiceProvider
{
    
    protected $validators = [
        'App\Validator\PasswordValidator'
    ];

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->bootValidator();
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    protected function bootValidator()
    {
        foreach ($this->validators as $validator) {
            $this->app['validator']->resolver(function ($translator, $data, $rules, $messages) use ($validator) {
                return new $validator($translator, $data, $rules, $messages);
            });
        }
    }
}
