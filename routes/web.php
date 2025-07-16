<?php

use App\Http\Controllers\Dashboard\Categories;
use App\Http\Controllers\Dashboard\HomeController;
use App\Http\Controllers\Dashboard\Products;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\ProductsController;
use App\Http\Middleware\CheckRoles;
use Illuminate\Support\Facades\Route;

foreach (glob(__DIR__ . '/web/Application/*.php') as $routeFile) {
    require $routeFile;
}

Route::post('/lang' , [LanguageController::class , 'index'])->name('language.switch');

Route::get('/admin',[HomeController::class , 'index'])->name('admin.home');
// ->middleware([CheckRoles::class . ':admin,sales']);

Route::get('/admin/products',[Products::class , 'index'])->name('admin.products.list-products');
Route::get('/admin/categories',[Categories::class , 'index'])->name('admin.categories.list-categories');

Route::get('/admin/products/create-form' , [Products::class , 'create_form'])->name('admin.products.create-form');
Route::get('/admin/categories/create-form' , [Categories::class , 'create_form'])->name('admin.categories.create-form');

Route::post('/admin/products' , [Products::class , 'store'])->name('admin.products.store');
Route::post('/admin/categories',[Categories::class , 'store'])->name('admin.categories.store');

Route::get('/admin/products/translation-form/{item_id}' , [Products::class , 'translation_form'])->name('admin.products.translation-form');
Route::get('/admin/categories/translation-form/{item_id}' , [Categories::class , 'translation_form'])->name('admin.categories.translation-form');

Route::post('/admin/products/translation-form' , [Products::class , 'translate'])->name('admin.products.translate');
Route::post('/admin/categories/translation-form' , [Categories::class , 'translate'])->name('admin.categories.translate');

Route::get('/admin/products/show_translations/{item_id}',[Products::class,'show_translations'])->name('admin.products.show-translations');
Route::get('/admin/categories/show_translations/{item_id}',[Categories::class,'show_translations'])->name('admin.categories.show-translations');

// Work for get-[product,category]-details , get-[product,category]-edit-form ; 
Route::get('/admin/products/{item_id}/{edit_form?}',[Products::class , 'get_product_details'])->name('admin.products.get-product-details');
Route::get('/admin/categories/{item_id}/{edit_form?}',[Categories::class , 'get_category_details'])->name('admin.categories.get-category-details');

Route::put('/admin/update_product/{item_id}' , [Products::class , 'update_product'])->name('admin.products.update-product');
Route::put('/admin/update_category/{item_id}' , [Categories::class , 'update_category'])->name('admin.categories.update-categories');

Route::delete('/admin/products/{item_id}' , [Products::class , 'delete_product'])->name('admin.products.delete-product');
Route::delete('/admin/categories/{item_id}' , [Categories::class , 'delete_category'])->name('admin.categories.delete-category');

Route::delete('/admin/products/gallery-images/{image_id}' , [Products::class , 'delete_image_gallery'])->name('admin.products.delete-image-from-gallery');
Route::delete('/admin/categories/gallery-images/{image_id}' , [Categories::class , 'delete_image_gallery'])->name('admin.categories.delete-image-from-gallery');
