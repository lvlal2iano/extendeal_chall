<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;
use App\Models\Pais;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend('cuadro_fields', function ($attribute, $value, $parameters, $validator)
        {
            $keywords = explode(',', $value);
            $fields = ['nombre','autor','precio','anio_creacion','alto','ancho'];

            foreach($keywords as $keyword)
            {
                // do validation logic
                if(!in_array($keyword, $fields))
                {
                    return false;
                }
            }

            return true;
        });

        Validator::extend('internacional_code', function ($attribute, $value, $parameters, $validator)
        {
            $pais = Pais::where('code',$value)->first();

            return (bool) $pais;
        });
    }
}
