<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;

class CartsController extends Controller
{
    public function index(int $save_later = 0){
        $user_id = auth()->user()->id ;
        $cart_data = Cart::where('user_id' , $user_id)->where('finished',false)
        ->where('save_later' , '=' , $save_later)
        ->orderByDesc('updated_at')->with('product')->get();
        return view('Application.carts.carts' , ['cart_data'=>$cart_data , 'show_save_later'=>$save_later == 0 ? true:false]);
    }

    public function add_to_cart(int $product_id , int $quantity = 0){
        $product = Product::findOrFail($product_id);
        $user_id = auth()->user()->id ; 

        $cart = Cart::where('user_id' , $user_id)
        ->where('product_id' , $product_id)
        ->where('finished' , false)
        ->orderBy('id' , 'DESC')->first();

        $quantity = $quantity == 0 ? 1 : $quantity ; 
        if($cart){
            // increment quantity of product ; 
            $cart->quantity += $quantity ;
            $cart->total = $cart->price * $cart->quantity;
            $cart->save();
        }
        else{
            Cart::create(['product_id'=>$product_id , 'user_id'=>$user_id , 'price' => $product->price , 'quantity'=>$quantity , 'total' => $product->price]);
        }
        
        // total-price will be sent to view via key for client-side ; 
        return redirect()->back()->with('success' , 'Product added to cart');
    }

    public function update_cart(Request $request)
    {
        
        if($request->has('save_for_later')){
            $cartItems = $request->input('cart_items');
            $selected_items = $request->input('buy_now_items' , []);
            $save_for_later_or_return_to_pending_value = $request->input('save_for_later');
            $cartItemsById = [];
            foreach ($cartItems as $item) {
                $cartItemsById[$item['id']] = $item;
            }
            
            foreach($selected_items as $selected_id){
                if(isset($cartItemsById[$selected_id])){
                   Cart::find($selected_id)->update(['save_later'=>$save_for_later_or_return_to_pending_value]);
                }
            }
            
        }

        // First, handle removing selected items (if remove_selected button was clicked)
        if ($request->has('remove_selected') && $request->has('remove_items')) {
            $itemsToRemove = $request->input('remove_items');
                
            // Remove selected cart items
            $removedCount = Cart::whereIn('id', $itemsToRemove)
                ->where('user_id', auth()->id()) // Ensure user can only remove their own items
                ->delete();
                
            }
            
        // Then, handle updating cart quantities for remaining items (always do this if cart_items exist)
        if ($request->has('cart_items')) {
                $cartItems = $request->input('cart_items');
                
                foreach ($cartItems as $item) {
                    $cart = Cart::where('id', $item['id'])
                            ->where('user_id', auth()->id())
                            ->where('save_later' , '!=' , true)
                            ->first();
                    
                    if ($cart && isset($item['quantity']) && $item['quantity'] > 0) {
                        $cart->quantity = $item['quantity'];
                        $cart->total = $cart->price * $item['quantity'];
                        $cart->save();
                    }
                }
            }
            
        return back();
    } 


}
