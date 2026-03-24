<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next){
        if (!$request->user()->isAdmin) {
            if(Route::is("materiels.*")){
                return redirect()->back()->withErrors(['message-error' => 'Vous n\'avez pas la permission.']);
            }
            return redirect("/")->withErrors(['message-error' => 'Vous n\'avez pas la permission.']);
        }
        return $next($request);
    }
    
}