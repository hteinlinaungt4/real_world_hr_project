@extends('layouts.app')
@section('title','Company Edit')
@section('content')
<div class="container-fluid">
    <div class="row justify-content-center align-content-center">
        <div class="col-md-10">
           <div class="card p-3 border-0 shadow mt-5" >
            <div class="card-body">
                <form action="{{ route('company_setting.update',1) }}" method="Post" >
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-2">
                                <label for="" class="mb-2">Company Name</label>
                                <input type="text" name="company_name" class="form-control"  placeholder="Company Name ..." value="{{ $setting->company_name }}">
                            </div>
                            <div class="form-group mb-2">
                                <label for="" class="mb-2">Company Email</label>
                                <input type="email" name="company_email" class="form-control"  placeholder="Company Email ..." value="{{ $setting->company_email }}">
                            </div>
                            <div class="form-group mb-2">
                                <label for="" class="mb-2">Company Phone</label>
                                <input type="text" name="company_phone" class="form-control"  placeholder="Company Phone ..." value="{{ $setting->company_phone }}">
                            </div>
                            <div class="form-group mb-2">
                                <label for="" class="mb-2">Company Address</label>
                                <textarea name="company_address" id="" cols="5" class="form-control">{{ $setting->company_address }}</textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-2">
                                <label for="" class="mb-2">Office Start Time</label>
                                <input  type="text" name="office_start_time" class="form-control time" placeholder="Office Start Time ..." value="{{ $setting->office_start_time }}">
                            </div>
                            <div class="form-group mb-2">
                                <label for="" class="mb-2">Office End Time</label>
                                <input  type="text" name="office_end_time" class="form-control time" placeholder="Office End Time ..." value="{{ $setting->office_end_time }}">
                            </div>
                            <div class="form-group mb-2">
                                <label for="" class="mb-2">Break Start Time</label>
                                <input  type="text" name="break_start_time" class="form-control time" placeholder="Break Start Time ..." value="{{ $setting->break_start_time }}">
                            </div>
                            <div class="form-group mb-2">
                                <label for="" class="mb-2">Break End Time</label>
                                <input type="text" name="break_end_time" class="form-control time" placeholder="Break End Time ..." value="{{ $setting->break_end_time }}">
                            </div>



                        </div>
                    </div>
                    <button class="btn btn-primary text-center">Update</button>
                </form>
            </div>
           </div>
        </div>
    </div>
</div>
@endsection
@section('script')
{{-- {!! JsValidator::formRequest('App\Http\Requests\UpdateCompanySetting', '#update') !!} --}}
    <script>
        $(document).ready(function(){

        $('.time').daterangepicker({
            "singleDatePicker": true,
            "timePicker": true,
            "timePicker24Hour": true,
            "timePickerSeconds": true,
            "autoApply":true,
            "locale":{
                "format":"HH:mm:ss",
            }
        }).on('show.daterangepicker', function(ev, picker) {
            $('.calendar-table').hide();
        });

        })
    </script>
@endsection
