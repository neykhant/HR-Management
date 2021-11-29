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

    .md-form label {
        position: relative !important;
    }

    .select2-container {
        z-index: 99999 !important;
    }

    .text-members {
        font-size: 16px;
    }

    .ghost{
        background: #eee !important;
        border: 2px dashed black !important;
        /* border-style: dashed; */
    }

    .handle{
        cursor: move;
        cursor: -webkit-grabbing;
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

    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <h5>Task</h5>
                <div class="task-data"></div>
            </div>
        </div>
    </div>
</div>


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

<!-- <h5>Task</h5>
<div class="task-data"></div> -->

@endsection

@section('script')
<!-- jsDelivr :: Sortable :: Latest (https://www.jsdelivr.com/package/npm/sortablejs) -->
<script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>

<script>
    $(document).ready(function() {

        var project_id = "{{$project->id}}";
        var leaders = @json($project -> leaders);
        var members = @json($project -> members);

        function initSortable(){
            var pendingTaskBoard = document.getElementById('pendingTaskBoard');
            var inProgressTaskBoard = document.getElementById('inProgressTaskBoard');
            var completeTaskBoard = document.getElementById('completeTaskBoard');

            var sortable = Sortable.create(pendingTaskBoard,{
                group: "taskBoard",  
                ghostClass: "ghost",
                // handle: ".handle",
                draggable: ".task-item",
                animation: 200,
                store: {
                    set: function(sortable){
                        var order = sortable.toArray();
                        localStorage.setItem('pendingTaskBoard', order.join(','));
                    }
                },
                onSort: function(evt){
                    setTimeout(function(){
                        var pendingTaskBoard =localStorage.getItem('pendingTaskBoard');
                        console.log(pendingTaskBoard);

                        $.ajax({
                            url:`/task-draggable?project_id=${project_id}&pendingTaskBoard=${pendingTaskBoard}`,
                            type:'POST',
                            success: function(res){
                                // console.log(res);
                            }
                        })
                    }, 1000);
                }
            });

            var sortable = Sortable.create(inProgressTaskBoard,{
                group: "taskBoard",  
                ghostClass: "ghost",
                // handle: ".handle",
                draggable: ".task-item",
                animation: 200,
                store: {
                    set: function(sortable){
                        var order = sortable.toArray();
                        localStorage.setItem('inProgressTaskBoard', order.join(','));
                    }
                },
                onSort: function(evt){
                    setTimeout(function(){
                        var inProgressTaskBoard =localStorage.getItem('inProgressTaskBoard');
                        console.log(inProgressTaskBoard);

                        $.ajax({
                            url:`/task-draggable?project_id=${project_id}&inProgressTaskBoard=${inProgressTaskBoard}`,
                            type:'POST',
                            success: function(res){
                                // console.log(res);
                            }
                        })
                    }, 1000);
                }
            });

            var sortable = Sortable.create(completeTaskBoard,{
                group: "taskBoard",  
                ghostClass: "ghost",
                // handle: ".handle",
                draggable: ".task-item",
                animation: 200,
                store: {
                    set: function(sortable){
                        var order = sortable.toArray();
                        localStorage.setItem('completeTaskBoard', order.join(','));
                    }
                },
                onSort: function(evt){
                    setTimeout(function(){
                        var completeTaskBoard =localStorage.getItem('completeTaskBoard');
                        console.log(completeTaskBoard);

                        $.ajax({
                            url:`/task-draggable?project_id=${project_id}&completeTaskBoard=${completeTaskBoard}`,
                            type:'POST',
                            success: function(res){
                                // console.log(res);
                            }
                        })
                    }, 1000);
                }
            });

        }

        function taskData() {
            $.ajax({
                url: `/task-data?project_id=${project_id}`,
                type: 'GET',
                success: function(res) {
                    $('.task-data').html(res);
                    initSortable();
                }
            });
        }

        taskData();

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
                            // console.log(res);
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
                            // console.log(res);
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
                            // console.log(res);
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

        $(document).on('click', '.edit_task_btn', function(event) {
            event.preventDefault();

            var task = $(this).data('task');

            var task_members = $(this).data('task-members');
            console.log(task_members);

            var task_members_options = '';
            leaders.forEach(function(leader) {
                task_members_options += `<option value="${leader.id}" ${(task_members.includes(leader.id) ? 'selected' : '' )}  >${leader.name}</option>`;
            });
            members.forEach(function(member) {
                task_members_options += `<option value="${member.id}" ${(task_members.includes(member.id) ? 'selected' : '' )}  >${member.name}</option>`;
            });

            Swal.fire({
                title: 'Add Pending Task.',
                html: `
                <form id="edit_task_form" >
                <input type="hidden" name="project_id" value="${project_id}" />

                    <div class="md-form text-left" >
                        <label>Title</label>
                        <input type="text" name="title" class="form-control" value="${task.title}"/>
                    </div>

                    <div class="md-form text-left" >
                        <label>Description</label>
                        <textarea name="description" class="form-control md-textarea" rows="3" >
                        ${task.description}
                        </textarea>
                    </div>

                    <div class="md-form text-left">
                        <label for="">Start Date</label>
                        <input type="text" name="start_date" class="form-control datepicker" value="${task.start_date}">
                    </div>

                    <div class="md-form text-left">
                        <label for="">Deadline</label>
                        <input type="text" name="deadline" class="form-control datepicker" value="${task.deadline}">
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
                            <option value="high" ${(task.priority == 'high' ? 'selected' : '') } >High</option>
                            <option value="middle" ${(task.priority == 'middle' ? 'selected' : '') }>Middle</option>
                            <option value="low" ${(task.priority == 'low' ? 'selected' : '') }>Low</option>
                        </select>
                    </div>
                </form>
                `,
                showCancelButton: false,
                confirmButtonText: 'Comfirm',
            }).then((result) => {
                if (result.isConfirmed) {
                    var form_data = $('#edit_task_form').serialize();

                    // console.log(form_data);

                    $.ajax({
                        url: `/task/${task.id}`,
                        type: 'PUT',
                        data: form_data,
                        success: function(res) {
                            taskData();
                            // console.log(res);
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

        $(document).on('click', '.delete_task_btn', function(e) {
            e.preventDefault();
            var id = $(this).data("id");

            swal({
                    text: "Are you sure want to delete ?",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        $.ajax({
                                url: `/task/${id}`,
                                method: "DELETE",
                            })
                            .done(function(msg) {
                                taskData();
                                // table.ajax.reload();
                            });
                    }
                });
        });

        
    })
</script>
@endsection