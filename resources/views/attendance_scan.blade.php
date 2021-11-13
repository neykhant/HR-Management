@extends('layouts.app')
@section('title', 'Attendance Scan')
@section('content')
<div class="card">
    <div class="card-body text-center">
        <img src="{{ asset('image/scan.png') }}" alt="" style="width: 240px;">
        <p class="text-muted mb-1">Please Scan Attendance QR</p>
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-theme btn-sm" data-toggle="modal" data-target="#scanModal">
            Scan
        </button>

    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="scanModal" tabindex="-1" aria-labelledby="scanModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="scanModalLabel">Scan Attendance QR</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <video id="video" width="100%" height="300px"></video>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-dark btn-sm" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="{{ asset('js/qr-scanner.umd.min.js') }}"></script>
<!-- <script type="text/javascript" src="{{ asset('js/instascan.min.js') }}"></script> -->
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function() {

        var videoElem = document.getElementById('video');
        const qrScanner = new QrScanner(videoElem, function(result) {
            // console.log(result);
            if (result) {
                $('#scanModal').modal('hide');
                qrScanner.stop();

                $.ajax({
                    url: '/attendance-scan/store',
                    type: 'POST',
                    data: {
                        "hash_value": result
                    },
                    success: function(res) {
                        // console.log(res);
                        if (res.status = 'success') {

                            const Toast = Swal.mixin({
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 3000,
                                timerProgressBar: true,
                                didOpen: (toast) => {
                                    toast.addEventListener('mouseenter', Swal.stopTimer)
                                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                                }
                            })
                            Toast.fire({
                                icon: 'success',
                                title: res.message,
                            })

                            // Toast.fire({
                            //     icon: 'success',
                            //     title: 'Signed in successfully'
                            // })
                        }
                        if (res.status == "fail") {
                            
                            const Toast = Swal.mixin({
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 3000,
                                timerProgressBar: true,
                                didOpen: (toast) => {
                                    toast.addEventListener('mouseenter', Swal.stopTimer)
                                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                                }
                            })

                            // Toast.fire({
                            //     icon: 'success',
                            //     title: 'Signed in successfully'
                            // })
                            Toast.fire({
                                icon: 'error',
                                title: res.message,
                            })
                        }

                    }

                })
            }
        });

        $('#scanModal').on('show.bs.modal', function(event) {
            qrScanner.start();
        })
        $('#scanModal').on('hidden.bs.modal', function(event) {
            qrScanner.stop();
        })

    });
</script>
@endsection