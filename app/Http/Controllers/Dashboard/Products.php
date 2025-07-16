<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ProductsController;
use App\Models\Category;
use App\Models\Language;
use App\Models\Product;
use App\Models\ProductImages;
use App\Models\Products_Languages;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Storage;

class Products extends Controller
{
    public function index(){
        $items = Product::paginate(5);
        // view work for products , categories ;
        return view('Adminpanel.list-items' , ['items'=>$items , 'items_table_title'=>'Products']);
    }
    public function create_form(){
        $description = 'This form is used to create or update product details such as name, price, and description.';
        $categories_for_products_create_form = Category::get();
        return view('adminpanel.create-form',['items_table_title'=>'Products' , 'description'=>$description ,'categories_for_products_create_form'=>$categories_for_products_create_form ]);
    }

    public function store(Request $request){
        $validated = $request->validate([
        'name'=>['string','required' , 'unique:products','max:255'],
        'category_id'=>['required','exists:categories,id'],
        'price'       => ['required', 'numeric', 'min:0'],
        'quantity'    => ['required', 'integer', 'min:0'],
        'description' => ['required', 'string'],

        'cover_image'=>['required','max:5120','mimes:jpeg,png,webp'] , 

        'gallery_images' =>['required' ,'array'] , 
        'gallery_images.*' =>['required' ,'mimes:jpeg,png,webp']
        ]) ; 

        if($request->hasFile('cover_image')){
            $file = $request->file('cover_image');
            $path = $file->store('products','public');
            $validated['image_path'] = asset('storage/' . $path);   // Full URL for public access
            $validated['file_object_key'] = $path;  
        }
        $product = Product::create($validated);

        $product_id = $product->id ; 
        $gallery_images = $request->file('gallery_images');

        // Create a Gallery For Product's Images ;
        foreach($gallery_images as $image){
            $path = $image->store('products','public');
            ProductImages::create(['product_id'=>$product_id , 
            'image_path'=>asset('storage/' . $path) , 
            'file_object_key'=>$path]);
        }

        return redirect()->route('admin.products.list-products');
    }

    public function get_product_details(int $item_id , bool $edit_form = false){
        $item = Product::select(['name','description','price','quantity','file_object_key','id','category_id'])
        ->with(['category','images','reviews_txt'])
        ->findOrFail($item_id);
        $description = 'This form is used to create or update product details such as name, price, and description.';
        $product_gallery = $item->images;

        $product_txt_review = $item->reviews_txt;

        $view = ($edit_form) ? 'Adminpanel.edit-form' : 'Adminpanel.get-item-details' ;
        $data =  ['item'=>$item, 
        'item_images'=>$product_gallery , 'product_txt_review'=>$product_txt_review,
        'description'=>$description,'items_table_title'=>'Products'];

        if($edit_form){
            $data['categories_for_products'] = Category::get();
        }
        return view($view ,$data );
    }

    public function update_product(Request $request , int $product_id){
        $product_class = new ProductsController();
        $request->merge(['product_id' => $product_id]);
        return $product_class->edit_product(request:$request , continue_key:true);
    }

    public function delete_image_gallery(int $gallery_id){
        $product_class = new ProductsController();
        return $product_class->delete_image_gallery($gallery_id);
    }
   
    public function delete_product(int $item_id){
        $product_class = new ProductsController();
        return $product_class->delete_product($item_id);
    }

    public function translation_form(int $item_id){
        $language = Language::where('id','!=',1)->get();
        $product = Product::select(['name','id'])->findOrFail($item_id);
        $description = 'This translation is used as a help text or tooltip for a form that allows users to create or update product information (like name, price, quantity, etc.) in the admin panel.';

        return view('adminpanel.translation-form',['language'=>$language , 'item'=>$product , 'title'=>'Products','description'=>$description]);
    }

    public function translate(Request $request){
        $item_id = $request->input('item_id');
        $name = $request->input('name');
        $description = $request->input('description');
        $language_id = $request->input('language_id');

        $productLanguage = Products_Languages::where('product_id','=',$item_id)
        ->where('language_id','=',$language_id)->first();
        
        if($productLanguage){
            $productLanguage->update(['name'=>$name , 'description'=>$description]);
        }
        else{
            Products_Languages::create(['product_id'=>$item_id ,'name'=>$name , 'language_id'=>$language_id , 'description'=>$description]);
        }
        return redirect()->route('admin.products.get-product-details',$item_id);
    }

    public function show_translations(int $item_id){
        $products = Products_Languages::select(['name','description','language_id'])
        ->with('languages')
        ->where('product_id','=',$item_id)->get();

        return view('Adminpanel.show-translation',['items'=>$products, 
        'items_table_title'=>'Products']);
    }
}
