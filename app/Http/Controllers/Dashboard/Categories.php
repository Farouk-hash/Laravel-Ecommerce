<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Categories_Languages;
use App\Models\Category;
use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;

class Categories extends Controller
{
    public function index(){
        $items = Category::paginate(5);
        // view work for products , categories ;
        return view('Adminpanel.list-items' , ['items'=>$items , 'items_table_title'=>'Categories']); 
    }

    public function create_form(){
        $description = 'This form is used to manage product categories, including category name and hierarchy.';
        return view('adminpanel.create-form',['items_table_title'=>'Categories' , 'description'=>$description]);
    }
    public function store(Request $request){
        $validated = $request->validate([
            'name'=>['required','string','unique:categories'] , 
            'description'=>['required'] ,
            'cover_image'=>['required','max:5120','mimes:jpeg,png,webp'] , 
        ]);
        
        if($request->hasFile('cover_image')){
            $file = $request->file('cover_image');
            $path = $file->store('categories','public');
            $validated['image_path'] = asset('storage/' . $path);   // Full URL for public access
            $validated['file_object_key'] = $path;  
        }
        $category = Category::create($validated);

        return redirect()->route('admin.categories.list-categories');
    }

     public function get_category_details($item_id, bool $edit_form = false){
        $item = Category::findOrFail($item_id);
        $description = 'This form is used to manage product categories, including category name and hierarchy.';

        $view = ($edit_form) ? 'Adminpanel.edit-form' : 'Adminpanel.get-item-details' ;
        $data =  ['item'=>$item, 
        'description'=>$description,'items_table_title'=>'Categories'];

        return view($view ,$data );
    }

    public function update_category(Request $request , int $category_id){
        $validated = $request->validate([
            'name'=>['string','required'],            
            'description'=>['required','string'] , 
        ]);
        $category = Category::find($category_id);

        if($request->hasFile('image')){
            if ($category->file_object_key && Storage::disk('public')->exists($category->file_object_key)) {
                Storage::disk('public')->delete($category->file_object_key);
            }
            
            // ✅ Store the new image
            $file = $request->file('image');
            $path = $file->store('products', 'public');
            
            // Update image fields
            $validated['image_path'] = asset('storage/' . $path);
            $validated['file_object_key'] = $path;
        }
        $category->update($validated);
        return redirect()->route('admin.categories.get-category-details',$category_id);

    }


    public function delete_category($item_id)
    {
        $category = Category::findOrFail($item_id);

        DB::beginTransaction();

        try {
            // Backup the image file before deleting
            $originalImagePath = $category->file_object_key;
            $tempImagePath = null;

            if ($originalImagePath && Storage::disk('public')->exists($originalImagePath)) {
                $tempImagePath = 'temp/' . basename($originalImagePath);
                Storage::disk('public')->copy($originalImagePath, $tempImagePath);
                Storage::disk('public')->delete($originalImagePath);
            }

            // Try to delete the category
            $category->delete();

            // If delete successful, delete the temp backup image
            if ($tempImagePath && Storage::disk('public')->exists($tempImagePath)) {
                Storage::disk('public')->delete($tempImagePath);
            }

            DB::commit();
            return redirect()->back()->with('success', 'Category deleted successfully.');

        } catch (QueryException $e) {
            DB::rollBack();

            // Restore image from temp if it was deleted
            if (isset($tempImagePath) && Storage::disk('public')->exists($tempImagePath)) {
                Storage::disk('public')->copy($tempImagePath, $originalImagePath);
                Storage::disk('public')->delete($tempImagePath);
            }

            if ($e->getCode() === '23000') {
                // 23000 is the SQLSTATE for integrity constraint violation
                return redirect()->back()->with('error', 'Cannot delete category because it is associated with one or more products.');
            }

            // Unexpected error
            return redirect()->back()->with('error', 'An unexpected error occurred while deleting the category.');
        }
    }
    public function translation_form(int $item_id){
        $language = Language::get();
        $category = Category::select(['name','id'])->findOrFail($item_id);
        $description = 'This translation is used as a help text or tooltip for a form that allows users to create or update product information (like name, price, quantity, etc.) in the admin panel.';

        return view('adminpanel.translation-form',['language'=>$language ,'item'=>$category , 'title'=>'Categories','description'=>$description]);    
    }
    public function translate(Request $request){
        $item_id = $request->input('item_id');
        $name = $request->input('name');
        $description = $request->input('description');
        $language_id = $request->input('language_id');

        $categoryLanguage = Categories_Languages::where('categories_id','=',$item_id)
        ->where('language_id','=',$language_id)->first();
        
        if($categoryLanguage){
            $categoryLanguage->update(['name'=>$name , 'description'=>$description]);
        }
        else{
            Categories_Languages::create(['categories_id'=>$item_id ,'name'=>$name , 'language_id'=>$language_id , 'description'=>$description]);
        }
        return redirect()->route('admin.categories.get-category-details',$item_id);
    }
    public function show_translations(int $item_id){
        $categories = Categories_Languages::select(['name','description','language_id'])
        ->with('languages')
        ->where('categories_id','=',$item_id)->get();
        // dd($categories)
        return view('Adminpanel.show-translation',['items'=>$categories, 
        'items_table_title'=>'Category']);
    }
}
