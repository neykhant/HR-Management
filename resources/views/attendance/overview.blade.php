@extends('layouts.app')
@section('title', 'Attendance (Overview)')
@section('content')

<div class="card">
    <div class="card-body">
        <div class="row mb-3">
            <div class="col-md-3">
                <input type="text" class="form-control employee_name" placeholder="Employee Name" > 
            </div>
            <div class="col-md-3">
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
            <div class="col-md-3">
                <div class="form-group">
                    <select name="" class="form-control select-year">
                        <option value="">-- Please Choose (Year) --</option>
                        @for($i = 0 ; $i < 5; $i++) 
                        <option value="{{ now()->subYears($i)->format('Y') }}">{{ now()->subYears($i)->format('Y') }}</option>
                            @endfor
                    </select>
                </div>
            </div>
            <div class="col-md-3">
                <button class="btn btn-theme btn-sm btn-block search-btn"><i class="fas fa-search"></i> Search</button>
            </div>
        </div>
       
        <div class="attendance_overview_table">

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

        // attendanceOverviewTable();
        function attendanceOverviewTable(employee_name, month, year){
            $.ajax({
                url: `/attendance-overview-table?employee_name=${employee_name}&month=${month}&year=${year}`,
                type: 'GET',
                success: function(res){
                    $('.attendance_overview_table').html(res);
                }
            })
        }

        $('.search-btn').on('click', function(e){
            e.preventDefault();

            var employee_name = $('.employee_name').val();
            var month = $('.select-month').val();
            var year = $('.select-year').val();

            attendanceOverviewTable(employee_name, month, year);

        })
    })
</script>
@endsection