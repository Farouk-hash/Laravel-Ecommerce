<?php 
use App\Http\Controllers\CategoriesController;
use App\Http\Middleware\LanguageSwitch;

Route::get('/categories',[CategoriesController::class , 'index'])->name('categories')->middleware(LanguageSwitch::class);
