<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Attendance</title>
    <style>
        @page {
                margin: 100px 25px;
        }

        /* Reset default styles */
        table {
        border-collapse: collapse;
        width: 100%;
        max-width: 600px;
        margin: 0 auto;
        text-align: center;
        }

        /* Table header styles */
        thead th {
        background-color: #333;
        color: #fff;
        font-weight: bold;
        padding: 10px;
        border: 1px solid #555;
        }

        /* Table row styles */
        tr:nth-child(even) {
        background-color: #f2f2f2;
        }

        /* Table cell styles */
        td {
        padding: 10px;
        border: 1px solid #ccc;
        }

        /* Add hover effect to rows */
        tr:hover {
        background-color: #ddd;
        }

        /* Add a border to the table */
        table.styled-table {
        border: 1px solid #333;
        }
            footer {
                position: fixed;
                bottom: -60px;
                left: 0px;
                right: 0px;
                height: 50px;
                font-size: 20px !important;
                background-color: #000;
                color: white;
                text-align: center;
                line-height: 35px;
            }
            header {
                position: fixed;
                top: -60px;
                left: 0px;
                right: 0px;
                height: 50px;
                font-size: 20px !important;
                color: black;
                line-height: 35px;
            }

    </style>
</head>
<body>
    <header>
        <span style="text-align: left;">Attendance Report</span>
        <span><?php echo date("Y-m-d"); ?></span>
    </header>


    <table class="styled-table" width="100%" cellspacing="0">
        <thead>
            <tr>
                <th>Employee</th>
                <th>Role</th>
                <th>Days of Month</th>
                <th>Working Day</th>
                <th>Off Day</th>
                <th>Attendance Day</th>
                <th>Leave</th>
                <th>Per Day (MMK)</th>
                <th>Net Total (MMK)</th>
            </tr>
        </thead>
        <tbody style="text-align: center;">
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
                                if(!is_null($attendance->checkin_time)){
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

                                if(!is_null($attendance->checkout_time )){
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

        </tbody>
    </table>

</body>
</html>
