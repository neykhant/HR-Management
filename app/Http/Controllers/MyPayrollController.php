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

class MyPayrollController extends Controller
{
    public function ssd(Request $request)
    {
        return view('payroll');
    }

    public function payrollTable(Request $request)
    {
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
        $employees = User::orderBy('employee_id')->where('id', auth()->user()->id )->get();
        $attendances = CheckinCheckout::whereMonth('date',$month)->whereYear('date', $year)->get();
        // return count($attendances);
        return view('components.payroll_table', compact('company_setting','periods', 'employees', 'attendances','daysInMonth', 'workingDays','offDays', 'month', 'year' ))->render();
    }
}


