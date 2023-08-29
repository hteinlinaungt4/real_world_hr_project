@extends('layouts.app')
@section('title','Role Create')
@section('content')
<div class="container-fluid">
    <div class="row justify-content-center align-content-center">
        <div class="col-md-10">
           <div class="card px-3 border-0 shadow mt-5" >
            <div class="card-body">
                <form action="{{ route('role.store') }}" method="post" id="create" enctype="multipart/form-data">
                    @csrf
                    <div class="row  justify-content-center align-content-center " style="height: 500px;">
                        <div class="col-md-6">
                            <div class="form-group mb-2">
                                <label for="" class="mb-2">Name</label>
                                <input type="text" name="name" class="form-control" placeholder="Enter Role Name ...">
                            </div>
                            <label class="my-2">Permission</label>
                            <div class="row">
                               @foreach($permissions as $permission)
                                <div class="col-3">
                                    <div class="form-check">
                                        <input class="form-check-input" name="permissions[]" type="checkbox" value="{{$permission->id}}" id="{{$permission->id}}">
                                        <label class="form-check-label" for="{{$permission->id}}">
                                           {{ $permission->name }}
                                        </label>
                                    </div>
                                </div>
                               @endforeach
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
{!! JsValidator::formRequest('App\Http\Requests\StoreRole', '#create') !!}
    <script>
        $(document).ready(function(){
        })
    </script>
@endsection
