@extends('layouts.app')
@section('title', 'Edit Project')
@section('content')

<div class="card">
    <div class="card-body">
        <form action="{{ route('project.update', $project->id) }}" method="POST" id="edit-form" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="md-form">
                <label for="">Title</label>
                <input type="text" name="title" class="form-control" autocomplete="off" value="{{ $project->title}}">
            </div>

            <div class="md-form">
                <label for="">Description</label>
                <textarea name="description" id="" rows="3" class="form-control md-textarea">{{ $project->description }}</textarea>
            </div>

            <div class="form-group">
                <label for="images">Images (Only PNG, JPG, JPEG)</label>
                <input type="file" name="images[]" class="form-control py-1" id="images" multiple accept="image/.png, .jpg, .jpeg">
                <div class="preview_img my-2">  
                    @foreach($images as $image)
                    <img src="{{ asset('storage/project/' . $image ) }}" alt="">
                    @endforeach
                    
                </div>
            </div>
           
            <div class="form-group">
                <label for="files">File (Only PDF)</label>
                <input type="file" name="files[]" class="form-control py-1" id="files" multiple accept="application/pdf">
                <div class="my-2">
                    @foreach($files as $file)
                    <a href="{{ asset('storage/project/' . $file ) }}" class="pdf-thumbnail" target="_blank" >
                    <i class="fas fa-file-pdf"></i>
                    <p class="mb-0" >File {{ $loop->iteration }}</p>
                </a>
                    @endforeach
                </div>
            </div>

            <div class="md-form">
                <label for="">Start Date</label>
                <input type="text" name="start_date" class="form-control datepicker" value="{{ $project->start_date }}">
            </div>

            <div class="md-form">
                <label for="">Deadline</label>
                <input type="text" name="deadline" class="form-control datepicker" value="{{ $project->deadline }}" >
            </div>

            <div class="form-group">
                <label for="">Leader</label>
                <select name="leaders[]" id="" class="form-control select-ninja" multiple>
                    <option value="">-- Please Choose --</option>
                    @foreach($employees as $employee)
                    <option value="{{ $employee->id }}" @if(in_array($employee->id, collect($project->leaders)->pluck('id')->toArray() ) ) selected @endif >{{$employee->employee_id }} ({{$employee->name}}) </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="">Member</label>
                <select name="members[]" id="" class="form-control select-ninja" multiple>
                    <option value="">-- Please Choose --</option>
                    @foreach($employees as $employee)
                    <option value="{{ $employee->id }}"@if(in_array($employee->id, collect($project->members)->pluck('id')->toArray() ) ) selected @endif >{{$employee->employee_id }} ({{$employee->name}}) </option>
                    @endforeach
                </select>
            </div>

            <div class="md-form">
                <label for="">Priority</label>
                <select name="priority" class="form-control select-ninja">
                    <option value="">-- Please Choose --</option>
                    <option value="high" @if($project->priority == 'high') selected @endif>High</option>
                    <option value="middle" @if($project->priority == 'middle') selected @endif >Middle</option>
                    <option value="low" @if($project->priority == 'low') selected @endif >Low</option>
                </select>
            </div>

            <div class="md-form">
                <label for="">Status</label>
                <select name="status" class="form-control select-ninja">
                    <option value="">-- Please Choose --</option>
                    <option value="pending" @if($project->status == 'pending') selected @endif >Pending</option>
                    <option value="in_progress" @if($project->status == 'in_progress') selected @endif >In Progress</option>
                    <option value="complete" @if($project->status == 'complete') selected @endif>Complete</option>
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

{!! JsValidator::formRequest('App\Http\Requests\UpdateProjectRequest', '#edit-form') !!}


<script>
    $(document).ready(function() {
        $('#images').on('change', function() {
            var file_length = document.getElementById('images').files.length;

            $('.preview_img').html('');
            for (var i = 0; i < file_length; i++) {
                $('.preview_img').append(`<img src="${URL.createObjectURL(event.target.files[i])}" />`);
            }
        })

        $('.datepicker').daterangepicker({
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