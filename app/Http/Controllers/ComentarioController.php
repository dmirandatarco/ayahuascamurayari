<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Comentario;
use Illuminate\Http\Request;

class ComentarioController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:comentario.index')->only('index');
        $this->middleware('can:comentario.destroy')->only('destroy');
    }

    public function index(Request $request){
        $comentarios = Comentario::where('estado',0)->get();
        $i = 0;
        return view('pages.comentarios.index',compact('comentarios','i'));
    }

    public function destroy(Request $request)
    {
        $comentario= Comentario::findOrFail($request->id_comentario);
        $comentario->estado= '1';
        $comentario->save();
        return redirect()->back()->with('success','Comentario Agregado Correctamente.');
        
    }
}
