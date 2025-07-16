<?php

namespace App\Http\Controllers;

use App\Models\Categories_Languages;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImages;
use App\Models\Products_Languages;
use DB;
use \Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Session;

class ProductsController extends Controller
{
    
    public function show_product_form(){
        $categories = Category::get();
        return view('Application.products.product-form' , ['categories'=>$categories]);
    }

    public function store_product(Request $request){
        $validated = $request->validate([
        'name'=>['string','required' , 'unique:products','max:255'],
        'category_id'=>['required','exists:categories,id'],
        'price'       => ['required', 'numeric', 'min:0'],
        'quantity'    => ['required', 'integer', 'min:0'],
        'description' => ['nullable', 'string'],

        'cover_image'=>['required','max:5120','mimes:jpeg,png,webp'] , 

        'images' =>['required' ,'array'] , 
        'images.*' =>['required' ,'mimes:jpeg,png,webp']
        ]) ; 

        if($request->hasFile('cover_image')){
            $file = $request->file('cover_image');
            $path = $file->store('products','public');
            $validated['image_path'] = asset('storage/' . $path);   // Full URL for public access
            $validated['file_object_key'] = $path;  
        }
        $product = Product::create($validated);

        $product_id = $product->id ; 
        $gallery_images = $request->file('images');
        // Create a Gallery For Product's Images ;
        $this->add_images($product_id , $gallery_images);

        return redirect()->route('products');
    }

    public function show_all_products(bool $not_work_for_jquery = true){
        $language_id = Session::get('language_id');
        $products = $not_work_for_jquery ? Product::orderByDesc('id')->paginate(6) :  Product::get();

        if($language_id != 1 ){
            foreach($products as $product){
                $translated_product = Products_Languages::where('product_id' , '=' , $product->id)
                ->where('language_id','=',$language_id)
                ->select(['name','description'])->first();
                $product->name = $translated_product->name ?? $product->name;
                $product->description = $translated_product->description ?? $product->description;
            }
        }
        $view = $not_work_for_jquery ? 'Application.products.products' : 'Application.products.products_tables';
        return view($view,['products'=>$products]);
    }

    public function delete_product(int $product_id){
        $product = Product::find($product_id);
        if ($product->file_object_key && Storage::disk('public')->exists($product->file_object_key)) {
            Storage::disk('public')->delete($product->file_object_key);
        }
        $product->destroy($product_id);
        return redirect()->back();
    }

    public function show_edit_product_form(int $product_id){
        $product = Product::with('category')->find($product_id); 
        $categories = Category::all();
        return view('Application.products.edit-product-form' , ['product'=>$product , 'categories'=>$categories]);
    }

    public function edit_product(Request $request , bool $continue_key = false){
        $validated = $request->validate([
            'name'=>['string','required'],
            'price'=>['required','numeric'],
            'quantity'=>['required','integer'],
            'category_id'=>['required','exists:categories,id'],
            'description'=>['required','string'] , 
        ]);
        $id = $request->route('product_id') ?? $request->input('product_id');
        $product = Product::find($id);

        if($request->hasFile('image')){
            if ($product->file_object_key && Storage::disk('public')->exists($product->file_object_key)) {
                Storage::disk('public')->delete($product->file_object_key);
            }
            
            // ✅ Store the new image
            $file = $request->file('image');
            $path = $file->store('products', 'public');
            
            // Update image fields
            $validated['image_path'] = asset('storage/' . $path);
            $validated['file_object_key'] = $path;
        }
        $product->update($validated);
        if ($continue_key){
            if($request->file('gallery_image')){
                return $this->upload_gallery($request ,  $id);
            }
            else{
                return redirect()->route('admin.products.get-product-details',$id);
            }
        }
        else{
            // get product details by id ;
            return redirect()->route('products');
        }
    }

    public function get_product_by_id(int $product_id){
        $product = Product::with(['images','reviews_txt','reviews_rating'])->find($product_id);

        // Related products [Same category-id , price-Range];
        $common_category_id = $product->category_id ; 
        $approximate_price = $product->price * 0.25 ; 
        $min_price = $product->price - $approximate_price ; 
        $max_price = $approximate_price + $product->price ; 

        $related_products = Product::with('images')
        ->where('category_id' , '=' , $common_category_id)
        ->where('id' , '!=' , $product_id)
        ->whereBetween('price', [$min_price,$max_price])
        ->get();
        
        $language_id = Session::get('language_id') ;
        if($language_id != 1){
            $translated_product = Products_Languages::where('product_id' , '=' , $product->id)
            ->where('language_id','=',$language_id)
            ->select(['name','description'])->first();
            $translated_category = Categories_Languages::where('categories_id' , '=' ,$product->category_id)
            ->where('language_id','=',$language_id)->select(['name','description'])->first();
            
            $product->name = $translated_product->name ?? $product->name;
            $product->description = $translated_product->description ?? $product->description;
            $product->category->name = $translated_category->name ??$product->category->name;
            if($related_products->isNotEmpty()){
                foreach($related_products as $related_product)
                $translated_product = Products_Languages::where('product_id' , '=' , $related_product->id)
                ->where('language_id','=',$language_id)
                ->select(['name','description'])->first();
                $related_product->name = $translated_product->name ?? $product->name;
                $related_product->description = $translated_product->description ?? $product->description;
            }
        }

       // Reviews Business Logic

        $user = auth()->user();
        $current_user_id = $user ? $user->id : null;

        $user_reviews = [];
        $reviews_txts = $product->reviews_txt;

        // Get average ratings grouped by user_id
        $reviews_rating = $product->reviews_rating->groupBy('user_id')->map(function($ratings) {
            return round($ratings->avg('rating_value'));
        });

        // Process review texts and assign types
        foreach($reviews_txts as $index => $reviews_txt) {
            $user_reviews[$index] = $reviews_txt;
            
            // Determine if this is the current user's review
            if($current_user_id && $reviews_txt->user_id == $current_user_id) {
                $user_reviews[$index]['type'] = 'my';
            } else {
                $user_reviews[$index]['type'] = 'others';
            }
            
            // Assign rating if exists for this user
            if(isset($reviews_rating[$reviews_txt->user_id])) {
                $user_reviews[$index]['rating'] = $reviews_rating[$reviews_txt->user_id];
            } else {
                $user_reviews[$index]['rating'] = null; // or 0, depending on your preference
            }
        }
        return view('Application.products.single-product' , ['product'=>$product , 'related_products'=>$related_products , 
        'user_reviews'=>$user_reviews ]);

    }

    public function tables(){
        return $this->show_all_products(not_work_for_jquery:false);
    }


    // FOR GALLERY ; 
    public function show_images(int $product_id){
        $product_images = ProductImages::where('product_id' ,'=', $product_id)->get();

        return view('Application.products.show_images' , ['product_images'=>$product_images , 'product_id'=>$product_id]);
    }

    public function upload_gallery(Request $request , int $product_id){
        $gallery_images = $request->file('gallery_image');
        $this->add_images($product_id , $gallery_images);
        return back();
    }
    public function add_images(int $product_id ,array $gallery_images){
        foreach($gallery_images as $image){
            $path = $image->store('products','public');
            ProductImages::create(['product_id'=>$product_id , 
            'image_path'=>asset('storage/' . $path) , 
            'file_object_key'=>$path]);
        }
    }

    public function delete_image_gallery(int $gallery_id){
        $product_gallery = ProductImages::findOrFail($gallery_id);
        if ($product_gallery->file_object_key && Storage::disk('public')->exists($product_gallery->file_object_key)) {
            Storage::disk('public')->delete($product_gallery->file_object_key);
        }
        $product_gallery->delete();
        return back();
    }

}
