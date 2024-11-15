<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

class LoginController extends Controller
{   
    public function showLoginForm(){
        return view('pages.auth.login');
    }

    public function login(Request $request){

        $request->validate([
            'usuario' => 'required|string',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('usuario', 'password');

        if (Auth::attempt($credentials)) {
            if(Auth::user()->estado==1){
                return redirect()->intended('dashboard');
            }else{
                Auth::logout();
            }
        }
        return back()->withErrors(['usuario' => trans('auth.failed')])
        ->withInput(request(['usuario']));
    }
    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        return redirect('/');
    }
}
