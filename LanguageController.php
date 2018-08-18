<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Cookie;
use App;

class LanguageController extends Controller
{
    public function change($lang) {

        //App languages
        $languages = ['de','en','ba','fr'];

        if(in_array($lang, $languages)) {

            //Set cookie for furder check
            Cookie::queue(Cookie::make('lang', $lang , '10080'));
            //Redirect back
            return back();

        } else {
            //For good measure
            //Set default language
            App::setLocale(App::getLocale()); 
            //Redirect back
            return back();
        }

    }
}
