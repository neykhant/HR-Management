<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Project;
use App\ProjectLeader;
use App\ProjectMember;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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

        $projects = Project::with('leaders', 'members');

        return DataTables()::of($projects)
            ->editColumn('description', function ($each) {
                return Str::limit($each->description, 100);
            })

            ->addColumn('leaders', function ($each) {
                $output = '<div style="width: 170px; " >';
                foreach ($each->leaders as $leader) {
                    $output .= '<img src="' . $leader->profile_img_path() . '" alt=""  class="profile-thumnail2" /> ';
                }
                return $output . '</div>';
            })

            ->addColumn('members', function ($each) {
                $output = '<div style="width: 150px; " >';
                foreach ($each->members as $member) {
                    $output .= '<img src="' . $member->profile_img_path() . '" alt=""  class="profile-thumnail2" /> ';
                }
                return $output . '</div>';
            })

            ->editColumn('priority', function ($each) {
                if ($each->priority == 'high') {
                    return '<span class="badge badge-pill badge-danger" >High</span>';
                } else if ($each->priority == 'middle') {
                    return '<span class="badge badge-pill badge-info" >Middle</span>';
                } else if ($each->priority == 'low') {
                    return '<span class="badge badge-pill badge-dark" >Low</span>';
                }
            })

            ->editColumn('status', function ($each) {
                if ($each->status == 'pending') {
                    return '<span class="badge badge-pill badge-warning" >Pending</span>';
                } else if ($each->status == 'in_progress') {
                    return '<span class="badge badge-pill badge-info" >Progress</span>';
                } else if ($each->status == 'complete') {
                    return '<span class="badge badge-pill badge-success" >Complete</span>';
                }
            })

            ->addColumn('action', function ($each) {

                $info_icon = '';
                $edit_icon = '';
                $delete_icon = '';

                if (auth()->user()->can('view_project')) {
                    $info_icon = '<a href="' . route('project.show', $each->id) . '" class="text-primary"><i class="fas fa-info-circle" ></i></a>';
                }

                if (auth()->user()->can('edit_project')) {
                    $edit_icon = '<a href="' . route('project.edit', $each->id) . '" class="text-warning"><i class="far fa-edit" ></i></a>';
                }

                if (auth()->user()->can('delete_project')) {
                    $delete_icon = '<a href="#" class="text-danger delete-btn" data-id="' . $each->id . '" ><i class="fas fa-trash-alt" ></i></a>';
                }

                return '<div class="action_icon" >' . $info_icon . $edit_icon . $delete_icon . '</div>';
            })
            ->addColumn('plus-icon', function ($each) {
                return null;
            })

            ->rawColumns(['priority', 'status', 'leaders', 'members', 'action'])
            ->make(true);
    }

    public function create()
    {
        if (!auth()->user()->can('create_project')) {
            abort(403, 'Unauthorized action.');
        }

        $employees = User::orderBy('name')->get();
        return view('project.create', compact('employees'));
    }

    public function store(StoreProjectRequest $request)
    {
        if (!auth()->user()->can('create_project')) {
            abort(403, 'Unauthorized action.');
        }
        // return $request->all();

        $image_names = null;
        if ($request->hasFile('images')) {
            $image_names = [];
            $images_file = $request->file('images');

            foreach ($images_file as $image_file) {
                $image_name = uniqid() . '_' . time() . '.' . $image_file->getClientOriginalExtension();

                Storage::disk('public')->put('project/' . $image_name, file_get_contents($image_file));
                array_push($image_names, $image_name);
            }
            $imageNameToStore = serialize($image_names);
        }

        $file_names = null;
        if ($request->hasFile('files')) {
            $file_names = [];
            $files = $request->file('files');

            foreach ($files as $file) {
                $file_name = uniqid() . '_' . time() . '.' . $file->getClientOriginalExtension();
                Storage::disk('public')->put('project/' . $file_name, file_get_contents($file));
                // $file_names[] = $file_name;
                array_push($file_names, $file_name);
            }
            $fileNameToStore = serialize($file_names);
        }

        // return $file_names;

        // return $request->all();

        $project = new Project();
        $project->title = $request->title;
        $project->description = $request->description;
        $project->images = $imageNameToStore;
        $project->file = $fileNameToStore;
        $project->start_date = $request->start_date;
        $project->deadline = $request->deadline;
        $project->priority = $request->priority;
        $project->status = $request->status;
        $project->save();


        $project->leaders()->sync($request->leaders);
        $project->members()->sync($request->members);



        return redirect()->route('project.index')->with('create', 'Project is successfully created.');
    }

    public function edit($id)
    {
        if (!auth()->user()->can('edit_project')) {
            abort(403, 'Unauthorized action.');
        }

        $project = Project::findOrFail($id);
        $employees = User::orderBy('name')->get();

        $images = unserialize($project->images);
        $files = unserialize($project->file);
        // return  $images;

        return view('project.edit', compact('project', 'employees', 'images', 'files'));
    }

    public function show($id)
    {
        if (!auth()->user()->can('view_project')) {
            abort(403, 'Unauthorized action.');
        }

        $project = Project::findOrFail($id);
        $images = unserialize($project->images);
        $files = unserialize($project->file);
        // return  $images;

        return view('project.show', compact('project', 'images', 'files'));
    }

    public function update($id, UpdateProjectRequest $request)
    {
        if (!auth()->user()->can('edit_project')) {
            abort(403, 'Unauthorized action.');
        }

        $project = Project::findOrFail($id);

        $imageNameToStore = $project->images;

        if ($request->hasFile('images')) {
            $image_names = [];
            $images_file = $request->file('images');

            foreach ($images_file as $image_file) {
                $image_name = uniqid() . '_' . time() . '.' . $image_file->getClientOriginalExtension();

                Storage::disk('public')->put('project/' . $image_name, file_get_contents($image_file));
                array_push($image_names, $image_name);
            }
            $imageNameToStore = serialize($image_names);
        }

        $fileNameToStore = $project->file;

        if ($request->hasFile('files')) {
            $file_names = [];
            $files = $request->file('files');

            foreach ($files as $file) {
                $file_name = uniqid() . '_' . time() . '.' . $file->getClientOriginalExtension();
                Storage::disk('public')->put('project/' . $file_name, file_get_contents($file));
                // $file_names[] = $file_name;
                array_push($file_names, $file_name);
            }
            $fileNameToStore = serialize($file_names);
        }


        $project->title = $request->title;
        $project->description = $request->description;
        $project->images = $imageNameToStore;
        $project->file = $fileNameToStore;
        $project->start_date = $request->start_date;
        $project->deadline = $request->deadline;
        $project->priority = $request->priority;
        $project->status = $request->status;
        $project->update();

        $project->leaders()->sync($request->leaders);
        $project->members()->sync($request->members);

        return redirect()->route('project.index')->with('update', 'Project is successfully updated.');
    }

    public function destroy($id)
    {
        if (!auth()->user()->can('delete_project')) {
            abort(403, 'Unauthorized action.');
        }
        $project = Project::findOrFail($id);

        $project_leaders = ProjectLeader::where('project_id', $project->id)->get();
        foreach ($project_leaders as $project_leader) {
            $project_leader->delete();
        }

        $project_members = ProjectMember::where('project_id', $project->id)->get();
        foreach ($project_members as $project_member) {
            $project_member->delete();
        }

        $project->delete();

        return 'successd';
    }
}

// Lorem ipsum dolor sit amet consectetur adipisicing elit.
//  Ratione ipsam iste accusamus cupiditate. Repellat qui dicta
//   aspernatur magnam. Accusamus quisquam consequuntur unde quis
//  dignissimos officia, placeat nulla earum quae voluptate.
