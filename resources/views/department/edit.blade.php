@extends('layouts.app')
@section('title','Department Update')
@section('content')
<div class="container-fluid">
    <div class="row justify-content-center align-content-center">
        <div class="col-md-10">
           <div class="card px-3 border-0 shadow mt-5" >
            <div class="card-body">
                <form action="{{ route('department.update',$department->id) }}" method="post" id="create" enctype="multipart/form-data">
                    @method('PUT')
                    @csrf
                    <div class="row  justify-content-center align-content-center " style="height: 500px;">
                        <div class="col-md-6">
                            <div class="form-group mb-2">
                                <label for="" class="mb-2">Name</label>
                                <input type="text" name="title" value="{{$department->title}}" class="form-control" placeholder="Enter Department Name ...">
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
{!! JsValidator::formRequest('App\Http\Requests\UpdateDepartment', '#create') !!}
    <script>
        $(document).ready(function(){
        })
    </script>
@endsection
