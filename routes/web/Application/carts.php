<?php 
use App\Http\Middleware\Authenticate;
use App\Http\Middleware\LanguageSwitch;
use App\Http\Controllers\CartsController;

Route::prefix('carts')->middleware([Authenticate::class,LanguageSwitch::class])->controller(CartsController::class)
->group(function(){
    Route::get('/{save_later?}', 'index')->name('carts.carts-view');
    Route::get('carts/{product_id}/{quantity?}' , 'add_to_cart')->name('carts.add-to-cart');
    // update-cart , delete item from cart -> depends on button-action-name ; 
    Route::post('carts' , 'update_cart')->name('carts.update-cart'); 
});