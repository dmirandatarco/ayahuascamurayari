<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Models\Nosotro;
use Illuminate\Http\Request;

class NosotroController extends Controller
{
    public function index()
    {
        //
        $nosotros = Nosotro::all();
        return view('pages.nosotros.index',compact('nosotros'));
    }
    public function create()
    {
        //
    }
    public function store(Request $request)
    {
        //
    }
    public function show( Nosotro $nosotros)
    {
        return view('pages.nosotros.show',compact('nosotros'));
    }
    public function traducir( $lang, Nosotro $nosotros)
    {
        return view('pages.nosotros.show',compact('lang','nosotros'));
    }
    public function edit(Nosotro $nosotro)
    {
        return view('pages.nosotros.edit',compact('nosotro'));
    }
}
