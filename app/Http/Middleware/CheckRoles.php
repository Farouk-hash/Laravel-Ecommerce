<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use Illuminate\Http\Request;

class CheckRoles
{
    
    public function handle(Request $request, Closure $next ,...$roles)
    {
        $user = Auth::user() ;
        if(isset($user) && in_array($user->role , $roles) ){
            return $next($request);
        } 
        return abort(403,'Un Authorized');
    }
}
