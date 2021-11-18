<?php

namespace App\Http\Controllers;

use App\Department;
use App\Http\Requests\StoreDepartmentRequest;
use App\Http\Requests\StoreEmployeeRequest;
use App\Http\Requests\UpdateDepartmentRequest;
use App\Http\Requests\UpdateEmployeeRequest;
use App\Project;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;

class ProjectController extends Controller
{
    public function index()
    {
        if (!auth()->user()->can('view_project')) {
            abort(403, 'Unauthorized action.');
        }

        return view('project.index');
    }

    public function ssd(Request $request)
    {
        if (!auth()->user()->can('view_project')) {
            abort(403, 'Unauthorized action.');
        }

        $projects = Project::query();
        return DataTables()::of($projects)
            ->addColumn('action', function ($each) {
                $edit_icon = '';
                $delete_icon = '';

                if (auth()->user()->can('edit_project')) {
                    $edit_icon = '<a href="' . route('project.edit', $each->id) . '" class="text-warning"><i class="far fa-edit" ></i></a>';
                }
                if (auth()->user()->can('delete_project')) {
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
        if (!auth()->user()->can('create_project')) {
            abort(403, 'Unauthorized action.');
        }
        return view('project.create');
    }

    public function store(StoreProjectRequest $request)
    {
        if (!auth()->user()->can('create_project')) {
            abort(403, 'Unauthorized action.');
        }
        $project = new Project();
        $project->title = $request->title;
        $project->save();

        return redirect()->route('project.index')->with('create', 'Project is successfully created.');
    }

    public function edit($id)
    {
        if (!auth()->user()->can('edit_project')) {
            abort(403, 'Unauthorized action.');
        }
        $project = Project::findOrFail($id);
        return view('project.edit', compact('project'));
    }

    public function update($id, UpdateProjectRequest $request)
    {
        if (!auth()->user()->can('edit_project')) {
            abort(403, 'Unauthorized action.');
        }
        $project = Project::findOrFail($id);
        $project->title = $request->title;
        $project->update();

        return redirect()->route('project.index')->with('update', 'Project is successfully updated.');
    }

    public function destroy($id)
    {
        if(!auth()->user()->can('delete_project')){
            abort(403, 'Unauthorized action.');
        }
        $project = Project::findOrFail($id);
        $project->delete();

        return 'successd';
    }
}
