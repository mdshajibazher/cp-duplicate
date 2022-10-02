<?php

namespace App\Http\Controllers;

use App\PermissionModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Brian2694\Toastr\Facades\Toastr;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->middleware('permission:roles.permissions');
    }


    public function index(){
//       $roles = Role::where('name','!=','Super Admin')->get();
        if(!Auth::user()->hasRole('Super Admin')){
            abort('403','Only Super Admin Is Allowed Here');
        }
        $roles = Role::get();
        $permissions = Permission::orderBy('name','asc')->get();
        return view('admin.roles_permissions.index',compact('roles','permissions'));
    }

    public function create(){
        $permissionGroups = PermissionModel::with('Module')->get()->groupBy('Module.title');
        return view('admin.roles_permissions.form',compact('permissionGroups'));
    }

    public function store(Request $request){
        if(!Auth::user()->hasRole('Super Admin')){
            abort('403','Only Super Admin Is Allowed Here');
        }
        $this->validate($request,[
            'name' => 'required|max:25|unique:roles',
            'permissions' => 'required',
        ]);

        $role =  Role::create(['name' => $request->name]);
        $role->givePermissionTo($request->permissions);
        Toastr::success('New Role Created Succesfully');
        Toastr::success('Permission Assigned Succesfully');
        return redirect()->route('roles.edit',$role->id);
    }

    public function edit($id){
        $role =  Role::with('permissions')->findOrFail($id);
        $permissionGroups = PermissionModel::with('Module')->get()->groupBy('Module.title');
        return view('admin.roles_permissions.form',compact('role','permissionGroups'));
    }


    public function update(Request $request,$id){
        if(!Auth::user()->hasRole('Super Admin')){
            abort('403','Only Super Admin Is Allowed Here');
        }
        $this->validate($request,[
            'name' => 'required|max:25|unique:roles,name,'.$id,
        ]);

        $role =  Role::findOrFail($id);
        if($request->has('permissions')){
            $role->syncPermissions($request->permissions);
            Toastr::success('Permission Synced Succesfully');
        }
        Toastr::success('Role Updated Succesfully');
        return redirect()->back();
    }
}
