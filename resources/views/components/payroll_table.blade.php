<div class="table-responsive">
    <table class="table table-bordered">
        <thead class="text-center">
            <th>Employee</th>
            <th>Role</th>
            <th>Days of Month</th>
            <th>Working Day</th>
            <th>Off Day</th>
            <th>Attendance Day</th>
            <th>Leave</th>
            <th>Per Day (MMK)</th>
            <th>Net Total (MMK)</th>
        </thead>
        <tbody>
            @foreach ($employees as $employee)
                @php
                    $attendanceDay=0;
                    $leavedays=$workingdays-$attendanceDay;
                    $salary_amount=collect($employee->salaries)->where('year',$year)->where('month',$month)->first();
                    $perday=$salary_amount ? $salary_amount->salary / $workingdays : '0';
                @endphp
                @foreach ($periods as $period)
                    @php
                        $office_start_time= $period->format('Y-m-d').' '.$companysettings->office_start_time;
                        $office_end_time= $period->format('Y-m-d').' '.$companysettings->office_end_time;
                        $break_start_time= $period->format('Y-m-d').' '.$companysettings->break_start_time;
                        $break_end_time= $period->format('Y-m-d').' '.$companysettings->break_end_time;
                        $attendance =collect($attendances)->where('user_id',$employee->id)->where('date',$period->format('Y-m-d'))->first();
                        if ($attendance) {
                            if(!null($attendance->checkin_time)){
                                if ($attendance->checkin_time < $office_start_time) {
                                $attendanceDay +=0.5;
                                }else if($attendance->checkin_time > $office_start_time && $attendance->checkin_time < $break_start_time){
                                    $attendanceDay +=0.5;
                                }else{
                                    $attendanceDay +=0;
                                }
                            }else{
                                $attendanceDay +=0;
                            }

                            if(!null($attendance->checkout_time )){
                                if ($attendance->checkout_time < $break_end_time) {
                                $attendanceDay +=0;
                                }else if($attendance->checkout_time > $break_end_time && $attendance->checkout_time < $office_end_time){
                                    $attendanceDay +=0.5;
                                }else{
                                    $attendanceDay +=0.5;
                                }
                            }else{
                                $attendanceDay +=0.5;
                            }

                        }
                    @endphp
                @endforeach
            @php
                $leavedays=$workingdays-$attendanceDay;
                $total=$perday * $attendanceDay;
            @endphp
            <tr class="text-center">
                <td>{{ $employee->name}}</td>
                <td>{{ implode(',',$employee->roles->pluck('name')->toArray()) }}</td>
                <td>{{ $dayofMonth}}</td>
                <td>{{ $workingdays}}</td>
                <td>{{ $offdays }}</td>
                <td>{{ $attendanceDay }}</td>
                <td>{{ $leavedays }}</td>
                <td>{{ round($perday) }}</td>
                <td>{{  number_format(round($total)) }}</td>


            </tr>
            @endforeach

        </tbody>
    </table>
</div>
