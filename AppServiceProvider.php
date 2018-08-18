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
     public function boot(){    
        //Check for 'lang' cookie
        $cookie = Cookie::get('lang');
        //Get visitors IP
        $ip = \Request::ip();
        //Get visitors Geo info based on his IP
        $geo = GeoIP::getLocation($ip);
        //Get visitors country name
        $country = $geo['country'];

        //Prepared language based on country name
        $languages = [
            'United States' => 'en',
            'Canada' => 'en',
            'Germany' => 'de',
            'Bosnia and Herzegovina' => 'ba',
            'Croatia' => 'ba',
            'Serbia' => 'ba',
            'Austria' => 'de',
            'Luxembourg' => 'de',
        ];

        if(!isset($cookie) && !empty($cookie)) {
            //If cookie exist change application language
            //We use this for good measure
            App::setLocale($cookie); 
        }else {
            //If cookie doesnt exist
            //Check country name in languages array
            if (array_key_exists($country, $languages)) {
                //Get country value(language) from array
                $lang = $languages[$country];
                //Set language based on value
                App::setLocale($lang); 

            }
            else {
                //Set language for good measure
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
