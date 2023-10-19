@extends('layouts.app')
@section('title','Salary Update')
@section('content')
<div class="container-fluid">
    <div class="row justify-content-center align-content-center">
        <div class="col-md-10">
           <div class="card px-3 border-0 shadow mt-5" >
            <div class="card-body">
                <form action="{{ route('salary.update',$salary->id) }}" method="post" id="create" enctype="multipart/form-data">
                    @method('PUT')
                    @csrf
                    <div class="row  justify-content-center align-content-center " style="height: 500px;">
                        <div class="col-md-6">
                            <div class="form-group mb-2">
                                <label for="" class="mb-2">Employee Name</label>
                                <select type="text" class="form-control user" name="employee">
                                    <option value=""></option>
                                    @foreach ($user as $userlist)
                                        <option value="{{$userlist->id}}" @if(old('user',$salary->user_id) == $userlist->id ) selected @endif>{{$userlist->employee_id}}  ({{ $userlist->name }})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group mb-2">
                                <label for="" class="mb-2">Months</label>
                                <select name="month" id="months" class="month w-100">
                                    <option value="">Select Months</option>
                                    <option value="01" @if($salary->month == "01") selected @endif>JAN</option>
                                    <option value="02" @if($salary->month == "02") selected @endif>FEB</option>
                                    <option value="03" @if($salary->month == "03") selected @endif>MAR</option>
                                    <option value="04" @if($salary->month == "04") selected @endif>APR</option>
                                    <option value="05" @if($salary->month == "05") selected @endif>MAY</option>
                                    <option value="06" @if($salary->month == "06") selected @endif>JUN</option>
                                    <option value="07" @if($salary->month == "07") selected @endif>JUL</option>
                                    <option value="08" @if($salary->month == "08") selected @endif>AUG</option>
                                    <option value="09" @if($salary->month == "09") selected @endif>SEP</option>
                                    <option value="10" @if($salary->month == "10") selected @endif>OCT</option>
                                    <option value="11" @if($salary->month == "11") selected @endif>NOV</option>
                                    <option value="12" @if($salary->month == "12") selected @endif>DEC</option>
                                </select>
                            </div>
                            <div class="form-group mb-2">
                                <label for="" class="mb-2">Years</label>
                                <select name="year" id="years" class="year w-100"  >
                                    <option value="">--Choose Year--</option>
                                        @for ($i=0;$i<10;$i++)
                                            <option value="{{now()->addYears(5)->subYears($i)->format("Y")}}" @if($salary->year == now()->addYears(5)->subYears($i)->format("Y") ) selected @endif>{{ now()->addYears(5)->subYears($i)->format("Y")}}</option>
                                        @endfor
                                </select>
                            </div>
                            <div class="form-group mb-2">
                                <label for="" class="mb-2">Salary</label>
                                <input type="number" value="{{ old('salary',$salary->salary)}}" name="salary" class="form-control" placeholder="Enter Salary">
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
{!! JsValidator::formRequest('App\Http\Requests\UpdateSalary', '#create') !!}
    <script>
        $(document).ready(function(){
        })
    </script>
@endsection
