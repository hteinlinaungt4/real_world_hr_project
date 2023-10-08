@extends('layouts.app')
@section('title','Attendance Update')
@section('content')
<div class="container-fluid">
    <div class="row justify-content-center align-content-center">
        <div class="col-md-10">
           <div class="card px-3 border-0 shadow mt-5" >
            <div class="card-body">
                <form action="{{ route('attendance.update',$attendance->id) }}" method="post" id="create" enctype="multipart/form-data">
                    @method('PUT')
                    @csrf
                    <div class="row  justify-content-center align-content-center " style="height: 500px;">
                        <div class="col-md-6">
                            @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <div>
                                    @foreach ($errors->all() as $error)
                                    <strong>{{ $error }}</strong>
                                    @endforeach
                                </div>

                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <div class="form-group mb-2">
                            <label for="">Employee</label>
                            <select type="text" class="form-control user p-2" name="user">
                                <option value=""></option>
                                @foreach ($user as $userlist)
                                    <option value="{{$userlist->id}}" @if($attendance->user_id == $userlist->id ) selected @endif>{{$userlist->employee_id}}  ({{ $userlist->name }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group mb-2">
                            <label for="" class="mb-2">Date</label>
                            <input type="text" name="date" value="{{ old('date',$attendance->date)}}" class="form-control joindate" placeholder="Enter Date of Join ...">
                        </div>
                        <div class="form-group mb-2">
                            <label for="" class="mb-2">Checkin Time</label>
                            <input  type="text" name="checkin_time" value="{{ old('checkin_time',Carbon\Carbon::parse($attendance->checkin_time)->format('H:i:s'))}}" class="form-control timepicker" placeholder="Enter Date of Join ...">
                        </div>
                        <div class="form-group mb-2">
                            <label for="" class="mb-2">Checkout Time</label>
                            <input  type="text" name="checkout_time" value="{{ old('checkout_time',Carbon\Carbon::parse($attendance->checkout_time)->format('H:i:s'))}}" class="form-control timepicker" placeholder="Enter Date of Join ...">
                        </div>
                        <button class="btn btn-primary text-center float-end mt-3">Update</button>

                        </div>
                    </div>
                </form>
            </div>
           </div>
        </div>
    </div>
</div>
@endsection
@section('script')
{!! JsValidator::formRequest('App\Http\Requests\UpdateAttendance', '#create') !!}
    <script>
        $(document).ready(function(){
            $('.joindate').daterangepicker({
        "singleDatePicker": true,
        "showDropdowns": true,
        "autoApply": true,
        "maxDate" : moment(),
        "locale":{
            "format":"YYYY-MM-DD",
        }
    });
    $('.timepicker').daterangepicker({
        "singleDatePicker": true,
        "timePicker": true,
        "timePicker24Hour": true,
        "timePickerSeconds": true,
        "autoApply": true,

        "locale":{
            "format":"HH:mm:ss",
        }
    }).on('show.daterangepicker',function(ev,picker){
        picker.container.find('.calendar-table').hide();
    });
    $('.user').select2( {
        placeholder: "Choice Employee",
        allowClear: true
    } );
        })
    </script>
@endsection
