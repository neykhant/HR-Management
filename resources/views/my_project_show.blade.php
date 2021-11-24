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
                    Priority : @if( $project->priority == 'high')
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

                <h5>Description</h5>
                <p class="mb-1">{{ $project->description }}</p>
            </div>
        </div>

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

    <div class="col-md-3">
        <div class="card mb-3">
            <div class="card-body">
                <h5>Leaders</h5>
                @foreach( ($project->leaders ?? []) as $leader)
                <img src="{{$leader->profile_img_path()}}" alt="" class="profile-thumnail2" />
                @endforeach
            </div>
        </div>
        <div class="card mb-3">
            <div class="card-body">
                <h5>Members</h5>
                @foreach( ($project->members ?? []) as $member)
                <img src="{{$member->profile_img_path()}}" alt="" class="profile-thumnail2" />
                @endforeach
            </div>
        </div>
    </div>

</div>

<h5>Task</h5>
<div class="row">
    <div class="col-md-4">
        <div class="card">
            <div class="card-header bg-warning text-white"><i class="fas fa-tasks"></i> Pending</div>
            <div class="card-body alert-warning">
                <div class="task-item">
                    <div class="d-flex justify-content-between">
                        <h6>User CRUD To Write</h6>
                        <a href=""><i class="fas fa-ellipsis-v"></i></a>
                    </div>
                    <div class="d-flex justify-content-between">
                        <div>
                            <p class="mb-0"><i class="fas fa-clock"></i> Sep 22</p>
                            <span class="badge badge-pill badge-danger">High</span>
                        </div>
                        <div>
                            <img src="{{ auth()->user()->profile_img_path() }}" alt="" class="profile-thumnail2">
                        </div>
                    </div>
                </div>
                <div class="task-item">
                    <div class="d-flex justify-content-between">
                        <h6>User CRUD To Write</h6>
                        <a href=""><i class="fas fa-ellipsis-v"></i></a>
                    </div>
                    <div class="d-flex justify-content-between">
                        <div>
                            <p class="mb-0"><i class="fas fa-clock"></i> Sep 22</p>
                            <span class="badge badge-pill badge-danger">High</span>
                        </div>
                        <div>
                            <img src="{{ auth()->user()->profile_img_path() }}" alt="" class="profile-thumnail2">
                        </div>
                    </div>
                </div>
                <div class="task-item">
                    <div class="d-flex justify-content-between">
                        <h6>User CRUD To Write</h6>
                        <a href=""><i class="fas fa-ellipsis-v"></i></a>
                    </div>
                    <div class="d-flex justify-content-between">
                        <div>
                            <p class="mb-0"><i class="fas fa-clock"></i> Sep 22</p>
                            <span class="badge badge-pill badge-danger">High</span>
                        </div>
                        <div>
                            <img src="{{ auth()->user()->profile_img_path() }}" alt="" class="profile-thumnail2">
                        </div>
                    </div>
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
                    <div class="d-flex justify-content-between">
                        <div>
                            <p class="mb-0"><i class="fas fa-clock"></i> Sep 22</p>
                            <span class="badge badge-pill badge-danger">High</span>
                        </div>
                        <div>
                            <img src="{{ auth()->user()->profile_img_path() }}" alt="" class="profile-thumnail2">
                        </div>
                    </div>
                </div>
                <div class="task-item">
                    <div class="d-flex justify-content-between">
                        <h6>User CRUD To Write</h6>
                        <a href=""><i class="fas fa-ellipsis-v"></i></a>
                    </div>
                    <div class="d-flex justify-content-between">
                        <div>
                            <p class="mb-0"><i class="fas fa-clock"></i> Sep 22</p>
                            <span class="badge badge-pill badge-danger">High</span>
                        </div>
                        <div>
                            <img src="{{ auth()->user()->profile_img_path() }}" alt="" class="profile-thumnail2">
                        </div>
                    </div>
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
                    <div class="d-flex justify-content-between">
                        <div>
                            <p class="mb-0"><i class="fas fa-clock"></i> Sep 22</p>
                            <span class="badge badge-pill badge-danger">High</span>
                        </div>
                        <div>
                            <img src="{{ auth()->user()->profile_img_path() }}" alt="" class="profile-thumnail2">
                        </div>
                    </div>
                </div>
                <div class="task-item">
                    <div class="d-flex justify-content-between">
                        <h6>User CRUD To Write</h6>
                        <a href=""><i class="fas fa-ellipsis-v"></i></a>
                    </div>
                    <div class="d-flex justify-content-between">
                        <div>
                            <p class="mb-0"><i class="fas fa-clock"></i> Sep 22</p>
                            <span class="badge badge-pill badge-danger">High</span>
                        </div>
                        <div>
                            <img src="{{ auth()->user()->profile_img_path() }}" alt="" class="profile-thumnail2">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')

<script>
    $(document).ready(function() {
        new Viewer(document.getElementById('images'));
    })
</script>
@endsection