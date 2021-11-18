<?php

namespace App\Http\Controllers;

use App\CheckinCheckout;
use App\CompanySetting;
use App\Http\Requests\StoreAttendanceRequest;
use App\Http\Requests\UpdateAttendanceRequest;
use App\User;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;

class PayrollController extends Controller
{
    public function payroll(Request $request){
        if (!auth()->user()->can('view_payroll')) {
            abort(403, 'Unauthorized action.');
        }

        // $company_setting = CompanySetting::findOrFail(1);
        // $periods= new CarbonPeriod('2021-9-1', '2021-9-30');
        // $employees = User::orderBy('employee_id')->get();
        // $attendances = CheckinCheckout::whereMonth('date','09')->whereYear('date', '2021')->get();
        // return count($attendances);

        // $workingDays = Carbon::parse('2021-11-03')->diffInDaysFiltered(function (Carbon $date){
        //     return $date->isWeekday();
        // }, Carbon::parse('2021-11-7'));
        // return $workingDays;
        return view('payroll');
    }

    public function payrollTable(Request $request){
        if (!auth()->user()->can('view_payroll')) {
            abort(403, 'Unauthorized action.');
        }

        $month = $request->month;
        $year = $request->year;
        $startOfMonth = $year .'-' . $month . '-01'; //  2021-02-01
        $endOfMonth = Carbon::parse($startOfMonth)->endOfMonth()->format('Y-m-d'); //  2021-02-28
        $daysInMonth = Carbon::parse($startOfMonth)->daysInMonth; 

        $workingDays = Carbon::parse($startOfMonth)->subDays(1)->diffInDaysFiltered(function (Carbon $date){
            return $date->isWeekday();
        }, Carbon::parse($endOfMonth));

        $offDays = $daysInMonth - $workingDays;

        $company_setting = CompanySetting::findOrFail(1);
        $periods= new CarbonPeriod($startOfMonth, $endOfMonth);
        $employees = User::orderBy('employee_id')->where('name', 'like', '%'. $request->employee_name .'%')->get();
        $attendances = CheckinCheckout::whereMonth('date',$month)->whereYear('date', $year)->get();
        // return count($attendances);
        return view('components.payroll_table', compact('company_setting','periods', 'employees', 'attendances','daysInMonth', 'workingDays','offDays', 'month', 'year' ))->render();
    }
}


