@extends('layouts.app_plain')
@section('title', 'Check In - Check Out')
@section('content')
<div class="d-flex justify-content-center align-items-center" style="height: 100vh;">
    <div class="col-md-6">
        <div class="card">
            <div class="card-body text-center">
                <dvi class="my-5">
                    <h5 class="text-center">QR Code</h5>
                    <img src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(200)->generate('Make me into an QrCode!')) !!} ">
                    <p class="text-muted">Please Scan QR to check in or check out.</p>
                </dvi>
                <hr>
                <div class="my-5">
                    <h5 class="text-center">Pin Code</h5>
                    <div class="mb-3">
                        <input type="text" name="mycode" id="pincode-input1">
                    </div>
                    <p class="text-muted">Please enter your pin code to check in or check out.</p>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@section('script')
<script>
    $(document).ready(function() {
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
        // $('#pincode-input1').pincodeInput({
        //     inputs: 6
        // });

        $('#pincode-input1').pincodeInput({
            inputs: 6,
            complete: function(value, e, errorElement) {
                console.log("code entered: " + value);

                /*do some code checking here*/
                $.ajax({
                    url: '/checkin-checkout/store',
                    type: 'POST',
                    data: {
                        "pin_code": value
                    },
                    success: function(res) {
                        if (res.status = 'success') {
                            Toast.fire({
                                icon: 'success',
                                title: res.message,
                            })
                        }
                        if (res.status == "fail") {
                            Toast.fire({
                                icon: 'error',
                                title: res.message,
                            })
                        }
                    $('.pincode-input-container .pincode-input-text').val("");
                    $('.pincode-input-text').first().select().focus();
                    }

                })
                //   $(errorElement).html("I'm sorry, but the code not correct");
            }
        });

        $('.pincode-input-text').first().select().focus();

    })
</script>
@endsection