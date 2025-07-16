<?php 

use App\Http\Middleware\LanguageSwitch;
use App\Models\Category;

Route::get('/', function () {
    // Top-Categories ; 
    // Top-Products-Rated ; 
    // Top-Selling-Products ; 
    // Upcoming-Products ; --> is_active = 0 -> can't be added to cart , can be displayed ;  
    // Newest-Products ; 
    $categories = Category::paginate(6);
    return view('Application.index' , ['categories'=>$categories]);
})->name('Home')->middleware(LanguageSwitch::class);
