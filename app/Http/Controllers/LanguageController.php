<?php

namespace App\Http\Controllers;

use App;
use App\Models\Language;
use Illuminate\Http\Request;
use Session;

class LanguageController extends Controller
{
    public function index(Request $request)
    {
        $selectedLocale = $request->input('locale');
        $language = Language::findOrFail($selectedLocale);
        // $language-symbol for client-side localization , language-id for server-side ;
        Session::put(['locale'=> $language->symbol , 'language_id'=>$language->id]);                
        return redirect()->back();
    }
}