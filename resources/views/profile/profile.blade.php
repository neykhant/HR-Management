@extends('layouts.app')
@section('title', 'Profile')
@section('content')
<div class="card mb-3">
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <div class="text-center">
                    <img src="{{ $employee->profile_img_path() }}" alt="" class="profile-img">
                    <div class="py-3 px-3">
                        <h4>{{ $employee->name }}</h4>
                        <p class="text-muted mb-2"><span class="text-muted">{{ $employee->employee_id }}</span> | <span class="text-theme">{{ $employee->phone }}</span> </p>
                        <p class="text-muted mb-2"><span class="badge badge-pill badge-light border">{{ $employee->department ? $employee->department->title : '-' }}</span></p>
                        <p class="text-muted mb-2">
                            @foreach($employee->roles as $role)
                            <span class="badge badge-pill badge-primary">{{ $role->name }}</span>
                            @endforeach
                        </p>
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
            </div>
        </div>
    </div>
</div>

<div class="card mb-3">
    <div class="card-body">
        <h5>Biometric Authentication</h5>
        <form id="biometric-register-form">
            <button type="submit" class="btn biometric-register-btn">
                <i class="fas fa-fingerprint"></i>
                <i class="fas fa-plus-circle"></i>
            </button>
        </form>
    </div>
</div>

<div class="card mb-3">
    <div class="card-body">
        <a href="#" class="logout-btn btn btn-theme btn-block"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </div>
</div>
@endsection

@section('script')
<script>
    $(document).ready(function() {

        const register = (event) => {
            event.preventDefault()
            new Larapass({
                    register: 'webauthn/register',
                    registerOptions: 'webauthn/register/options'
                }).register()
                .then(function(res) {
                    Swal.fire({
                        title: 'Successfully Create.',
                        text: "The biometric data is created successfully",
                        icon: 'success',
                        confirmButtonText: 'Continue'
                    })
                })
                .catch(function(res) {
                    console.log(res);
                });
        }

        document.getElementById('biometric-register-form').addEventListener('submit', register)

        $('.logout-btn').on('click', function(e) {
            e.preventDefault();

            swal({
                    text: "Are you sure want to Logout ?",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        $.ajax({
                            url: '/logout',
                            type: 'POST',

                        }).done(function(res) {
                            window.location.reload();
                        })
                    }
                });
        })
    })
</script>
@endsection