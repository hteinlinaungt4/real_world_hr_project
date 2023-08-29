@extends('layouts.app')
@section('title', 'Company Setting')
@section('content')
<div class="container-fluid">
    <div class="row justify-content-center mt-5">
        <div class="col-md-8">
            <div class="card p-2 border-0 shadow">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="text-group my-2">
                                <h4>Company Name</h4>
                                <p>{{$setting->company_name}}</p>
                            </div>
                            <div class="text-group my-2">
                                <h4>Company Email</h4>
                                <p>{{$setting->company_email}}</p>
                            </div>
                            <div class="text-group my-2">
                                <h4>Company Phone</h4>
                                <p>{{$setting->company_phone}}</p>
                            </div>
                            <div class="text-group my-2">
                                <h4>Company Address</h4>
                                <p>{{$setting->company_address}}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="text-group my-2">
                                <h4>Office Start Time</h4>
                                <p>{{$setting->office_start_time}}</p>
                            </div>
                            <div class="text-group my-2">
                                <h4>Office End Time</h4>
                                <p>{{$setting->office_end_time}}</p>
                            </div>
                            <div class="text-group my-2">
                                <h4>Break Start Time</h4>
                                <p>{{$setting->break_start_time}}</p>
                            </div>
                            <div class="text-group my-2">
                                <h4>Break End Time</h4>
                                <p>{{$setting->break_end_time}}</p>
                            </div>
                        </div>
                    </div>
                    <a class="btn btn-success" href="{{route('company_setting.edit',1)}}">Edit</a>



                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script>
    @if (session('successmsg'))
Swal.fire({
    icon: 'success',
    title: 'Success...',
    text: '{{ session('successmsg') }}',
});
@endif
</script>
@endsection
