@extends('layouts.app')
@section('title', 'Create Employee')
@section('content')

<div class="card">
    <div class="card-body">
        <form action="{{ route('employee.store') }}" method="POST" id="create-form">
            @csrf

            <div class="md-form">
                <label for="">Employee Id</label>
                <input type="text" name="employee_id" class="form-control" autocomplete="off">
            </div>

            <div class="md-form">
                <label for="">Name</label>
                <input type="text" name="name" class="form-control" autocomplete="off">
            </div>

            <div class="md-form">
                <label for="">Phone</label>
                <input type="number" name="phone" class="form-control" autocomplete="off">
            </div>

            <div class="md-form">
                <label for="">Email</label>
                <input type="email" name="email" class="form-control" autocomplete="off">
            </div>

            <div class="md-form">
                <label for="">NRC Number</label>
                <input type="text" name="nrc_number" class="form-control" autocomplete="off">
            </div>

            <div class="form-group">
                <label for="">Gender</label>
                <select name="gender" class="form-control">
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                </select>
            </div>

            <div class="md-form">
                <label for="">Birthday</label>
                <input type="text" name="birthday" class="form-control birthday">
            </div>

            <div class="md-form">
                <label for="">Address</label>
                <textarea class="md-textarea form-control" name="address" rows="3"></textarea>
            </div>

            <div class="form-group">
                <label for="">Department</label>
                <select name="department_id" class="form-control">
                    @foreach($departments as $department)
                    <option value="{{$department->id}}">{{$department->title}}</option>
                    @endforeach
                </select>
            </div>

            <div class="md-form">
                <label for="">Date of Join</label>
                <input type="text" name="date_of_join" class="form-control date_of_join">
            </div>

            <div class="form-group">
                <label for="">Is Present</label>
                <select name="is_present" class="form-control">
                    <option value="1">Yes</option>
                    <option value="0">No</option>
                </select>
            </div>

            <div class="md-form">
                <label for="">Password</label>
                <input type="password" name="password" class="form-control">
            </div>

            <div class="d-flex justify-content-center mt-5 mb-3">
                <div class="col-md-6">
                    <button type="submit" class="btn btn-theme btn-sm btn-block">Confirm</button>
                </div>
            </div>

        </form>
    </div>
</div>
@endsection

@section('script')

{!! JsValidator::formRequest('App\Http\Requests\StoreEmployeeRequest', '#create-form') !!}

<script>
    $(document).ready(function() {
        $('.birthday').daterangepicker({
            "singleDatePicker": true,
            "autoApply": true,
            "maxDate": moment(),
            "showDropdowns": true,
            "opens": "right",
            "drops": "up",
            "locale": {
                "format": "YYYY-MM-DD",
            }
        });

        $('.date_of_join').daterangepicker({
            "singleDatePicker": true,
            "autoApply": true,
            "showDropdowns": true,
            "opens": "right",
            "drops": "up",
            "locale": {
                "format": "YYYY-MM-DD",
            }
        });
    })
</script>
@endsection