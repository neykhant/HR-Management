<?php

namespace App\Http\Controllers;

use App\Department;
use App\Http\Requests\StoreDepartmentRequest;
use App\Http\Requests\StoreEmployeeRequest;
use App\Http\Requests\UpdateDepartmentRequest;
use App\Http\Requests\UpdateEmployeeRequest;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;

class DepartmentController extends Controller
{
    public function index()
    {
        if (!auth()->user()->can('view_department')) {
            abort(403, 'Unauthorized action.');
        }

        return view('department.index');
    }

    public function ssd(Request $request)
    {
        if (!auth()->user()->can('view_department')) {
            abort(403, 'Unauthorized action.');
        }

        // $employees = User::query();
        $departments = Department::query();
        return DataTables()::of($departments)
            ->addColumn('action', function ($each) {
                $edit_icon = '';
                $delete_icon = '';

                if (auth()->user()->can('edit_department')) {
                    $edit_icon = '<a href="' . route('department.edit', $each->id) . '" class="text-warning"><i class="far fa-edit" ></i></a>';
                }
                if (auth()->user()->can('delete_department')) {
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
        if (!auth()->user()->can('create_department')) {
            abort(403, 'Unauthorized action.');
        }
        return view('department.create');
    }

    public function store(StoreDepartmentRequest $request)
    {
        if (!auth()->user()->can('create_department')) {
            abort(403, 'Unauthorized action.');
        }
        $department = new Department();
        $department->title = $request->title;
        $department->save();

        return redirect()->route('department.index')->with('create', 'Department is successfully created.');
    }

    public function edit($id)
    {
        if (!auth()->user()->can('edit_department')) {
            abort(403, 'Unauthorized action.');
        }
        $department = Department::findOrFail($id);
        return view('department.edit', compact('department'));
    }

    public function update($id, UpdateDepartmentRequest $request)
    {
        if (!auth()->user()->can('edit_department')) {
            abort(403, 'Unauthorized action.');
        }
        $department = Department::findOrFail($id);
        $department->title = $request->title;
        $department->update();

        return redirect()->route('department.index')->with('update', 'Department is successfully updated.');
    }

    // public function show($id)
    // {
    //     $department = Department::findOrFail($id);
    //     return view('department.show', compact('department'));
    // }

    public function destroy($id)
    {
        if(!auth()->user()->can('delete_department')){
            abort(403, 'Unauthorized action.');
        }
        $department = Department::findOrFail($id);
        $department->delete();

        return 'successd';
    }
}
