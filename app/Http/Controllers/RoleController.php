<?php

namespace App\Http\Controllers;

use Spatie\Permission\Models\Role;
use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;


class RoleController extends Controller
{
    public function index()
    {
        if(!auth()->user()->can('view_role')){
            abort(403, 'Unauthorized action.');
        }
        return view('role.index');
    }

    public function ssd(Request $request)
    {
        if(!auth()->user()->can('view_role')){
            abort(403, 'Unauthorized action.');
        }
        $roles = Role::query();
        return DataTables()::of($roles)
            ->addColumn('permissions', function($each){
                $output = '';
                foreach($each->permissions as $permission){
                    $output .='<span class="badge badge-pill badge-primary m-1">'.$permission->name.'</span>';
                }
                return $output;
            })
            ->addColumn('action', function ($each) {
                $edit_icon = '';
                $delete_icon = '';

                if (auth()->user()->can('edit_role')) {
                    $edit_icon = '<a href="' . route('role.edit', $each->id) . '" class="text-warning"><i class="far fa-edit" ></i></a>';
                }
                
                if (auth()->user()->can('delete_role')) {
                    $delete_icon = '<a href="#" class="text-danger delete-btn" data-id="' . $each->id . '" ><i class="fas fa-trash-alt" ></i></a>';
                }

                return '<div class="action_icon" >' . $edit_icon . $delete_icon . '</div>';
            })
            ->addColumn('plus-icon', function ($each) {
                return null;
            })
            ->rawColumns(['permissions','action'])
            ->make(true);
    }

    public function create()
    {
        if(!auth()->user()->can('create_role')){
            abort(403, 'Unauthorized action.');
        }
        $permissions = Permission::all();
        return view('role.create', compact('permissions'));
    }

    public function store(StoreRoleRequest $request)
    {
        if(!auth()->user()->can('create_role')){
            abort(403, 'Unauthorized action.');
        }
        // return $request->all();
        $role = new Role();
        $role->name = $request->name;
        $role->save();

        $role->givePermissionTo($request->permissions);

        return redirect()->route('role.index')->with('create', 'Role is successfully created.');
    }

    public function edit($id)
    {
        if(!auth()->user()->can('edit_role')){
            abort(403, 'Unauthorized action.');
        }
        $permissions = Permission::all();
        $role = Role::findOrFail($id);
        $old_permissions = $role->permissions->pluck('id')->toArray();
        return view('role.edit', compact('permissions','role','old_permissions' ));
    }

    public function update($id, UpdateRoleRequest $request)
    {
        if(!auth()->user()->can('edit_role')){
            abort(403, 'Unauthorized action.');
        }
        // return $request->all();
        $role = Role::findOrFail($id);
        $role->name = $request->name;
        $role->update();

        $old_permissions = $role->permissions->pluck('name')->toArray();
        $role->revokePermissionTo($old_permissions);
        $role->givePermissionTo($request->permissions);

        return redirect()->route('role.index')->with('update', 'Role is successfully updated.');
    }

    // public function show($id)
    // {
    //     $department = Department::findOrFail($id);
    //     return view('department.show', compact('department'));
    // }

    public function destroy($id)
    {
        if(!auth()->user()->can('delete_role')){
            abort(403, 'Unauthorized action.');
        }
        $role = Role::findOrFail($id);
        $role->delete();

        return 'successd';
    }
}
