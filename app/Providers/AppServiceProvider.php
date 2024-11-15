<?php

namespace App\Providers;

use App\Models\Categoria;
use App\Models\Language;
use App\Models\Certificacio;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Carbon\Carbon;
use DB;
use Illuminate\Support\Facades\App;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Carbon::setLocale('es');
        setlocale(LC_TIME,'es_ES');

        View::share('languages', DB::table('languages')->where('estado',1)->get());
        View::share('languages2', Language::where('abreviatura','!=','es')->where('estado',1)->get());
    }
}
