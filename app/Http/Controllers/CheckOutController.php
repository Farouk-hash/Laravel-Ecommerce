<?php

namespace App\Http\Controllers;

use App\Models\BillingAdresses;
use App\Models\Cart;
use App\Models\Orders;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class CheckOutController extends Controller
{
    // show_save_later -> for cart-icon-count -> came-from save_later_page , pending_items_page ; 
    public function index(int $show_save_later , bool $check_out_form_history=false , int $order_id = null){
        $user_id = auth()->user()->id ;
        if($order_id){
            return $this->get_order_details($order_id , $show_save_later , $check_out_form_history);
        }
        if(!$check_out_form_history){
            // User Infomrations For Billing-Addresses Works As backup ;
            $user_information = User::select(['name', 'email'])->findOrFail($user_id);

            $billing = BillingAdresses::where('user_id', $user_id)
                ->select(['name', 'email', 'phone', 'something', 'address'])
                ->orderByDesc('id')
                ->first();

            $user_data = (object)[
                'name'     => $billing->name     ?? $user_information->name,
                'email'    => $billing->email    ?? $user_information->email,
                'phone'    => $billing->phone    ?? null,
                'something'=> $billing->something?? null,
                'address'  => $billing->address  ?? null,
            ];



            // Current Cart Items ; 
            $cart_data = Cart::where('user_id' , $user_id)->where('finished',false)
            ->where('save_later' , '!=' , $show_save_later)
            ->orderByDesc('updated_at')->with('product')->select(['total','id','product_id'])->get();
            return view('Application.Checkouts.check-outs-form' , ['cart_data'=>$cart_data , 'show_save_later'=>$show_save_later , 
            'user_data'=>$user_data]);
        }
        return $this->show_orders($show_save_later);
        
    }

   
    public function place_order(Request $request){
        $data = $request->validate([
            'name'=>['string','required'] ,
            'email'=>['email','required'] ,
            'phone'=>['string','required'] ,
            'address'=>['string','required'] ,
            'cart_id'=>['array','required'] ,
            'cart_id.*'=>['int','required','exists:carts,id'] ,
        ]);
        $user_id = auth()->user()->id;
        $data['user_id']=$user_id;
        //billing-address-for-current-user ; 
        $billing_address = BillingAdresses::create($data);
        $billind_address_id = $billing_address->id;
        
        $cart_item_ids = $request->input('cart_id',[]);

        foreach($cart_item_ids as $cart_id){
            $cart = Cart::find($cart_id) ;
            $cart->update(['finished'=>1]);
            $billing_address->total +=$cart->total ;
            $billing_address->save();
            Orders::create(['billing_addresses_id'=> $billind_address_id, 'carts_id'=>$cart_id]);

            // Decrement quantity of products ; 
            $quantity_of_cart = $cart->quantity ; 
            $product = Product::find($cart->product_id);
            $product->quantity -= $quantity_of_cart;
            $product->save();
        }
        return redirect()->route('checkout.checkout-form',[1,1,$billind_address_id]);
    }

    public function show_orders(int $show_save_later){
        $user_id = auth()->user()->id ;
        $billing_address_array = BillingAdresses::where('user_id','=',$user_id)->get();

        return view('Application.Checkouts.orders',['show_save_later'=>$show_save_later ,
        'billing_address_array'=>$billing_address_array ]);
    }

    public function get_order_details(int $order_id ,int $show_save_later , bool $check_out_form_history ){
        $user_id = auth()->user()->id ;
        $billing_address = BillingAdresses::with(['orders'])->where('user_id','=',$user_id)
        ->where('id','=',$order_id)->first();
        
        $related_products = [];
        foreach($billing_address->orders as $order){

            $related_products[] = (object)[
                'id'=>$order->carts->product_id,
                'name'=>$order->carts->product->name ,
                'description'=>$order->carts->product->description ,
                'price'=>$order->carts->price , 
                'quantity'=>$order->carts->quantity , 
                'image'=>$order->carts->product->file_object_key , 
                'date'=>$order->carts->updated_at ?? $order->carts->created_at,
                'status'=>$order->status
            ];
            $billing_address['products'] = $related_products;
        }
        $order_products = $billing_address;
        return view('Application.checkouts.orders-details',['order_id'=> $order_id , 'order_products'=>$order_products]);
    }
}
