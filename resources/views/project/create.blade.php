@extends('layouts.app')
@section('title','Project Create')
@section('content')
<div class="container-fluid vh-100">
    <div class="row justify-content-center align-content-center mt-5">
        <div class="col-md-10">
           <div class="card px-3 border-0 shadow " >
            <div class="card-body">
                <form action="{{ route('project.store') }}" method="post" id="create" enctype="multipart/form-data">
                    @csrf
                    <div class="row justify-content-center">
                        <div class="col-md-10">
                            <div class="form-group mb-2">
                                <label for="" class="mb-2">Title</label>
                                <input type="text" name="title" class="form-control" placeholder="Enter Title Name ...">
                            </div>
                            <div class="form-group mb-2">
                                <label for="" class="mb-2">Description</label>
                                <textarea name="description" class="form-control" rows="5"></textarea>
                            </div>
                            <div class="form-group mb-2">
                                <label for="" class="mb-2">Images (Only PNG,JPG,JPEG) </label>
                                <input type="file" id="file" name="images[]" class="form-control" multiple accept="image/png,image/jpg,image/jpeg">
                                <div class="preview"></div>
                            </div>
                            <div class="form-group mb-2">
                                <label for="" class="mb-2">Files (Only PDF) </label>
                                <input type="file" name="files[]" class="form-control" multiple  accept="application/pdf">
                            </div>
                            <div class="form-group mb-2">
                                <label for="" class="mb-2">Leader</label>
                                <select name="leader[]" id="" class="form-control select_hr" multiple>
                                    @foreach ($users as $user)
                                        <option value="{{$user->id}}">{{ $user->employee_id }} ({{ $user->name }})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group mb-2">
                                <label for="" class="mb-2">Member</label>
                                <select name="member[]" id="" class="form-control select_hr" multiple>
                                    @foreach ($users as $user)
                                        <option value="{{$user->id}}">{{ $user->employee_id }} ({{ $user->name }})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group mb-2">
                                <label for="" class="mb-2">Start Date</label>
                                <input id="start_date" type="text" name="start_date" class="form-control" placeholder="Enter Start Date ...">
                            </div>
                            <div class="form-group mb-2">
                                <label for="" class="mb-2">Deadline</label>
                                <input id="deadline" type="text" name="deadline" class="form-control" placeholder="Enter Deadline ...">
                            </div>
                            <div class="form-group mb-2">
                                <label for="" class="mb-2">Priority</label>
                                <select name="priority" id="" class="select_hr form-control">
                                    <option value="">--Please Choose--</option>
                                    <option value="high">High</option>
                                    <option value="middle">Middle</option>
                                    <option value="low">Low</option>
                                </select>
                            </div>
                            <div class="form-group mb-2">
                                <label for="" class="mb-2">Status</label>
                                <select name="status" id="" class="select_hr form-control">
                                    <option value="">--Please Choose--</option>
                                    <option value="pending">Pending</option>
                                    <option value="in_progress">In_Progress</option>
                                    <option value="complete">Complete</option>
                                </select>
                            </div>
                            <button class="btn btn-primary float-end text-center">Create</button>
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
{!! JsValidator::formRequest('App\Http\Requests\StoreProject', '#create') !!}
    <script>
        $(document).ready(function(){

        $('#file').on('change', function() {
            var file_length=this.files.length;
            $('.preview').html('');
            for (let i = 0; i < file_length; i++) {
                $('.preview').append(`<img class="p-2" style="width: 130px; height:100px; object-fit:cover;" src="${URL.createObjectURL(event.target.files[i])}"/>`);
            }
        })
        $('#start_date').daterangepicker({
            "singleDatePicker": true,
            "showDropdowns": true,
            "autoApply": true,
            "locale":{
                "format":"YYYY-MM-DD",
            }
        })
        $('#deadline').daterangepicker({
            "singleDatePicker": true,
            "showDropdowns": true,
            "autoApply": true,
            "locale":{
                "format":"YYYY-MM-DD",
            }
        })
        })
    </script>
@endsection

