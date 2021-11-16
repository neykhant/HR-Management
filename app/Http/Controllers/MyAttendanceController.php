<?php

namespace App\Http\Controllers;

use App\CheckinCheckout;
use App\CompanySetting;
use App\User;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class MyAttendanceController extends Controller
{
    public function ssd(Request $request)
    {
        // $employees = User::query();
        $attendances = CheckinCheckout::with('employee')->where('user_id', auth()->user()->id);

        if($request->month){
            $attendances = $attendances->whereMonth('date', $request->month);
        }
        if($request->year){
            $attendances = $attendances->whereYear('date', $request->year);
        }

        return DataTables()::of($attendances)
            ->filterColumn('employee_name', function ($query, $keyword) {
                $query->whereHas('employee', function ($q1) use ($keyword) {
                    $q1->where('name', 'like', '%' . $keyword . '%');
                });
            })
            ->editColumn('employee_name', function ($each) {
                return $each->employee ? $each->employee->name : '-';
            })

            ->addColumn('plus-icon', function ($each) {
                return null;
            })
            ->rawColumns([])
            ->make(true);
    }

    public function overviewTable(Request $request)
    {
        $month = $request->month;
        $year = $request->year;
        $startOfMonth = $year .'-' . $month . '-01'; //  2021-02-01
        $endOfMonth = Carbon::parse($startOfMonth)->endOfMonth()->format('Y-m-d'); //  2021-02-28

        $company_setting = CompanySetting::findOrFail(1);
        $periods= new CarbonPeriod($startOfMonth, $endOfMonth);
        $employees = User::orderBy('employee_id')->where('id', auth()->user()->id)->get();
        $attendances = CheckinCheckout::whereMonth('date',$month)->whereYear('date', $year)->get();
        // return count($attendances);
        return view('components.attendance_overview_table', compact('company_setting','periods', 'employees', 'attendances'))->render();
    }

}
