<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LocalMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $local=null;
        // dd(Auth::check());
        if(Auth::check() && !Session::has('local')){
            $local=$request->user()->local;
            // dd($local);

            Session::put('local',$local);
        }
        if(Auth::check() && Session::has('local')){
            $local=$request->user()->local;
            // dd($local);

            Session::put('local',$local);
        }
        if($request->has('local')){
            $local=$request->get('local');
            Session::put('local',$local);
        }
        $local=Session::get('local');

        if($local==null){
            $local=config('app.fallback_locale');
        }
        App::setLocale($local);
        return $next($request);
    }
}
