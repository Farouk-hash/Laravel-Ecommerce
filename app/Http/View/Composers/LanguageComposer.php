<?php

namespace App\Http\View\Composers;

use Illuminate\View\View;
use App\Models\Language; 

class LanguageComposer
{
    /**
     * Bind data to the view.
     */
    public function compose(View $view)
    {
        $languages = Language::select( 'id','name', 'symbol')->get()
            ->mapWithKeys(function ($language) {
                return [
                    $language->id => [
                        'name' => $language->name,
                        'flag' => $language->symbol,
                        'id' =>$language->id
                    ]
                ];
            });

        $view->with('languages', $languages);
    }
}