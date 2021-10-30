<?php

namespace App\Http\Controllers;

use Spatie\Permission\Models\Role;
use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use Illuminate\Http\Request;


class RoleController extends Controller
{
    public function index()
    {
        return view('role.index');
    }

    public function ssd(Request $request)
    {
        $roles = Role::query();
        return DataTables()::of($roles)
            ->addColumn('action', function ($each) {
                $edit_icon = '<a href="' . route('role.edit', $each->id) . '" class="text-warning"><i class="far fa-edit" ></i></a>';
                // $info_icon = '<a href="' . route('department.show', $each->id) . '" class="text-primary"><i class="fas fa-info-circle" ></i></a>';
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
        return view('role.create');
    }

    public function store(StoreRoleRequest $request)
    {
        $role = new Role();
        $role->name = $request->name;
        $role->save();

        return redirect()->route('role.index')->with('create', 'Role is successfully created.');
    }

    public function edit($id)
    {
        $role = Role::findOrFail($id);
        return view('role.edit', compact('role'));
    }

    public function update($id, UpdateRoleRequest $request)
    {
        $role = Role::findOrFail($id);
        $role->name = $request->name;
        $role->update();

        return redirect()->route('role.index')->with('update', 'Role is successfully updated.');
    }

    // public function show($id)
    // {
    //     $department = Department::findOrFail($id);
    //     return view('department.show', compact('department'));
    // }

    public function destroy($id)
    {
        $role = Role::findOrFail($id);
        $role->delete();

        return 'successd';
    }
}
