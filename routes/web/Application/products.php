<?php 
use App\Http\Controllers\ProductsController;
use App\Http\Middleware\LanguageSwitch;

Route::prefix('products')->controller(ProductsController::class)->middleware(LanguageSwitch::class)->group(function () {
    
    Route::get('/', 'show_all_products')->name('products');
    
    Route::get('/product-form', 'show_product_form')->name('product-form');
    Route::post('/store-product', 'store_product')->name('store-product');
    
    Route::get('/product-edit-form/{product_id}', 'show_edit_product_form')->name('products.edit-form');
    Route::put('/{product_id}', 'edit_product')->name('products.edit');
    
    Route::delete('/{product_id}', 'delete_product')->name('products.delete');
});

Route::get('/product/{product_id}',[ProductsController::class , 'get_product_by_id'])
->name('product-details')->middleware(LanguageSwitch::class);
Route::get('/productsTables', [ProductsController::class , 'tables'])
->name('products.product_tables')->middleware(LanguageSwitch::class) ; 

// Gallery For Each Product ; 
Route::get('/showProductsImages/{product_id}' , [ProductsController::class , 'show_images'])
->name('products.show_images')->middleware(LanguageSwitch::class) ; 

Route::get('/deleteProductImage/{gallery_id}' , [ProductsController::class, 'delete_image_gallery'])
->name('products.remove-product-image-gallery')->middleware(LanguageSwitch::class);

Route::post('/productsImagesUploaded/{product_id}' ,[ProductsController::class, 'upload_gallery'])
->name('products.upload-gallery-images')
->middleware(LanguageSwitch::class);