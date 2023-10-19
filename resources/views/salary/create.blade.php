@extends('layouts.app')
@section('title','Salary Create')
@section('content')
<div class="container-fluid">
    <div class="row justify-content-center align-content-center">
        <div class="col-md-10">
           <div class="card px-3 border-0 shadow mt-5" >
            <div class="card-body">
                <form action="{{ route('salary.store') }}" method="post" id="create" enctype="multipart/form-data">
                    @csrf
                    <div class="row  justify-content-center align-content-center " style="height: 500px;">
                        <div class="col-md-6">
                            <div class="form-group mb-2">
                                <label for="" class="mb-2">Employee Name</label>
                                <select type="text" class="form-control user" name="employee">
                                    <option value=""></option>
                                    @foreach ($user as $userlist)
                                        <option value="{{$userlist->id}}" @if(old('user') == $userlist->id ) selected @endif>{{$userlist->employee_id}}  ({{ $userlist->name }})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group mb-2">
                                <label for="" class="mb-2">Months</label>
                                <select name="month" id="months" class="month w-100">
                                    <option value="">Select Months</option>
                                    <option value="01">JAN</option>
                                    <option value="02">FEB</option>
                                    <option value="03">MAR</option>
                                    <option value="04">APR</option>
                                    <option value="05">MAY</option>
                                    <option value="06">JUN</option>
                                    <option value="07">JUL</option>
                                    <option value="08">AUG</option>
                                    <option value="09">SEP</option>
                                    <option value="10">OCT</option>
                                    <option value="11">NOV</option>
                                    <option value="12">DEC</option>
                                </select>
                            </div>
                            <div class="form-group mb-2">
                                <label for="" class="mb-2">Years</label>
                                <select name="year" id="years" class="year w-100"  >
                                    <option value="">--Choose Year--</option>
                                        @for ($i=0;$i<10;$i++)
                                            <option value="{{now()->addYears(5)->subYears($i)->format("Y")}}">{{ now()->addYears(5)->subYears($i)->format("Y")}}</option>
                                        @endfor
                                </select>
                            </div>
                            <div class="form-group mb-2">
                                <label for="" class="mb-2">Salary</label>
                                <input type="number" name="salary" class="form-control" placeholder="Enter Salary">
                            </div>
                            <button class="btn btn-primary text-center float-end mt-3">Create</button>
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
{!! JsValidator::formRequest('App\Http\Requests\StoreSalary', '#create') !!}
    <script>
        $(document).ready(function(){
        $('.user').select2( {
            placeholder: "Choice Employee",
            allowClear: true
        } );
        $('#months').select2( {
            placeholder: "Select Months",
            theme: 'bootstrap-5',
        } );
        $('#years').select2( {
                placeholder: "Select Years",
                theme: 'bootstrap-5',
        } );
        })
    </script>
@endsection
