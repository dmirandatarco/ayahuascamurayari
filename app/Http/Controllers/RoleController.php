<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Redirect;
use DB;
use App\Http\Controllers\Controller;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:role.index')->only('index');
        $this->middleware('can:role.edit')->only('edit','update');
        $this->middleware('can:role.create')->only('create','store');
        $this->middleware('can:role.destroy')->only('destroy');
    }

    public function index()
    {
        $roles=Role::all();
        $i=0;
        return view('pages.roles.index',compact('roles','i'));
    }

    public function create()
    {
        $permissions=Permission::orderBy('categoria','asc')->get();
        return view('pages.roles.create',compact('permissions'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required|regex:/^[a-zA-Z\s]+$/u|max:75',
        ]);
        $role=new Role();
        $role->name=strtoupper($request->name);
        $role->save();
        $role->permissions()->sync($request->permissions);
        return redirect()->route('roles.index')
            ->with('success', 'Rol Agregado Correctamente.');
    }

    public function edit(Role $role)
    {
        $permissions=Permission::orderBy('categoria','asc')->get();
        $rolePermissions = $role->permissions->pluck('id')->toArray();
        return view('pages.roles.edit',compact('role','permissions','rolePermissions'));
    }

    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name'=>'required|regex:/^[a-zA-Z\s]+$/u|max:75',
        ]);
        $role->name=strtoupper($request->name);
        $role->save();
        $role->permissions()->sync($request->permissions);

        return redirect()->route('roles.index')
            ->with('success', 'Rol Actualizado Correctamente.');
    }

    public function destroy(Role $role)
    {
        $role->delete();
        return redirect()->route('roles.index')
            ->with('success', 'Rol Eliminado Correctamente Correctamente.');
    }
}
