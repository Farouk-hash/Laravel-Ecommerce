<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductUserReview;
use App\Models\RatingQuestion;
use App\Models\RatingQuestionUserProduct;
use Illuminate\Http\Request;

class QuestionsReviewsController extends Controller
{
    
    public function index(string $question_type , int $product_id){
        $rating_questions = RatingQuestion::where('question_type' , '=' ,$question_type)->get();
        $product = Product::where('id','=',$product_id)->select(['id' , 'name'])->get();
        return view('Application.Questions_reviews.review-form' , ['rating_questions'=>$rating_questions , 'product'=>$product[0]]);
    }

    public function storeRating(Request $request){
        // user-id ; 
        $user_id = auth()->user()->id;
        // product-id ; 
        $product_id = $request->input('product_id');
        $bros = $request->input('review_bros');
        $cons = $request->input('review_cons');
        // bros , cons --> store at ProductUserReview ; 
        ProductUserReview::create([
            'user_id'=>$user_id , 
            'product_id'=>$product_id , 
            'bros'=>$bros , 
            'cons'=>$cons,
        ]);

        // questions_ids --> store at RatingQuestionUserProduct
        $questions_ids = $request->input('question_ids' , []);
        foreach($questions_ids as $question_id){
            $question_rating_value = $request->input('rating_'.$question_id) ?? 1 ;
            RatingQuestionUserProduct::create(['user_id'=>$user_id , 'product_id'=>$product_id , 'rating_value'=>$question_rating_value , 'rating_questions_id'=>$question_id]);
        }

        return redirect()->route('product-details' , ['product_id'=>$product_id]);
    }
}
