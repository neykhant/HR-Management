@extends('layouts.app')
@section('title', 'Edit Employee')
@section('content')

<div class="card">
    <div class="card-body">
        <form action="{{ route('employee.update', $employee->id) }}" method="POST" id="edit-form" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="md-form">
                <label for="">Employee Id</label>
                <input type="text" name="employee_id" class="form-control" autocomplete="off" value="{{ $employee->employee_id }}">
            </div>

            <div class="md-form">
                <label for="">Name</label>
                <input type="text" name="name" class="form-control" autocomplete="off" value="{{ $employee->name }}">
            </div>

            <div class="md-form">
                <label for="">Phone</label>
                <input type="number" name="phone" class="form-control" autocomplete="off" value="{{ $employee->phone }}">
            </div>

            <div class="md-form">
                <label for="">Email</label>
                <input type="email" name="email" class="form-control" autocomplete="off" value="{{ $employee->email }}">
            </div>

            <div class="md-form">
                <label for="">NRC Number</label>
                <input type="text" name="nrc_number" class="form-control" autocomplete="off" value="{{ $employee->nrc_number }}">
            </div>

            <div class="form-group">
                <label for="">Gender</label>
                <select name="gender" class="form-control">
                    <option value="male" @if($employee->gender == 'male') selected @endif >Male</option>
                    <option value="female" @if($employee->gender == 'female') selected @endif >Female</option>
                </select>
            </div>

            <div class="md-form">
                <label for="">Birthday</label>
                <input type="text" name="birthday" class="form-control birthday" value="{{ $employee->birthday }}">
            </div>

            <div class="md-form">
                <label for="">Address</label>
                <textarea class="md-textarea form-control" name="address" rows="3">{{$employee->address}}</textarea>
            </div>

            <div class="form-group">
                <label for="">Department</label>
                <select name="department_id" class="form-control">
                    @foreach($departments as $department)
                    <option value="{{$department->id}}" @if($employee->department_id == $department->id ) selected @endif>{{$department->title}}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="">Role (or) Designation </label>
                <select name="roles[]" class="form-control select-ninja" multiple>
                    @foreach($roles as $role)
                    <option value="{{$role->name}}" @if(in_array($role->id, $old_roles)) selected @endif>{{$role->name}}</option>
                    @endforeach
                </select>
            </div>

            <div class="md-form">
                <label for="">Date of Join</label>
                <input type="text" name="date_of_join" class="form-control date_of_join" value="{{ $employee->date_of_join }}">
            </div>

            <div class="form-group">
                <label for="">Is Present</label>
                <select name="is_present" class="form-control">
                    <option value="1" @if($employee->is_present == 1) selected @endif>Yes</option>
                    <option value="0" @if($employee->is_present == 0) selected @endif>No</option>
                </select>
            </div>

            <div class="form-group">
                <label for="profile_img">Image</label>
                <input type="file" name="profile_img" class="form-control py-1" id="profile_img">

                <!-- <div class="preview_img my-2">
                    @if($employee->profile_img)
                    <img src="{{ $employee->profile_img_path() }}" alt="">
                    @endif
                </div> -->

                <div class="preview_img my-2">
                    @if($employee->profile_img)
                    <img src="{{$employee->profile_img_path()}}" alt="">
                    @endif
                </div>
            </div>

            <div class="md-form">
                <label for="">Pin Code</label>
                <input type="number" name="pin_code" class="form-control" value="{{ $employee->pin_code }}">
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

{!! JsValidator::formRequest('App\Http\Requests\UpdateEmployeeRequest', '#edit-form') !!}

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

        $('#profile_img').on('change', function() {
            var file_length = document.getElementById('profile_img').files.length;
            $('.preview_img').html('');
            for (var i = 0; i < file_length; i++) {
                $('.preview_img').append(`<img src="${URL.createObjectURL(event.target.files[i])}" />`);
            }
        })

    })
</script>
@endsection