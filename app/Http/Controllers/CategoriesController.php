<?php

namespace App\Http\Controllers;

use App\Models\Categories_Languages;
use App\Models\Category;
use App\Models\Product;
use App\Models\Products_Languages;
use Illuminate\Http\Request;
use Session;

class CategoriesController extends Controller
{
    public function index(Request $request){
        $language_id = Session::get('language_id');

        $categories = Category::has('products')->select(['id','name','file_object_key'])->get();
        if($language_id != 1){
            foreach($categories as $category){
                $translated_categories = Categories_Languages::
                where('categories_id' , '=' , $category->id)
                ->where('language_id','=',$language_id)
                ->select('name')->first();
                $category->name = $translated_categories->name ?? $category->name ; 
            }
        }        
        $query = Product::query();
        $activeCategory = $request->query('category'); 
        
        if ($activeCategory) {
            $query->where('category_id', $activeCategory);
        }
        
        $products = $query->select(['name','id','price','quantity','file_object_key'])->paginate(6);
        if($language_id != 1){
            foreach($products as $product){
                $translated_product = Products_Languages::where('product_id' , '=' , $product->id)
                ->select('name')->first();
                $product->name = $translated_product->name ?? $product->name ; 
            }
        }   
        return view('Application.categories' , ['categories'=>$categories , 'products'=>$products,'activeCategory' => $activeCategory]) ;
}
}
