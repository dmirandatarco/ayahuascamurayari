<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;



use App\Models\Certificacio;
use Illuminate\Http\Request;

class CertificacioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $certificados = Certificacio::all();
        return view('pages.certificados.index',compact('certificados'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Certificacio  $certificacio
     * @return \Illuminate\Http\Response
     */
    public function show(Certificacio $certificado)
    {
        //
        return view('pages.certificados.show',compact('certificado'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Certificacio  $certificacio
     * @return \Illuminate\Http\Response
     */
    public function edit(Certificacio $certificado)
    {
        //
        return view('pages.certificados.edit',compact('certificado'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Certificacio  $certificacio
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Certificacio $certificacio)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Certificacio  $certificacio
     * @return \Illuminate\Http\Response
     */
    public function destroy(Certificacio $certificacio)
    {
        //
    }
}
