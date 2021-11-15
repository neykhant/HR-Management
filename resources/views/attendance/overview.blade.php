@extends('layouts.app')
@section('title', 'Attendance (Overview)')
@section('content')

<div class="card">
    <div class="card-body">
        <div class="row mb-3">
            <div class="col-md-4">
                <div class="form-group">
                    <select name="" class="form-control select-month">
                        <option value="">-- Please Choose (Month) --</option>
                        <option value="01">Jan</option>
                        <option value="02">Feb</option>
                        <option value="03">Mar</option>
                        <option value="04">Apr</option>
                        <option value="05">May</option>
                        <option value="06">Jun</option>
                        <option value="07">Jul</option>
                        <option value="08">Aug</option>
                        <option value="09">Set</option>
                        <option value="10">Oct</option>
                        <option value="11">Nov</option>
                        <option value="12">Dec</option>
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <select name="" class="form-control select-year">
                        <option value="">-- Please Choose (Year) --</option>
                        @for($i = 0 ; $i < 5; $i++) <option value="{{ now()->subYears($i)->format('Y') }}">{{ now()->subYears($i)->format('Y') }}</option>
                            @endfor
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <button class="btn btn-theme btn-sm btn-block"><i class="fas fa-search"></i> Search</button>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <th>Employee Name</th>
                    @foreach($periods as $period)
                    <th>{{ $period->format('d') }}</th>
                    @endforeach
                </thead>
                <tbody>
                    @foreach($employees as $employee)
                    <tr>
                        <td>{{ $employee->name }}</td>
                        @foreach($periods as $period)
                        @php

                        $office_start_time = $period->format('Y-m-d').' '. $company_setting->office_start_time;
                        $office_end_time = $period->format('Y-m-d').' '. $company_setting->office_end_time;
                        $break_start_time = $period->format('Y-m-d').' '. $company_setting->break_start_time;
                        $break_end_time = $period->format('Y-m-d').' '. $company_setting->break_end_time;

                        $checkin_icon = '';
                        $checkout_icon = '';

                        $attendance = collect($attendances)->where('user_id', $employee->id)->where('date', $period->format('Y-m-d'))->first();
                        if($attendance){
                        if($attendance->checkout_time < $break_end_time){ $checkout_icon='<i class="fas fa-times-circle text-danger"></i>' ; }else if($attendance->checkout_time > $break_start_time && $attendance->checkout_time < $office_end_time){ $checkout_icon='<i class="fas fa-check-circle text-warning"></i>' ; }else{ $checkout_icon='<i class="fas fa-check-circle text-success"></i>' ; } if($attendance->checkin_time < $office_start_time) { $checkin_icon='<i class="fas fa-check-circle text-success"></i>' ; }else if($attendance->checkin_time > $office_start_time && $attendance->checkin_time < $break_start_time){ $checkin_icon='<i class="fas fa-check-circle text-warning"></i>' ; }else{ $checkin_icon='<i class="fas fa-times-circle text-danger"></i>' ; } } @endphp <td>
                                        <div>{!!$checkin_icon!!}</div>
                                        <div>{!!$checkout_icon!!}</div>
                                        </td>
                                        @endforeach
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    $(document).ready(function() {
        $('.select-month').select2({
            placeholder: '-- Please Choose (Month)--',
            theme: 'bootstrap4',
        });

        $('.select-year').select2({
            placeholder: '-- Please Choose (Year) --',
            theme: 'bootstrap4',
        });
    })
</script>
@endsection