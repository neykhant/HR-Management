<?php

namespace App\Http\Controllers;

use App\CheckinCheckout;
use App\Http\Requests\StoreAttendanceRequest;
use App\Http\Requests\UpdateAttendanceRequest;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;

class AttendanceController extends Controller
{
    public function index()
    {
        if (!auth()->user()->can('view_attendance')) {
            abort(403, 'Unauthorized action.');
        }

        return view('attendance.index');
    }

    public function ssd(Request $request)
    {
        if (!auth()->user()->can('view_attendance')) {
            abort(403, 'Unauthorized action.');
        }

        // $employees = User::query();
        $attendances = CheckinCheckout::with('employee');
        return DataTables()::of($attendances)
            ->filterColumn('employee_name', function ($query, $keyword) {
                $query->whereHas('employee', function ($q1) use ($keyword) {
                    $q1->where('name', 'like', '%' . $keyword . '%');
                });
            })
            ->editColumn('employee_name', function ($each) {
                return $each->employee ? $each->employee->name : '-';
            })

            ->addColumn('action', function ($each) {
                $edit_icon = '';
                $delete_icon = '';

                if (auth()->user()->can('edit_attendance')) {
                    $edit_icon = '<a href="' . route('attendance.edit', $each->id) . '" class="text-warning"><i class="far fa-edit" ></i></a>';
                }
                if (auth()->user()->can('delete_attendance')) {
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
        if (!auth()->user()->can('create_attendance')) {
            abort(403, 'Unauthorized action.');
        }
        $employees = User::orderBy('employee_id')->get();
        return view('attendance.create', compact('employees'));
    }

    public function store(StoreAttendanceRequest $request)
    {
        if (!auth()->user()->can('create_attendance')) {
            abort(403, 'Unauthorized action.');
        }

        if (CheckinCheckout::where('user_id', $request->user_id)->where('date', $request->date)->exists()) {
            return back()->withErrors(['fail' => 'Already defined.'])->withInput();
        }

        $attendance = new CheckinCheckout();
        $attendance->user_id = $request->user_id;
        $attendance->date = $request->date;
        $attendance->checkin_time = $request->date . ' ' . $request->checkin_time;
        $attendance->checkout_time = $request->date . ' ' . $request->checkout_time;
        $attendance->save();

        return redirect()->route('attendance.index')->with('create', 'Attendance is successfully created.');
    }

    public function edit($id)
    {
        if (!auth()->user()->can('edit_attendance')) {
            abort(403, 'Unauthorized action.');
        }

        $employees = User::orderBy('employee_id')->get();
        $attendance = CheckinCheckout::findOrFail($id);
        return view('attendance.edit', compact('attendance', 'employees'));
    }

    public function update($id, UpdateAttendanceRequest $request)
    {
        if (!auth()->user()->can('edit_attendance')) {
            abort(403, 'Unauthorized action.');
        }

        $attendance = CheckinCheckout::findOrFail($id);

        if (CheckinCheckout::where('user_id', $request->user_id)->where('date', $request->date)->where('id', '!=', $attendance->id)->exists()) {
            return back()->withErrors(['fail' => 'Already defined.'])->withInput();
        }

        // $attendance = new CheckinCheckout();
        $attendance->user_id = $request->user_id;
        $attendance->date = $request->date;
        $attendance->checkin_time = $request->date . ' ' . $request->checkin_time;
        $attendance->checkout_time = $request->date . ' ' . $request->checkout_time;
        $attendance->update();

        return redirect()->route('attendance.index')->with('update', 'Attendance is successfully updated.');
    }

    public function destroy($id)
    {
        if (!auth()->user()->can('delete_attendance')) {
            abort(403, 'Unauthorized action.');
        }
        $attendance = CheckinCheckout::findOrFail($id);
        $attendance->delete();

        return 'successd';
    }
}
