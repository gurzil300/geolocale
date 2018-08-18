<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Cookie;
use App;

class LanguageController extends Controller
{
    public function change($lang) {
        //languages you will be using in your app.
        $languages = ['de','en','ba','fr','es'];

        //Chech if language in link exist in array of languages you will be using in your app
        if(in_array($lang, $languages)) {
            //Set cookie for furder check
            //We use this to make sure language doesnt change on every App boot
            //Cookie will expire in one week
            Cookie::queue(Cookie::make('lang', $lang , '10080'));
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
