@extends('layouts.app')
@section('title','Project Detail')
@section('content')
<div class="container-fluid vh-100">
    <div class="row justify-content-center align-content-center mt-5">
        <div class="col-md-10">
           <div class="card px-3 border-0 shadow " >
            <div class="card-body">
                <div class="row">
                    <div class="col-md-8">
                       <div class="card shadow-lg border-0 mb-2">
                        <div class="card-body">
                            <h3>{{$project->title}}</h3>
                            <p><span class="ml-2">Start Date: <span class="text-muted">{{ $project->start_date }}</span></span> |<span class="mx-2">Deadline: <span class="text-muted">{{ $project->deadline }}</span></span></p>
                            <p>
                                <span class="ml-2">
                                    Priority :
                                    @if ($project->priority == "high")
                                        <span class=" badge badge-pill badge-danger bg-danger mx-2 p-2">High</span>
                                    @elseif($project->priority == "middle")
                                        <span class=" badge badge-pill text-black badge-danger bg-info mx-2 p-2 fw-bold">Middle</span>
                                    @else
                                    <span class=" badge badge-pill badge-danger bg-primary mx-2 p-2">Low</span>
                                    @endif

                                </span> |
                                <span class="mx-2">
                                    Status :
                                    @if ($project->status == "pending")
                                    <span class=" badge badge-pill badge-danger bg-danger mx-2 p-2">Pending</span>
                                    @elseif($project->status == "in_progress")
                                    <span class=" badge badge-pill text-black badge-danger bg-info mx-2 p-2 fw-bold">In_Progress</span>
                                    @else
                                    <span class=" badge badge-pill badge-danger bg-primary mx-2 p-2">Complete</span>
                                    @endif

                                </span>
                            </p>
                            <p>
                                <h5>Description</h5>
                                <span>
                                    {{ $project->description}}
                                </span>
                            </p>
                        </div>
                       </div>
                        <div class="col-md-12">
                            <div class="card mb-2">
                                <div class="card-body">
                                    <h5>Images</h5>
                                    <div id="images">
                                        @if($project->images)
                                            @foreach ($project->images as $image)
                                                <img style="width: 150px;" class=" rounded" src="{{ asset('storage/project/'.$image)}}" alt="">
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="card mb-2">
                                <div class="card-body">
                                    <h5>Files</h5>
                                    @if($project->files)
                                        @foreach ($project->files as $file)
                                            <a href="{{ asset('storage/project/'.$file) }}" class="recent_file"  target="_blank"><i class="fa-solid fa-file-pdf" style="font-size: 50px; padding:20px;color:black;"></i></a>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <h4 class="mb-2">Leaders</h4>
                        <div class="card shadow-lg border-0 mb-2">
                            <div class="card-body">
                                @foreach ($project->leaders as $leader)
                                    @if($leader->img_path() == null)
                                        <img src="https://bootdey.com/img/Content/avatar/avatar7.png" alt="Admin"
                                        style="width: 50px; height:50px;" class=" mb-1 border border-success p-1 rounded rounded-circle mx-1">
                                    @else
                                        <img style="width:50px;height:50px;" class=" mb-1 border border-success p-1 rounded rounded-circle mx-1"  src={{$leader->img_path()}}>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                        <h4 class="mb-2">Members</h4>
                        <div class="card shadow-lg border-0">
                            <div class="card-body">
                                @foreach ($project->members as $member)
                                    @if($member->img_path() == null)
                                        <img src="https://bootdey.com/img/Content/avatar/avatar7.png" alt="Admin"
                                        style="width: 50px; height:50px;" class=" mb-1 border border-success p-1 rounded rounded-circle mx-1">
                                    @else
                                        <img style="width:50px;height:50px;" class=" mb-1 border border-success p-1 rounded rounded-circle mx-1"  src={{$member->img_path()}}>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
           </div>
        </div>
    </div>
</div>
@endsection
@section('script')
    <script>
        $(document).ready(function(){
           new Viewer(document.getElementById('images'));
        })
    </script>
@endsection

