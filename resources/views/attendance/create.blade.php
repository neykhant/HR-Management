@extends('layouts.app')
@section('title', 'Create Attendance')
@section('content')

<div class="card">
    <div class="card-body">
        <form action="{{ route('attendance.store') }}" method="POST" id="create-form">
            @csrf

            <div class="form-group">
                <label for="">Employee</label>
                <select name="user_id" class="form-control select-ninja">
                    <option value="">-- Please Choose --</option>
                    @foreach( $employees as $employee)
                        <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                    @endforeach
                </select>
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

{!! JsValidator::formRequest('App\Http\Requests\StoreDepartmentRequest', '#create-form') !!}

<script>
    $(document).ready(function() {
    })
</script>
@endsection