### Change language based on GEO location for Laravel 5
In this tutorial i will show you how to set visitors language based on his country name and also how he can change website language if visitors wants that.
```
```
### Setup
First we will need GeoIP package so we can get visitor country name.
From the command line run:
```
 composer require torann/geoip
```
Once installed you need to register the service provider with the application. Open up config/app.php and find the providers key.
```
  'providers' => [

      \Torann\GeoIP\GeoIPServiceProvider::class,

  ]
```
This package also comes with an optional facade, which provides an easy way to call the the class. Open up config/app.php and find the aliases key.
```
'aliases' => [

    'GeoIP' => \Torann\GeoIP\Facades\GeoIP::class,

];
```
Run this on the command line from the root of your project:
```
  php artisan vendor:publish --provider="Torann\GeoIP\GeoIPServiceProvider" --tag=config
```
After you install package go to the and learn more about templates.
* [Laravel localization](https://laravel.com/docs/5.6/localization) - Laravel's localization features
 
First we need to make controller so user can change language if he doesnt want language which is set automatically.
Go to the routes file routes/web.php and add this route.
```  
  Route::get('/language/{lang}','LanguageController@change')->name('lang');
```
Then after that create new controller with command
```  
  php artisan make:controller LanguageController
```
In language controller add this code(In comments it is explained line by line)
```
  <?php

  namespace App\Http\Controllers;

  use Illuminate\Http\Request;
  use Cookie;
  use App;

  class LanguageController extends Controller
  {
      public function change($lang) {
          //Languages you will be using in your app.
          $languages = ['de','en','ba','fr','es'];

          //Chech if language in link exist in array of languages you will be using in your app
          if(in_array($lang, $languages)) {
              //Set cookie for furder check
              //We use this to make sure language doesnt change on every App boot
              //Cookie will expire in two weeks
              //Change expire based on your wants and needs
              Cookie::queue(Cookie::make('lang', $lang , '20160'));
              //Redirect back
              return back();

          } else {
              //We use this for good measure
              //Set default language
              App::setLocale(App::getLocale()); 
              //Redirect back
              return back();
          }

      }
  }
```
Now user can set language based on his wish.Now we will type code that will change language of application based on country visitor is comming rom
In AppServiceProvider app/Providers/AppServiceProvider.php change boot function(If function is blank).
```
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
        //Add as many as you want
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
```
After this you can add route in your index template so visitor can switch language
```
  <ul>
      <li><a href="{{route('lang', 'ba')}}"><img src="{{asset('app/ba.png')}}" alt="Bosanski">Bosanski</a></li>
      <li><a href="{{route('lang', 'en')}}"><img src="{{asset('app/en.png')}}" alt="English">English</a></li>
      <li><a href="{{route('lang', 'es')}}"><img src="{{asset('app/es.png')}}" alt="Espanol">Espanol</a></li>
      <li><a href="{{route('lang', 'fr')}}"><img src="{{asset('app/fr.png')}}" alt="Francais"> Francais </a></li>
    </ul>
```
If you have any questions feel free to contact me.
