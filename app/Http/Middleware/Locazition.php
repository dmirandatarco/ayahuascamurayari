<?php

namespace App\Http\Middleware;

use App\Models\Language;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class Locazition
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if(!session()->exists('lang')){
            $lang = substr(request()->server('HTTP_ACCEPT_LANGUAGE'),0,2);
            $langexist=Language::where('abreviatura',$lang)->first();
            if(!$langexist){
                $lang='es';
            }
            session()->put('lang',$lang);
        }
        App::setLocale(session('lang'));
        return $next($request);
    }
}
