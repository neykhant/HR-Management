@extends('layouts.app')
@section('title', 'Project Detail')
@section('content')

@section('extra_css')
<style>
    .alert-warning {
        background-color: #fff3cd88;
    }

    .alert-info {
        background-color: #d1ecf188;
    }

    .alert-success {
        background-color: #d4edda88;
    }

    .task-item {
        background-color: #fff;
        border: 1px solid #ddd;
        border-radius: 5px;
        padding: 8px;
        margin-bottom: 5px;
    }

    .add_task_btn {
        display: block;
        text-align: center;
        padding: 10px;
        color: #000;
        background-color: #fff;
        border: 1px solid #ddd;
        border-radius: 5px;

    }

    .md-form label {
        position: relative !important;
    }

    .select2-container {
        z-index: 99999 !important;
    }

    .text-members {
        font-size: 16px;
    }
</style>
@endsection

<div class="row">

    <div class="col-md-9">
        <div class="card mb-3">
            <div class="card-body">
                <h4>{{ $project->title }}</h4>
                <p class="mb-1">
                    Start Date : <span class="text-muted">{{ $project->start_date}}</span>,
                    DeadLine : <span class="text-muted">{{ $project->deadline}}</span>
                </p>
                <p class="mb-4">
                    Priority :
                     @if( $project->priority == 'high')
                    <span class="badge badge-pill badge-danger">High</span>
                    @elseif($project->priority == 'middle')
                    <span class="badge badge-pill badge-info">Middle</span>
                    @elseif($project->priority == 'low')
                    <span class="badge badge-pill badge-dark">Low</span>
                    @endif
                    ,

                    Status : @if( $project->status == 'pending')
                    <span class="badge badge-pill badge-warning">Pending</span>
                    @elseif($project->status == 'in_progress')
                    <span class="badge badge-pill badge-info">In Progress</span>
                    @elseif($project->status == 'complete')
                    <span class="badge badge-pill badge-success">Complete</span>
                    @endif

                </p>

                <div class="mb-3">
                    <h5>Description</h5>
                    <p class="mb-1">{{ $project->description }}</p>
                </div>
                <div class="mb-3">
                    <h5>Leaders</h5>
                    @foreach( ($project->leaders ?? []) as $leader)
                    <img src="{{$leader->profile_img_path()}}" alt="" class="profile-thumnail2" />
                    @endforeach
                </div>
                <div>
                    <h5>Members</h5>
                    @foreach( ($project->members ?? []) as $member)
                    <img src="{{$member->profile_img_path()}}" alt="" class="profile-thumnail2" />
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card mb-3">
            <div class="card-body">
                <h5>Images</h5>
                <div id="images">
                    @foreach($images as $image)
                    <img src="{{ asset('storage/project/' . $image ) }}" alt="" class="image-thumbnail">
                    @endforeach
                </div>
            </div>
        </div>
        <div class="card mb-3">
            <div class="card-body">
                <h5>Files</h5>
                @foreach($files as $file)
                <a href="{{ asset('storage/project/' . $file ) }}" class="pdf-thumbnail" target="_blank">
                    <i class="fas fa-file-pdf"></i>
                    <p class="mb-0">File {{ $loop->iteration }}</p>
                </a>
                @endforeach
            </div>
        </div>
    </div>

</div>

<h5>Task</h5>

<!-- <div class="row">
    <div class="col-md-4">
        <div class="card">
            <div class="card-header bg-warning text-white"><i class="fas fa-tasks"></i> Pending</div>
            <div class="card-body alert-warning">

                @foreach( collect($project->tasks)->where('status' , 'pending') as $task )
                <div class="task-item">
                    <div class="d-flex justify-content-between">
                        <h6>{{$task->title}}</h6>
                        <a href=""><i class="fas fa-ellipsis-v"></i></a>
                    </div>
                    <div class="d-flex justify-content-between align-items-end ">
                        <div>
                            <p class="mb-0"><i class="fas fa-clock"></i> {{ Carbon\Carbon::parse($task->start_date)->format('M d') }}</p>
                            @if($task->priority == 'high')
                            <span class="badge badge-pill badge-danger">High</span>
                            @elseif($task->priority == 'middle')
                            <span class="badge badge-pill badge-danger">Middle</span>
                            @elseif($task->priority == 'low')
                            <span class="badge badge-pill badge-danger">Low</span>
                            @endif
                        </div>
                        <div>
                            @foreach($task->members as $member)
                            <img src="{{ $member->profile_img_path() }}" alt="" class="profile-thumnail3">
                            @endforeach
                        </div>
                    </div>
                </div>
                @endforeach
                <div class="text-center mt-3">
                    <a href="" class="add_pending_task_btn add_task_btn"><i class="fas fa-plus-circle"></i> Add Task</a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-header bg-info text-white"><i class="fas fa-tasks"></i> In Progress</div>
            <div class="card-body alert-info">
                <div class="task-item">
                    <div class="d-flex justify-content-between">
                        <h6>User CRUD To Write</h6>
                        <a href=""><i class="fas fa-ellipsis-v"></i></a>
                    </div>
                    <div class="d-flex justify-content-between align-items-end ">
                        <div>
                            <p class="mb-0"><i class="fas fa-clock"></i> Sep 22</p>
                            <span class="badge badge-pill badge-danger">High</span>
                        </div>
                        <div>
                            <img src="{{ auth()->user()->profile_img_path() }}" alt="" class="profile-thumnail3">
                        </div>
                    </div>
                </div>
                <div class="task-item">
                    <div class="d-flex justify-content-between">
                        <h6>User CRUD To Write</h6>
                        <a href=""><i class="fas fa-ellipsis-v"></i></a>
                    </div>
                    <div class="d-flex justify-content-between align-items-end ">
                        <div>
                            <p class="mb-0"><i class="fas fa-clock"></i> Sep 22</p>
                            <span class="badge badge-pill badge-danger">High</span>
                        </div>
                        <div>
                            <img src="{{ auth()->user()->profile_img_path() }}" alt="" class="profile-thumnail3">
                        </div>
                    </div>
                </div>
                <div class="text-center mt-3">
                    <a href="" class="add_in_progress_task_btn add_task_btn"><i class="fas fa-plus-circle"></i> Add Task</a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-header bg-success text-white"><i class="fas fa-tasks"></i> Complete</div>
            <div class="card-body alert-success">
                <div class="task-item">
                    <div class="d-flex justify-content-between">
                        <h6>User CRUD To Write</h6>
                        <a href=""><i class="fas fa-ellipsis-v"></i></a>
                    </div>
                    <div class="d-flex justify-content-between align-items-end ">
                        <div>
                            <p class="mb-0"><i class="fas fa-clock"></i> Sep 22</p>
                            <span class="badge badge-pill badge-danger">High</span>
                        </div>
                        <div>
                            <img src="{{ auth()->user()->profile_img_path() }}" alt="" class="profile-thumnail3">
                        </div>
                    </div>
                </div>
                <div class="task-item">
                    <div class="d-flex justify-content-between">
                        <h6>User CRUD To Write</h6>
                        <a href=""><i class="fas fa-ellipsis-v"></i></a>
                    </div>
                    <div class="d-flex justify-content-between align-items-end ">
                        <div>
                            <p class="mb-0"><i class="fas fa-clock"></i> Sep 22</p>
                            <span class="badge badge-pill badge-danger">High</span>
                        </div>
                        <div>
                            <img src="{{ auth()->user()->profile_img_path() }}" alt="" class="profile-thumnail3">
                        </div>
                    </div>
                </div>
                <div class="text-center mt-3">
                    <a href="" class="add_complete_task_btn add_task_btn"><i class="fas fa-plus-circle"></i> Add Task</a>
                </div>
            </div>
        </div>
    </div>
</div> -->

<div class="task-data"></div>

@endsection

@section('script')

<script>
    $(document).ready(function() {

        var project_id = "{{$project->id}}";
        var leaders = @json($project -> leaders);
        var members = @json($project -> members);

        taskData();

        function taskData() {
            $.ajax({
                url:`/task-data?project_id=${project_id}`,
                type:'GET',
                success:function(res){
                    $('.task-data').html(res);
                }
            });
        }
        new Viewer(document.getElementById('images'));

        $(document).on('click', '.add_pending_task_btn', function(event) {
            event.preventDefault();

            var task_members_options = '';
            leaders.forEach(function(leader) {
                task_members_options += `<option value="${leader.id}" >${leader.name}</option>`;
            });
            members.forEach(function(member) {
                task_members_options += `<option value="${member.id}" >${member.name}</option>`;
            });

            Swal.fire({
                title: 'Add Pending Task.',
                html: `
                <form id="pending_task_form" >
                <input type="hidden" name="project_id" value="${project_id}" />
                <input type="hidden" name="status" value="pending" />

                    <div class="md-form text-left" >
                        <label>Title</label>
                        <input type="text" name="title" class="form-control" />
                    </div>

                    <div class="md-form text-left" >
                        <label>Description</label>
                        <textarea name="description" class="form-control md-textarea" rows="3" ></textarea>
                    </div>

                    <div class="md-form text-left">
                        <label for="">Start Date</label>
                        <input type="text" name="start_date" class="form-control datepicker">
                    </div>

                    <div class="md-form text-left">
                        <label for="">Deadline</label>
                        <input type="text" name="deadline" class="form-control datepicker">
                    </div>

                    <div class="form-group text-left">
                    <label for="" class="text-members" >Member</label>
                    <select name="members[]" id="" class="form-control select-ninja" multiple>
                        <option value="">-- Please Choose --</option>
                        ${task_members_options}
                    </select>
                    </div>
                    <div class="md-form text-left">
                        <label for="">Priority</label>
                        <select name="priority" class="form-control select-ninja">
                            <option value="">-- Please Choose --</option>
                            <option value="high">High</option>
                            <option value="middle">Middle</option>
                            <option value="low">Low</option>
                        </select>
                    </div>
                </form>
                `,
                showCancelButton: false,
                confirmButtonText: 'Comfirm',
            }).then((result) => {
                if (result.isConfirmed) {
                    var form_data = $('#pending_task_form').serialize();
                    
                    // console.log(form_data);

                    $.ajax({
                        url: '/task',
                        type: 'POST',
                        data: form_data,
                        success: function(res) {
                            taskData();
                            console.log(res);
                        }
                    });
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

            $('.select-ninja').select2({
                placeholder: '-- Please Choose --',
                theme: 'bootstrap4',
            });
        });

        $(document).on('click', '.add_in_progress_task_btn', function(event) {
            event.preventDefault();

            var task_members_options = '';
            leaders.forEach(function(leader) {
                task_members_options += `<option value="${leader.id}" >${leader.name}</option>`;
            });
            members.forEach(function(member) {
                task_members_options += `<option value="${member.id}" >${member.name}</option>`;
            });

            Swal.fire({
                title: 'Add In Progress Task.',
                html: `
                <form id="in_progress_task_form" >
                <input type="hidden" name="project_id" value="${project_id}" />
                <input type="hidden" name="status" value="in_progress" />

                    <div class="md-form text-left" >
                        <label>Title</label>
                        <input type="text" name="title" class="form-control" />
                    </div>

                    <div class="md-form text-left" >
                        <label>Description</label>
                        <textarea name="description" class="form-control md-textarea" rows="3" ></textarea>
                    </div>

                    <div class="md-form text-left">
                        <label for="">Start Date</label>
                        <input type="text" name="start_date" class="form-control datepicker">
                    </div>

                    <div class="md-form text-left">
                        <label for="">Deadline</label>
                        <input type="text" name="deadline" class="form-control datepicker">
                    </div>

                    <div class="form-group text-left">
                    <label for="" class="text-members" >Member</label>
                    <select name="members[]" id="" class="form-control select-ninja" multiple>
                        <option value="">-- Please Choose --</option>
                        ${task_members_options}
                    </select>
                    </div>
                    <div class="md-form text-left">
                        <label for="">Priority</label>
                        <select name="priority" class="form-control select-ninja">
                            <option value="">-- Please Choose --</option>
                            <option value="high">High</option>
                            <option value="middle">Middle</option>
                            <option value="low">Low</option>
                        </select>
                    </div>
                </form>
                `,
                showCancelButton: false,
                confirmButtonText: 'Comfirm',
            }).then((result) => {
                if (result.isConfirmed) {
                    var form_data = $('#in_progress_task_form').serialize();
                    
                    // console.log(form_data);

                    $.ajax({
                        url: '/task',
                        type: 'POST',
                        data: form_data,
                        success: function(res) {
                            taskData();
                            console.log(res);
                        }
                    });
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

            $('.select-ninja').select2({
                placeholder: '-- Please Choose --',
                theme: 'bootstrap4',
            });
        });

        $(document).on('click', '.add_complete_task_btn', function(event) {
            event.preventDefault();

            var task_members_options = '';
            leaders.forEach(function(leader) {
                task_members_options += `<option value="${leader.id}" >${leader.name}</option>`;
            });
            members.forEach(function(member) {
                task_members_options += `<option value="${member.id}" >${member.name}</option>`;
            });

            Swal.fire({
                title: 'Add Complete Task.',
                html: `
                <form id="complete_task_form" >
                <input type="hidden" name="project_id" value="${project_id}" />
                <input type="hidden" name="status" value="complete" />

                    <div class="md-form text-left" >
                        <label>Title</label>
                        <input type="text" name="title" class="form-control" />
                    </div>

                    <div class="md-form text-left" >
                        <label>Description</label>
                        <textarea name="description" class="form-control md-textarea" rows="3" ></textarea>
                    </div>

                    <div class="md-form text-left">
                        <label for="">Start Date</label>
                        <input type="text" name="start_date" class="form-control datepicker">
                    </div>

                    <div class="md-form text-left">
                        <label for="">Deadline</label>
                        <input type="text" name="deadline" class="form-control datepicker">
                    </div>

                    <div class="form-group text-left">
                    <label for="" class="text-members" >Member</label>
                    <select name="members[]" id="" class="form-control select-ninja" multiple>
                        <option value="">-- Please Choose --</option>
                        ${task_members_options}
                    </select>
                    </div>
                    <div class="md-form text-left">
                        <label for="">Priority</label>
                        <select name="priority" class="form-control select-ninja">
                            <option value="">-- Please Choose --</option>
                            <option value="high">High</option>
                            <option value="middle">Middle</option>
                            <option value="low">Low</option>
                        </select>
                    </div>
                </form>
                `,
                showCancelButton: false,
                confirmButtonText: 'Comfirm',
            }).then((result) => {
                if (result.isConfirmed) {
                    var form_data = $('#complete_task_form').serialize();
                    
                    // console.log(form_data);

                    $.ajax({
                        url: '/task',
                        type: 'POST',
                        data: form_data,
                        success: function(res) {
                            taskData();
                            console.log(res);
                        }
                    });
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

            $('.select-ninja').select2({
                placeholder: '-- Please Choose --',
                theme: 'bootstrap4',
            });
        });
    })
</script>
@endsection