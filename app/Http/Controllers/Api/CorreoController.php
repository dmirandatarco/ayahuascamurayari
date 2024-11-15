<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\ContactMailable;
use App\Mail\DoradoMailable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class CorreoController extends Controller
{
    public function contacto(Request $request)
    {
        try{
            Mail::to($request->email)->send(new ContactMailable($request));
            return response()->json([
                'success' => true,
                'message' => 'Correo enviado correctamente.'
            ], 200);
        }catch(\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Hubo un error al enviar el correo. Por favor, inténtelo de nuevo más tarde.'
            ], 500);
        }
        
    }

    public function dorado(Request $request)
    {
        try{
            Mail::to($request->email)->send(new DoradoMailable($request));
            return response()->json([
                'success' => true,
                'message' => 'Correo enviado correctamente.'
            ], 200);
        }catch(\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Hubo un error al enviar el correo. Por favor, inténtelo de nuevo más tarde.'
            ], 500);
        }
        
    }
}
