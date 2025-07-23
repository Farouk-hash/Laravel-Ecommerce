<?php

namespace App\Http\Controllers;

use App\Events\SendMessage;
use App\Events\Typing;
use App\Events\UserChatStatus;
use App\Models\Chat;
use \Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class User extends Controller
{
    public function index(){
        // get user infomrations ; 
        $user_id = Auth::id();
        
        $user_informations = \App\Models\User::with(['billing_addresses'])->find($user_id);
        $cart_counts = \App\Models\Cart::where('user_id', $user_id)
            ->selectRaw('
                COUNT(CASE WHEN save_later = 1 THEN 1 END) as wish_list_count,
                COUNT(CASE WHEN save_later != 1 THEN 1 END) as orders_count
            ')
            ->first();

        $wish_list_count = $cart_counts->wish_list_count;
        $orders_count = $cart_counts->orders_count;
        return view('Application.users.get-user-profile' , compact('user_informations' , 'orders_count' , 'wish_list_count'));
    }

    public function update_profile_form(int $user_id){
        $user_information = \App\Models\User::findOrFail($user_id);
        return view('application.users.get-user-update-profile' , compact('user_information'));
    }

    public function update_profile(Request $request , int $user_id){
        $user_information = \App\Models\User::findOrFail($user_id);
        
        $validated = $request->validate([
            'name'=>['string','required'],
            'phone'=>['string', 'required'],
            'email'=>['string','required']
        ]);
        
        if($request->hasFile('avatar')){
            if ($user_information->file_object_key && Storage::disk('public')->exists($user_information->file_object_key)) {
                Storage::disk('public')->delete($user_information->file_object_key);
            }
            
            // ✅ Store the new image
            $file = $request->file('avatar');
            $path = $file->store('users', 'public');
            
            // Update image fields
            $validated['image'] = asset('storage/' . $path);
            $validated['file_object_key'] = $path;
        }
        $user_information->update($validated);
        return redirect()->route('user.profile');
    }

    public function messages(){
        $users_available = \App\Models\User::where('id' , '!=' , Auth::id())->get();
        $current_user = \App\Models\User::where('id',Auth::id())->select('name','id')->first();
        return view('Application.users.messages' , compact('users_available' , 'current_user') );
    }

    public function chat(int $receiver_id){
        $receiver = \App\Models\User::find($receiver_id);
        $messages = 
        Chat::where(function($query) use($receiver_id){
            $query->where('receiver_id' , $receiver_id)->where('sender_id',Auth::id());
        })->orWhere(function($query) use($receiver_id){
            $query->where('receiver_id' , Auth::id())->where('sender_id', $receiver_id);
        })->get();
     
        return view('application.users.chat',compact('messages' , 'receiver'));
    }

    public function send_message(Request $request , int $receiver_id){
        $message = Chat::create(['sender_id'=> Auth::id(), 'receiver_id'=>$receiver_id, 'message'=> $request->input('message')]);
        broadcast(new SendMessage($message))->toOthers();
        return response()->json(['stauts'=>200 , 'message'=>'message sent']);
    }

    public function typing(){
        broadcast(new Typing(Auth::id()))->toOthers();
        return response()->json(['status'=>200 , 'message'=>'User is typing']);
    }

    // using caching ; 
    // public function online(){
    //     Cache::put('user-is-online-'.Auth::id() , true , now()->addMinutes(5));
    //     return response()->json(['status'=>200 , 'message'=>'User is online']);
    // }
    // public function offline(){
    //     Cache::forget('user-is-online-'.Auth::id());
    //     return response()->json(['status'=>200 , 'message'=>'User is offline']);

    // }
    // using sockets ; 
    public function online()
    {
        Cache::put('user-is-online-'.Auth::id() , true , now()->addMinutes(5));

        broadcast(new UserChatStatus(Auth::id(), 'online'))->toOthers();

        return response()->json(['status' => 200, 'message' => 'User is online' , 'id'=>Auth::id()]);
    }

    public function offline()
    {
        Cache::forget('user-is-online-'.Auth::id());

        broadcast(new UserChatStatus(Auth::id(), 'offline'))->toOthers();

        return response()->json(['status' => 200, 'message' => 'User is offline', 'id'=>Auth::id()]);
    }

}
