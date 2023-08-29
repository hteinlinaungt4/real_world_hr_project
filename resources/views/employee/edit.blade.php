@extends('layouts.app')
@section('title','Employee Edit')
@section('content')
<div class="container-fluid">
    <div class="row justify-content-center align-content-center">
        <div class="col-md-10">
           <div class="card p-3 border-0 shadow mt-5" >
            <div class="card-body">
                <form action="{{  route('employee.update',$employee->id)}}" method="Post" id="update" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row justify-content-center text-center">
                        <div class="offset-1 col-md-3  ">
                            <div class="mx-auto preview" >
                                @if ($employee->image != null)
                                <img src="{{ $employee->img_path() }}" alt="Admin"
                                style="width: 150px; height:130px; object-fit:cover">
                                @else
                                <img src="https://bootdey.com/img/Content/avatar/avatar7.png" alt="Admin"
                                style="width: 150px; height:130px;">
                                @endif
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
                                <input type="text" name="employee_id" class="form-control"  placeholder="Employee ID ..." value="{{ $employee->employee_id }}">
                            </div>
                            <div class="form-group mb-2">
                                <label for="" class="mb-2">Name</label>
                                <input type="text" name="name" class="form-control" placeholder="Enter Name ..." value="{{ $employee->name}}">
                            </div>
                            <div class="form-group mb-2">
                                <label for="" class="mb-2">Email</label>
                                <input type="email" name="email" class="form-control" placeholder="Enter Email ..." value="{{ $employee->email}}">
                            </div>
                            <div class="form-group mb-2">
                                <label for="" class="mb-2">Phone</label>
                                <input type="number" name="phone" class="form-control" placeholder="Enter Phone ..." value="{{ $employee->phone}}">
                            </div>
                            <div class="form-group mb-2">
                                <label for="" class="mb-2">NRC Number</label>
                                <input type="text" name="nrc_number" class="form-control" placeholder="Enter Nrc Number ..." value="{{ $employee->nrc_number}}">
                            </div>
                            <div class="form-group mb-2">
                                <label for="" class="mb-2">Gender</label>
                                <select name="gender" id="" class="form-control">
                                    <option value="male" @if($employee->gender == 'male' ) selected @endif>Male</option>
                                    <option value="female" @if($employee->gender == 'female' ) selected @endif>Female</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-2">
                                <label for="" class="mb-2">Birthday</label>
                                <input id="birthday" type="text" name="birthday" class="form-control" placeholder="Enter Birthday ..." value="{{ $employee->birthday }}">
                            </div>
                            <div class="form-group mb-2">
                                <label for="" class="mb-2">Address</label>
                                <textarea name="address" rows="3" class="form-control" placeholder="Enter Address ...">{{ $employee->address }}</textarea>
                            </div>
                            <div class="form-group mb-2">
                                <label for="" class="mb-2">Department</label>
                                <select name="department_id" id="" class="form-control">
                                    @foreach ($departments as $department)
                                        <option value="{{ $department->id }}" @if($employee->department_id == $department->id ) selected @endif>{{ $department->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group mb-2">
                                <label for="" class="mb-2">Date of Join</label>
                                <input id="joindate" type="text" name="date_of_join" class="form-control" placeholder="Enter Date of Join ..." value="{{ $employee->date_of_join}}">
                            </div>
                            <div class="form-group mb-2">
                                <label for="" class="mb-2">Is Present</label>
                                <select name="is_present" id="" class="form-control">
                                    <option value="1" @if($employee->is_present == '1' ) selected @endif>Present</option>
                                    <option value="0" @if($employee->is_present == '0' ) selected @endif>Absent</option>
                                </select>
                            </div>
                            <div class="form-group mb-2">
                                <label for="" class="mb-2">Role</label>
                                <select name="roles[]" id="" class="form-control select_hr" multiple>
                                    @foreach ($roles as $role)
                                        <option value="{{$role->name}}" @if(in_array($role->id,$oldrole)) selected @endif>{{ $role->name }}</option>
                                    @endforeach
                                </select>
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
{!! JsValidator::formRequest('App\Http\Requests\UpdateEmployee', '#update') !!}
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
                $('.preview').append(`<img  class="rounded-circle" width="150" height="100%" style="object-fit: cover" src="${URL.createObjectURL(event.target.files[i])}"/>`);
            }
        })
        })
    </script>
@endsection
