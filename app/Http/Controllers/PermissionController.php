<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePermissionRequest;
use App\Http\Requests\UpdatePermissionRequest;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;


class PermissionController extends Controller
{
    public function index()
    {
        if(!auth()->user()->can('view_permission')){
            abort(403, 'Unauthorized action.');
        }
        return view('permission.index');
    }

    public function ssd(Request $request)
    {
        if(!auth()->user()->can('view_permission')){
            abort(403, 'Unauthorized action.');
        }
        $permissions = Permission::query();
        return DataTables()::of($permissions)
            ->addColumn('action', function ($each) {
                $edit_icon = '';
                $delete_icon = '';

                if (auth()->user()->can('edit_permission')) {
                    $edit_icon = '<a href="' . route('permission.edit', $each->id) . '" class="text-warning"><i class="far fa-edit" ></i></a>';
                }

                if (auth()->user()->can('delete_permission')) {
                    $delete_icon = '<a href="#" class="text-danger delete-btn" data-id="' . $each->id . '" ><i class="fas fa-trash-alt" ></i></a>';
                }

                return '<div class="action_icon" >' . $edit_icon . $delete_icon . '</div>';
            })
            ->addColumn('plus-icon', function ($each) {
                return null;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function create()
    {
        if(!auth()->user()->can('create_permission')){
            abort(403, 'Unauthorized action.');
        }
        return view('permission.create');
    }

    public function store(StorePermissionRequest $request)
    {
        if(!auth()->user()->can('create_permission')){
            abort(403, 'Unauthorized action.');
        }
        $permission = new Permission();
        $permission->name = $request->name;
        $permission->save();

        return redirect()->route('permission.index')->with('create', 'Permission is successfully created.');
    }

    public function edit($id)
    {
        if(!auth()->user()->can('edit_permission')){
            abort(403, 'Unauthorized action.');
        }
        $permission = Permission::findOrFail($id);
        return view('permission.edit', compact('permission'));
    }

    public function update($id, UpdatePermissionRequest $request)
    {
        if(!auth()->user()->can('edit_permission')){
            abort(403, 'Unauthorized action.');
        }
        $permission = Permission::findOrFail($id);
        $permission->name = $request->name;
        $permission->update();

        return redirect()->route('permission.index')->with('update', 'Permission is successfully updated.');
    }

    // public function show($id)
    // {
    //     $department = Department::findOrFail($id);
    //     return view('department.show', compact('department'));
    // }

    public function destroy($id)
    {
        if(!auth()->user()->can('delete_permission')){
            abort(403, 'Unauthorized action.');
        }
        $permission = Permission::findOrFail($id);
        $permission->delete();

        return 'successd';
    }
}
