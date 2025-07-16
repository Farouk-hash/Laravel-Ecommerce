<?php 
use App\Http\Controllers\QuestionsReviewsController;

Route::get('rating_reviews/{question_type}/{product_id}' , [QuestionsReviewsController::class , 'index'])->name('rating_reviews.review-form');
Route::post('rating_reviews' , [QuestionsReviewsController::class , 'storeRating'])->name('rating_reviews.store-rating');
