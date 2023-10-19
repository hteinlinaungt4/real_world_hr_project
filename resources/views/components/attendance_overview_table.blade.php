<div class="table-responsive">
    <table class="table table-bordered">
        <thead>
            <th>Employee</th>
            @foreach ($periods as $period)
            <th @if($period->format('D') == "Sat" || $period->format('D') == "Sun") style="background-color: #F8D7DA;" @endif>{{ $period->format("d") }} <br> {{ $period->format("D")}}</th>
            @endforeach
        </thead>
        <tbody>
            @foreach ($employees as $employee)
            <tr>
                <td>{{ $employee->name}}</td>
                @foreach ($periods as $period)
                    @php
                        $checkin_icon='';
                        $checkout_icon='';
                        $office_start_time= $period->format('Y-m-d').' '.$companysettings->office_start_time;
                        $office_end_time= $period->format('Y-m-d').' '.$companysettings->office_end_time;
                        $break_start_time= $period->format('Y-m-d').' '.$companysettings->break_start_time;
                        $break_end_time= $period->format('Y-m-d').' '.$companysettings->break_end_time;



                        $attendance =collect($attendances)->where('user_id',$employee->id)->where('date',$period->format('Y-m-d'))->first();
                        if ($attendance) {
                            if(!null($attendance->checkin_time)){
                                if ($attendance->checkin_time < $office_start_time) {
                                $checkin_icon='<i class="fas fa-check-circle text-success"></i>';
                                }else if($attendance->checkin_time > $office_start_time && $attendance->checkin_time < $break_start_time){
                                    $checkin_icon='<i class="fas fa-check-circle text-warning"></i>';
                                }else{
                                    $checkin_icon='<i class="fas fa-times-circle text-danger"></i>';
                                }
                            }else {
                                $checkin_icon='<i class="fas fa-times-circle text-danger"></i>';
                            }
                            if(!null($attendance->checkout_time)){
                                if ($attendance->checkout_time < $break_end_time) {
                                    $checkout_icon='<i class="fas fa-times-circle text-danger"></i>';
                                }else if($attendance->checkout_time > $break_end_time && $attendance->checkout_time < $office_end_time){
                                    $checkout_icon='<i class="fas fa-check-circle text-warning"></i>';
                                }else{
                                    $checkout_icon='<i class="fas fa-check-circle text-success"></i>';
                                }
                            }else{
                                $checkout_icon='<i class="fas fa-times-circle text-danger"></i>';
                            }



                        }
                    @endphp
                     <td @if($period->format('D') == "Sat" || $period->format('D') == "Sun") style="background-color: #F8D7DA;" @endif>
                       <div> {!! $checkin_icon !!}</div>
                       <div>{!! $checkout_icon !!}</div>
                     </td>
                @endforeach

            </tr>
            @endforeach

        </tbody>
    </table>
</div>
