<div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <th>Employee Name</th>
                    <th class="text-center">Roll</th>
                    <th class="text-center">Days of Month</th>
                    <th class="text-center">Working Day</th>
                    <th class="text-center">Off Day</th>
                    <th class="text-center">Attendance Day</th>
                    <th class="text-center">Leave</th>
                    <th class="text-center">Per Day (MMK)</th>
                    <th class="text-center">Total (MMK)</th>
                </thead>

                <tbody>
                    @foreach($employees as $employee)
                    @php
                    $attendanceDays = 0;
                    $salary = collect($employee->salaries)->where('month', $month)->where('year', $year)->first();
                    $perDay = $salary ? ($salary->amount / $workingDays) : 0 ;

                    @endphp

                    @foreach($periods as $period)

                    @if($period->isWeekday())
                        @php

                        $office_start_time = $period->format('Y-m-d').' '. $company_setting->office_start_time;
                        $office_end_time = $period->format('Y-m-d').' '. $company_setting->office_end_time;
                        $break_start_time = $period->format('Y-m-d').' '. $company_setting->break_start_time;
                        $break_end_time = $period->format('Y-m-d').' '. $company_setting->break_end_time;

                        $attendance = collect($attendances)->where('user_id', $employee->id)->where('date', $period->format('Y-m-d'))->first();

                        if($attendance){
                            if($attendance->checkin_time < $office_start_time)
                             {
                                $attendanceDays += 0.5;

                            }else if($attendance->checkin_time > $office_start_time && $attendance->checkin_time < $break_start_time)

                            { 
                                $attendanceDays += 0.5;
                            }else{ 
                                $attendanceDays += 0;
                            }

                        if($attendance->checkout_time < $break_end_time){
                            $attendanceDays += 0;

                             }else if($attendance->checkout_time > $break_start_time && $attendance->checkout_time < $office_end_time)
                             { 
                                $attendanceDays += 0.5;
                            }else{
                                $attendanceDays += 0.5;
                                }

                         }
                            @endphp
                            @endif 
                        @endforeach

                        @php
                        $leaveDays = $workingDays - $attendanceDays;
                        $total = $perDay * $attendanceDays;
                        @endphp
                    <tr>
                        <td>{{ $employee->name }}</td>
                        <td class="text-center">{{ implode(',', $employee->roles->pluck('name')->toArray()) }}</td>
                        <td class="text-center">{{ $daysInMonth }}</td>
                        <td class="text-center">{{ $workingDays }}</td>
                        <td class="text-center">{{ $offDays }}</td>
                        <td class="text-center">{{ $attendanceDays }}</td>
                        <td class="text-center">{{ $leaveDays }}</td>
                        <td class="text-center">{{ number_format($perDay) }}</td>
                        <td class="text-center">{{ number_format($total) }}</td>
                        <!-- <td class="text-center" >
                            
                        </td> -->
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>