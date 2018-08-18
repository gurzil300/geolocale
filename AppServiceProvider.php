<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App;
use Cookie;
use GeoIP;
use Request;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {    
        //INFO
        $cookie = Cookie::get('lang');
        $ip = \Request::ip();
        $geo = GeoIP::getLocation($ip);
        $country = $geo['country'];

        //PREPARED COUNTRY LANGUAGES

        $languages = [
            'United States' => 'en',
            'Germany' => 'de',
            'Bosnia and Herzegovina' => 'ba',
            'Croatia' => 'ba',
            'Serbia' => 'ba',
            'Austria' => 'de',
            'Luxembourg' => 'de',
        ];

        if(isset($cookie) && !empty($cookie)) {
            //Set language
            App::setLocale($cookie); 
        }else {
            if (array_key_exists($country, $languages)) {
                //GET VALUE FROM ARRAY
                $lang = $languages[$country];
                //Set language
                App::setLocale($lang); 

            }
            else {
                //Set language
                App::setLocale(App::getLocale()); 
            }
        }


    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
