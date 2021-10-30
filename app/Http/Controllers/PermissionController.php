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
        return view('permission.index');
    }

    public function ssd(Request $request)
    {
        $permissions = Permission::query();
        return DataTables()::of($permissions)
            ->addColumn('action', function ($each) {
                $edit_icon = '<a href="' . route('permission.edit', $each->id) . '" class="text-warning"><i class="far fa-edit" ></i></a>';
                $delete_icon = '<a href="#" class="text-danger delete-btn" data-id="' . $each->id . '" ><i class="fas fa-trash-alt" ></i></a>';

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
        return view('permission.create');
    }

    public function store(StorePermissionRequest $request)
    {
        $permission = new Permission();
        $permission->name = $request->name;
        $permission->save();

        return redirect()->route('permission.index')->with('create', 'Permission is successfully created.');
    }

    public function edit($id)
    {
        $permission = Permission::findOrFail($id);
        return view('permission.edit', compact('permission'));
    }

    public function update($id, UpdatePermissionRequest $request)
    {
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
        $permission = Permission::findOrFail($id);
        $permission->delete();

        return 'successd';
    }
}
