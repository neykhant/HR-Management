<?php

namespace App\Http\Controllers;

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

class MyProjectController extends Controller
{
    public function index()
    {
        return view('my_project');
    }

    public function ssd(Request $request)
    {
        $projects = Project::with('leaders', 'members')
            ->whereHas('leaders', function ($query) {
                $query->where('user_id', auth()->user()->id);
            })
            ->OrWhereHas('members', function ($query) {
                $query->where('user_id', auth()->user()->id);
            });

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

                if (auth()->user()->can('view_project')) {
                    $info_icon = '<a href="' . route('my-project.show', $each->id) . '" class="text-primary"><i class="fas fa-info-circle" ></i></a>';
                }

                return '<div class="action_icon" >' . $info_icon . '</div>';
            })
            ->addColumn('plus-icon', function ($each) {
                return null;
            })

            ->rawColumns(['priority', 'status', 'leaders', 'members', 'action'])
            ->make(true);
    }

    public function show($id)
    {
        $project = Project::with('leaders', 'members', 'tasks')
            ->where('id', $id)
            ->where(function($query){
                $query->whereHas('leaders', function ($q1) {
                    $q1->where('user_id', auth()->user()->id);
                })
                ->OrWhereHas('members', function ($q1) {
                    $q1->where('user_id', auth()->user()->id);
                });
            })
            ->firstOrFail();

        $images = unserialize($project->images);
        $files = unserialize($project->file);
        // return  $images;

        return view('my_project_show', compact('project', 'images', 'files'));
    }
}

// Lorem ipsum dolor sit amet consectetur adipisicing elit.
//  Ratione ipsam iste accusamus cupiditate. Repellat qui dicta
//   aspernatur magnam. Accusamus quisquam consequuntur unde quis
//  dignissimos officia, placeat nulla earum quae voluptate.
