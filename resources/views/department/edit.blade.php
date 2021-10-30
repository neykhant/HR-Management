@extends('layouts.app')
@section('title', 'Edit Department')
@section('content')

<div class="card">
    <div class="card-body">
        <form action="{{ route('department.update', $department->id) }}" method="POST" id="edit-form">
            @csrf
            @method('PUT')

            <div class="md-form">
                <label for="">Title</label>
                <input type="text" name="title" class="form-control" autocomplete="off" value="{{ $department->title }}">
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

{!! JsValidator::formRequest('App\Http\Requests\UpdateDepartmentRequest', '#edit-form') !!}

<script>
    $(document).ready(function() {

    })
</script>
@endsection