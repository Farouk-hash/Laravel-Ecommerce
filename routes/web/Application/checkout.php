<?php
use App\Http\Middleware\Authenticate;
use App\Http\Middleware\LanguageSwitch;
use App\Http\Controllers\CheckOutController;

Route::prefix('checkout')->middleware([Authenticate::class,LanguageSwitch::class])->controller(CheckOutController::class)
->group(function(){
    Route::get('/{show_save_later}/{check_out_form_history?}/{order_id?}','index')->name('checkout.checkout-form');
    Route::post('/','place_order')->name('checkout.place-order');
});
