@extends('layouts.app')
@section('title','Permission Update')
@section('content')
<div class="container-fluid">
    <div class="row justify-content-center align-content-center">
        <div class="col-md-10">
           <div class="card px-3 border-0 shadow mt-5" >
            <div class="card-body">
                <form action="{{ route('permission.update',$permission->id) }}" method="post" id="create" enctype="multipart/form-data">
                    @method('PUT')
                    @csrf
                    <div class="row  justify-content-center align-content-center " style="height: 500px;">
                        <div class="col-md-6">
                            <div class="form-group mb-2">
                                <label for="" class="mb-2">Name</label>
                                <input type="text" name="name" value="{{$permission->name}}" class="form-control" placeholder="Enter Permission Name ...">
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
{!! JsValidator::formRequest('App\Http\Requests\UpdatePermission', '#create') !!}
    <script>
        $(document).ready(function(){
        })
    </script>
@endsection
