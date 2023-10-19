@extends('layouts.app')
@section('title','Project Update')
@section('content')
<div class="container-fluid vh-100">
    <div class="row justify-content-center align-content-center mt-5">
        <div class="col-md-10">
           <div class="card px-3 border-0 shadow " >
            <div class="card-body">
                <form action="{{ route('project.update',$project->id) }}" method="POST" id="create" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row justify-content-center">
                        <div class="col-md-10">
                            <div class="form-group mb-2">
                                <label for="" class="mb-2">Title</label>
                                <input type="text" value="{{ old('title',$project->title)}}" name="title" class="form-control" placeholder="Enter Title Name ...">
                            </div>
                            <div class="form-group mb-2">
                                <label for="" class="mb-2">Description</label>
                                <textarea name="description" class="form-control" rows="5">{{ old('description',$project->description) }}</textarea>
                            </div>
                            <div class="form-group mb-2">
                                <label for="" class="mb-2">Images (Only PNG,JPG,JPEG) </label>
                                <input type="file" id="file" name="images[]" class="form-control" multiple accept="image/png,image/jpg,image/jpeg">
                                <div class="preview"></div>
                                @if($project->images)
                                    <div id="recent" data-id={{count($project->images)}}></div>
                                    @foreach ($project->images as $image)
                                        <img class="p-3 recent_images"  style="width: 130px; height:100px; object-fit:cover;" src="{{ asset('storage/project/'.$image)}}" alt="image">
                                    @endforeach
                                @endif
                            </div>
                            <div class="form-group mb-2">
                                <label for="" class="mb-2">Files (Only PDF) </label>
                                <input id="pdf" type="file" name="files[]" class="form-control" multiple  accept="application/pdf">
                                @if($project->files)
                                <div id="recent_files" data-id={{count($project->files)}}></div>
                                @foreach ($project->files as $file)
                                    <a href="{{ $file }}" class="recent_file"  target="_blank"><i class="fa-solid fa-file-pdf" style="font-size: 50px; padding:20px;color:black;"></i></a>
                                @endforeach
                            @endif
                            </div>
                            <div class="form-group mb-2">
                                <label for="" class="mb-2">Leader</label>
                                <select name="leader[]" id="" class="form-control select_hr" multiple>
                                    @foreach ($users as $user)
                                        <option value="{{$user->id}}" @if(in_array($user->id,collect($project->leaders)->pluck('id')->toArray())) selected @endif>{{ $user->employee_id }} ({{ $user->name }})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group mb-2">
                                <label for="" class="mb-2">Member</label>
                                <select name="member[]" id="" class="form-control select_hr" multiple>
                                    @foreach ($users as $user)
                                        <option value="{{$user->id}}" @if(in_array($user->id,collect($project->members)->pluck('id')->toArray())) selected @endif>{{ $user->employee_id }} ({{ $user->name }})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group mb-2">
                                <label for="" class="mb-2">Start Date</label>
                                <input id="start_date" value="{{old('start_date',$project->start_date)}}" type="text" name="start_date" class="form-control" placeholder="Enter Start Date ...">
                            </div>
                            <div class="form-group mb-2">
                                <label for="" class="mb-2">Deadline</label>
                                <input id="deadline" value="{{old('start_date',$project->deadline)}}"  type="text" name="deadline" class="form-control" placeholder="Enter Deadline ...">
                            </div>
                            <div class="form-group mb-2">
                                <label for="" class="mb-2">Priority</label>
                                <select name="priority" id="" class="select_hr form-control">
                                    <option value="">--Please Choose--</option>
                                    <option value="high" @if($project->priority == "high") selected @endif >High</option>
                                    <option value="middle" @if($project->priority == "middle") selected @endif>Middle</option>
                                    <option value="low" @if($project->priority == "low") selected @endif>Low</option>
                                </select>
                            </div>
                            <div class="form-group mb-2">
                                <label for="" class="mb-2">Status</label>
                                <select name="status" id="" class="select_hr form-control">
                                    <option value="">--Please Choose--</option>
                                    <option value="pending" @if($project->status == "pending") selected @endif>Pending</option>
                                    <option value="in_progress" @if($project->status == "in_progress") selected @endif>In_Progress</option>
                                    <option value="complete" @if($project->status == "complete") selected @endif>Complete</option>
                                </select>
                            </div>
                            <button class="btn btn-primary float-end text-center">Update</button>
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
{!! JsValidator::formRequest('App\Http\Requests\UpdateProject', '#create') !!}
    <script>
        $(document).ready(function(){

        $('#file').on('change', function() {
            var file_length=this.files.length;
            $('.preview').html('');
            var recent_length=$('#recent_files').data('id');
            console.log(recent_length);
            var recent_imagelength= $('#recent').data('id');
            for (let i = 0; i < recent_imagelength; i++) {
                $('.recent_images').hide();
            }
            for (let i = 0; i < file_length; i++) {
                $('.preview').append(`<img class="p-2" style="width: 130px; height:100px; object-fit:cover;" src="${URL.createObjectURL(event.target.files[i])}"/>`);
            }
        })
        $('#pdf').on('change', function() {
            var recent_length=$('#recent_files').data('id');
            for (let i = 0; i < recent_length; i++) {
                $('.recent_file').hide();
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

