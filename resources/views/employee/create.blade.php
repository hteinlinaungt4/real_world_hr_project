@extends('layouts.app')
@section('title','Employee Create')
@section('content')
<div class="container-fluid vh-100">
    <div class="row justify-content-center align-content-center mt-5">
        <div class="col-md-10">
           <div class="card px-3 border-0 shadow " >
            <div class="card-body">
                <form action="{{ route('employee.store') }}" method="post" id="create" enctype="multipart/form-data">
                    @csrf
                    <div class="row justify-content-center text-center">
                        <div class="offset-1 col-md-3  ">
                            <div class="mx-auto preview" style="width: 150px; height:130px;" >

                            </div>
                            <div class="form-group mb-2">
                                <label for="" class="mb-2">Profile Image</label>
                                <input type="file" class="form-control" id="file" name="image">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-2">
                                <label for="" class="mb-2">Employee ID</label>
                                <input type="text" name="employee_id" class="form-control"  placeholder="Employee ID ...">
                            </div>
                            <div class="form-group mb-2">
                                <label for="" class="mb-2">Name</label>
                                <input type="text" name="name" class="form-control" placeholder="Enter Name ...">
                            </div>
                            <div class="form-group mb-2">
                                <label for="" class="mb-2">Email</label>
                                <input type="email" name="email" class="form-control" placeholder="Enter Email ...">
                            </div>
                            <div class="form-group mb-2">
                                <label for="" class="mb-2">Phone</label>
                                <input type="number" name="phone" class="form-control" placeholder="Enter Phone ...">
                            </div>
                            <div class="form-group mb-2">
                                <label for="" class="mb-2">NRC Number</label>
                                <input type="text" name="nrc_number" class="form-control" placeholder="Enter Nrc Number ...">
                            </div>
                            <div class="form-group mb-2">
                                <label for="" class="mb-2">Gender</label>
                                <select name="gender" id="" class="form-control">
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                </select>
                            </div>
                            <div class="form-group mb-2">
                                <label for="" class="mb-2">Birthday</label>
                                <input id="birthday" type="text" name="birthday" class="form-control" placeholder="Enter Birthday ...">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-2">
                                <label for="" class="mb-2">Address</label>
                                <textarea name="address" rows="3" class="form-control" placeholder="Enter Address ..."></textarea>
                            </div>
                            <div class="form-group mb-2">
                                <label for="" class="mb-2">Department</label>
                                <select name="department_id" id="" class="form-control">
                                    @foreach ($departments as $department)
                                        <option value="{{ $department->id }}">{{ $department->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group mb-2">
                                <label for="" class="mb-2">Date of Join</label>
                                <input id="joindate" type="text" name="date_of_join" class="form-control" placeholder="Enter Date of Join ...">
                            </div>
                            <div class="form-group mb-2">
                                <label for="" class="mb-2">Is Present</label>
                                <select name="is_present" id="" class="form-control">
                                    <option value="1">True</option>
                                    <option value="0">False</option>
                                </select>
                            </div>
                            <div class="form-group mb-2">
                                <label for="" class="mb-2">Pin Code</label>
                                <input  type="number" name="pin_code" class="form-control" placeholder="Enter Pin Code ...">
                            </div>
                            <div class="form-group mb-2">
                                <label for="" class="mb-2">Role</label>
                                <select name="roles[]" id="" class="form-control select_hr" multiple>
                                    @foreach ($roles as $role)
                                        <option value="{{$role->name}}">{{ $role->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="" class="mb-2">Password</label>
                                <input type="password" name="password" class="form-control" placeholder="Enter Password ...">
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-primary text-center">Create</button>
                </form>
            </div>
           </div>
        </div>
    </div>
</div>

@endsection
@section('script')
{!! JsValidator::formRequest('App\Http\Requests\StoreEmployee','#create') !!}
<script>
    $(document).ready(function(){
        $('#birthday').daterangepicker({
        "singleDatePicker": true,
        "showDropdowns": true,
        "autoApply": true,
        "maxDate" : moment(),
        "locale":{
            "format":"YYYY-MM-DD",
        }
    })
    $('#joindate').daterangepicker({
        "singleDatePicker": true,
        "showDropdowns": true,
        "autoApply": true,
        "maxDate" : moment(),
        "locale":{
            "format":"YYYY-MM-DD",
        }
    })
    $('#file').on('change', function() {
        var file_length=this.files.length;
        $('.preview').html('');
        for (let i = 0; i < file_length; i++) {
            $('.preview').append(`<img class="w-100" src="${URL.createObjectURL(event.target.files[i])}"/>`);
        }
    })
    })
</script>

@endsection
