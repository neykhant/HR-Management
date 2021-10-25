@extends('layouts.app')
@section('title', 'Edit Employee')
@section('content')
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <div class="d-flex justify-content-start">
                    <img src="{{ $employee->profile_img_path() }}" alt="" class="profile-img">
                    <div class="py-3 px-2">
                        <h3>{{ $employee->name }}</h3>
                        <p class="text-muted mb-1">{{ $employee->employee_id }}</p>
                        <p class="text-muted mb-1">{{ $employee->department ? $employee->department->title : '-' }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 border-dash">
                <p class="mb-1"><strong>Phone</strong> : <span class="text-muted">{{ $employee->phone }}</span></p>
                <p class="mb-1"><strong>Email</strong> : <span class="text-muted">{{ $employee->email }}</span></p>
                <p class="mb-1"><strong>NRC Number</strong> : <span class="text-muted">{{ $employee->nrc_number }}</span></p>
                <p class="mb-1"><strong>Gender</strong> : <span class="text-muted">{{ ucfirst($employee->gender) }}</span></p>
                <p class="mb-1"><strong>Birthday</strong> : <span class="text-muted">{{ $employee->birthday }}</span></p>
                <p class="mb-1"><strong>Address</strong> : <span class="text-muted">{{ $employee->address }}</span></p>
                <p class="mb-1"><strong>Date of Join</strong> : <span class="text-muted">{{ $employee->date_of_join }}</span></p>
                <p class="mb-1"><strong>Is Present</strong> :
                    @if($employee->is_present == 1)
                    <span class="badge badge-pill badge-success">Present</span>
                    @else
                    <span class="badge badge-pill badge-danger">Leave</span>
                    @endif
                </p>
                <!-- <p class="mb-1"><strong>Birthday</strong> : <span class="text-muted">{{ $employee->birthday }}</span></p> -->

            </div>

            <!-- <div class="col-md-6">
                <div class="mb-3">
                    <p class="mb-0"><i class="fab fa-gg"></i> Employee Id</p>
                    <p class="text-muted mb-0">{{$employee->employee_id}}</p>
                </div>
            </div>

            <div class="col-md-6">
                <div class="mb-3">
                    <p class="mb-0"><i class="fab fa-gg"></i> Name</p>
                    <p class="text-muted mb-0">{{$employee->name}}</p>
                </div>
            </div>

            <div class="col-md-6">
                <div class="mb-3">
                    <p class="mb-0"><i class="fab fa-gg"></i> Phone</p>
                    <p class="text-muted mb-0">{{$employee->phone}}</p>
                </div>
            </div>

            <div class="col-md-6">
                <div class="mb-3">
                    <p class="mb-0"><i class="fab fa-gg"></i> Email</p>
                    <p class="text-muted mb-0">{{$employee->email}}</p>
                </div>
            </div>

            <div class="col-md-6">
                <div class="mb-3">
                    <p class="mb-0"><i class="fab fa-gg"></i> NRC Numbeer</p>
                    <p class="text-muted mb-0">{{$employee->nrc_number}}</p>
                </div>
            </div>

            <div class="col-md-6">
                <div class="mb-3">
                    <p class="mb-0"><i class="fab fa-gg"></i>Gender</p>
                    <p class="text-muted mb-0">{{ ucfirst($employee->gender) }}</p>
                </div>
            </div>

            <div class="col-md-6">
                <div class="mb-3">
                    <p class="mb-0"><i class="fab fa-gg"></i> Birthday</p>
                    <p class="text-muted mb-0">{{$employee->birthday}}</p>
                </div>
            </div>

            <div class="col-md-6">
                <div class="mb-3">
                    <p class="mb-0"><i class="fab fa-gg"></i>Address</p>
                    <p class="text-muted mb-0">{{$employee->address}}</p>
                </div>
            </div>

            <div class="col-md-6">
                <div class="mb-3">
                    <p class="mb-0"><i class="fab fa-gg"></i> Department Id</p>
                    <p class="text-muted mb-0">{{$employee->department ? $employee->department->title : '-'}}</p>
                </div>
            </div>

            <div class="col-md-6">
                <div class="mb-3">
                    <p class="mb-0"><i class="fab fa-gg"></i>Date of Join</p>
                    <p class="text-muted mb-0">{{$employee->date_of_join }}</p>
                </div>
            </div>

            <div class="col-md-6">
                <div class="mb-3">
                    <p class="mb-0"><i class="fab fa-gg"></i>Is Present</p>
                    <p class="text-muted mb-0">
                        @if($employee->is_present == 1)
                        <span class="badge badge-pill badge-success">Present</span>
                        @else
                        <span class="badge badge-pill badge-danger">Leave</span>
                        @endif
                    </p>
                </div>
            </div> -->
        </div>
    </div>
</div>
@endsection