@extends('layouts.app')
@section('title', 'Create Project')
@section('content')

<div class="card">
    <div class="card-body">
        <form action="{{ route('project.store') }}" method="POST" id="create-form">
            @csrf

            <div class="md-form">
                <label for="">Title</label>
                <input type="text" name="title" class="form-control" autocomplete="off">
            </div>

            <div class="md-form">
                <label for="">Description</label>
                <textarea name="description" id="" rows="3" class="form-control md-textarea"></textarea>
            </div>

            <div class="form-group">
                <label for="images">Images (Only PNG, JPG, JPEG)</label>
                <input type="file" name="images[]" class="form-control py-1" id="images" multiple>
                <div class="preview_img my-2"> </div>
            </div>

            <div class="form-group">
                <label for="files">File (Only PDF)</label>
                <input type="file" name="files[]" class="form-control py-1" id="files" multiple>
                
            </div>

            <div class="md-form">
                <label for="">Start Date</label>
                <input type="text" name="start_date" class="form-control datepicker">
            </div>

            <div class="md-form">
                <label for="">Deadline</label>
                <input type="text" name="deadline" class="form-control datepicker">
            </div>

            <div class="md-form">
                <label for="">Priority</label>
                <select name="priority" class="form-control select-ninja">
                    <option value="">-- Please Choose --</option>
                    <option value="high">High</option>
                    <option value="middle">Middle</option>
                    <option value="low">Low</option>
                </select>
            </div>

            <div class="md-form">
                <label for="">Status</label>
                <select name="priority" class="form-control select-ninja">
                    <option value="">-- Please Choose --</option>
                    <option value="pending">Pending</option>
                    <option value="in_progress">In Progress</option>
                    <option value="complete">Complete</option>
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

{!! JsValidator::formRequest('App\Http\Requests\StoreProjectRequest', '#create-form') !!}

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