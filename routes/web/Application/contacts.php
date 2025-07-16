<?php

use App\Http\Middleware\LanguageSwitch;
    
Route::get('contacts' , function(){
    return view('Application.Reviews.review-form');
})->name('contacts.show-contact-form')->middleware(LanguageSwitch::class);
