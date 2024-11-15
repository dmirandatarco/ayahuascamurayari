<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Redirect;
use DB;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Carbon\Carbon;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;


class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:user.index')->only('index');
        $this->middleware('can:user.edit')->only('edit','update');
        $this->middleware('can:user.create')->only('create','store');
        $this->middleware('can:user.destroy')->only('destroy');
        $this->middleware('can:user.show')->only('show');
    }

    public function index()
    {
        $users=User::all();
        $i=0;
        return view('pages.user.index',compact('users','i'));
    }

    public function create()
    {
        $roles=Role::all();
        return view('pages.user.create',compact('roles'));
    }

    public function store(Request $request)
    {
        $user=new User();
        $user->nombre=$request->nombre;    
        $user->apellido=$request->apellido;        
        $user->tipo_documento = $request->tipo_documento;
        $user->num_documento=$request->num_documento;
        $user->celular=$request->celular;                
        $user->email= $request->email;     
        $user->usuario=$request->usuario;
        $user->password=bcrypt($request->password);
        $user->cumpleaños=$request->cumpleaños;
        $nombrefoto=$request->nombre.' '.$request->apellido;
        if($request->hasFile('imagen'))
        {
            $nombreimg=Str::slug($nombrefoto,'-').'.'.$request->file('imagen')->getClientOriginalExtension();
            $ruta=$request->imagen->storeAs('img/usuario',$nombreimg);    
            Image::make('storage/'.$ruta)->resize(1600, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save('storage/'.$ruta,null,'jpg');
        }else{
            $nombreimg="default.png";
        }
        $user->imagen=$nombreimg;

        $user->save();

        $user->roles()->sync($request->idrol);

        return redirect()->route('user.index')
            ->with('success', 'Usuario Agregado Correctamente.');
    }    

    public function update(Request $request,User $user)
    {
        $request->validate( [
            'nombre' => 'required|max:50',
            'apellido' => 'required|max:150',
            'tipo_documento' => 'nullable|max:20',
            'num_documento' => 'nullable|max:20',
            'cumpleaños' => 'nullable|date',
            'celular' => 'nullable|max:20',
            'email' => 'nullable|email|max:50',
            'usuario' => 'required|max:50|unique:users,usuario,'.$user->id,   
            'password' => 'nullable|max:191',
            'imagen' => 'nullable',
            'idrol' => 'required|exists:roles,id'
        ]);          
        
        $user->nombre=$request->nombre;       
        $user->apellido=$request->apellido;   
        $user->tipo_documento = $request->tipo_documento;
        $user->num_documento=$request->num_documento;
        $user->celular=$request->celular;         
        $user->cumpleaños=$request->cumpleaños;          
        $user->email= $request->email;     
        $user->usuario=$request->usuario;
        if($request->password){
            $user->password=bcrypt($request->password);
        }
        $nombrefoto=$request->nombre.' '.$request->apellido;
        if($request->hasFile('imagen'))
        {
            if($user->imagen != 'default.png'){ 
                Storage::delete('img/usuario/'.$user->imagen);
            }
            $nombreimg=Str::slug($nombrefoto,'-').'.'.$request->file('imagen')->getClientOriginalExtension();
            $ruta=$request->imagen->storeAs('img/usuario',$nombreimg);    
            Image::make('storage/'.$ruta)->resize(1600, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save('storage/'.$ruta,null,'jpg');
            $user->imagen=$nombreimg;  
        }
        $user->save();
        $user->roles()->sync($request->idrol);
        return redirect()->route('user.index')->with('success','Usuario Modificado Correctamente!');       
    }

    public function destroy(Request $request)
    {
        $user= User::findOrFail($request->id_usuario_2);
        if($user->estado=="1"){
            $user->estado= '0';
            $user->save();
            return redirect()->back()->with('success','Usuario Eliminado Correctamente!');
        }else{
            $user->estado= '1';
            $user->save();
            return redirect()->back()->with('success','Usuario Eliminado Correctamente!');
            }
    }

    public function show(User $user)
    {
        return view('pages.user.show',compact('user'));
    }

    public function edit(User $user)
    {
        $roles=Role::all();
        return view('pages.user.edit',compact('user','roles'));
    }

    public function perfil(User $user)
    {
        return view('pages.user.perfil',compact('user','roles'));
    }
}
