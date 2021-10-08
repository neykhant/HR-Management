<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class EmployeeController extends Controller
{
    public function index(){
        return view('employee.index');
    }

    public function ssd(Request $request){
        $employees = User::query();
        return DataTables()::of($employees)
        ->make(true);

    }
}
