<div class="row">
    <div class="col-md-4">
        <div class="card mb-3">
            <div class="card-header text-white" style="background-color: #f9db7b">
                <h6><i class="fa-solid fa-list"></i> Pending</h6>
            </div>
            <div class="card-body" id="pendingtask" style="background-color: #fff3cd">
                @foreach (collect($project->tasks)->sortBy('serial_number')->where('status','pending') as  $task)
                    <div class="task-menu" data-id={{$task->id}}>
                        <div class="d-flex justify-content-between">
                            <h6>{{ $task->title}}</h6>
                            <div>
                                <a href="" data-member="{{base64_encode(json_encode(collect($task->task_members)->pluck('id')->toArray()))}}" data-task="{{ $task }}" class="p-1 bg-light mx-1 shadow edit"><i class="fa-regular fa-pen-to-square p-1 text-black"></i></a>
                                <a href="" data-id={{$task->id}} class="p-1 bg-light  shadow delete"><i class="fa-solid fa-trash p-1 text-danger"></i></a>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between align-content-end">
                            <div>
                                <i class="fas fa-clock"></i> {{Carbon\Carbon::parse($task->start_date)->format('M-d') }}<br>
                                @if ($task->priority == "high")
                                    <span class=" badge badge-pill bg-danger text-white rounded">High</span>
                                @elseif ($task->priority == "middle")
                                    <span class=" badge badge-pill bg-info text-white rounded">Middle</span>
                                @elseif ($task->priority == "low")
                                    <span class=" badge badge-pill bg-primary text-white rounded">Low</span>
                                @endif
                            </div>
                            <div class=" align-self-end">
                                @foreach ($task->task_members as $member)
                                    @if ($member->image != null)
                                    <img src="{{ asset('storage/'.$member->image)}}" alt="Admin"
                                    style="width: 30px; height:30px;" class="border border-success p-1 rounded rounded-circle">
                                    @else
                                    <img src="https://bootdey.com/img/Content/avatar/avatar7.png" alt="Admin"
                                    style="width: 30px; height:30px;" class="border border-success p-1 rounded rounded-circle">
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="card-footer">
                <button class="btn btn-warning w-100 text-white pending_btn"><i class="fa fa-plus-circle"></i> Add Task</button>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card mb-3">
            <div class="card-header text-white" style="background-color: #83e6f7">
                <h6><i class="fa-solid fa-list"></i> In Progress</h6>
            </div>
            <div class="card-body" id="inprogresstask" style="background-color: #c6f1f8">
                @foreach (collect($project->tasks)->sortBy('serial_number')->where('status','in_progress') as  $task)
                    <div class="task-menu" data-id={{$task->id}}>
                        <div class="d-flex justify-content-between">
                            <h6>{{ $task->title}}</h6>
                            <div>
                                <a href="" data-member="{{base64_encode(json_encode(collect($task->task_members)->pluck('id')->toArray()))}}" data-task="{{ $task }}" class="p-1 bg-light mx-1 shadow edit"><i class="fa-regular fa-pen-to-square p-1 text-black"></i></a>
                                <a href="" data-id={{$task->id}} class="p-1 bg-light  shadow delete"><i class="fa-solid fa-trash p-1 text-danger"></i></a>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between align-content-end">
                            <div>
                                <i class="fas fa-clock"></i> {{Carbon\Carbon::parse($task->start_date)->format('M-d') }}<br>
                                @if ($task->priority == "high")
                                    <span class=" badge badge-pill bg-danger text-white rounded">High</span>
                                @elseif ($task->priority == "middle")
                                    <span class=" badge badge-pill bg-info text-white rounded">Middle</span>
                                @elseif ($task->priority == "low")
                                    <span class=" badge badge-pill bg-primary text-white rounded">Low</span>
                                @endif
                            </div>
                            <div class=" align-self-end">
                                @foreach ($task->task_members as $member)
                                    @if ($member->image != null)
                                    <img src="{{ asset('storage/'.$member->image)}}" alt="Admin"
                                    style="width: 30px; height:30px;" class="border border-success p-1 rounded rounded-circle">
                                    @else
                                    <img src="https://bootdey.com/img/Content/avatar/avatar7.png" alt="Admin"
                                    style="width: 30px; height:30px;" class="border border-success p-1 rounded rounded-circle">
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @endforeach
            </div>
            <div class="card-footer">
                <button class="btn btn-info w-100 text-white progress_btn"><i class="fa fa-plus-circle"></i> Add Task</button>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card mb-3">
            <div class="card-header text-white" style="background-color: #92f3a8">
                <h6><i class="fa-solid fa-list"></i> Complete</h6>
            </div>
            <div class="card-body" id="completetask" style="background-color: #c5f0cf">
                @foreach (collect($project->tasks)->sortBy('serial_number')->where('status','complete') as  $task)
                    <div class="task-menu" data-id={{$task->id}}>
                        <div class="d-flex justify-content-between">
                            <h6>{{ $task->title}}</h6>
                            <div>
                                <a href="" data-member="{{base64_encode(json_encode(collect($task->task_members)->pluck('id')->toArray()))}}" data-task="{{ $task }}" class="p-1 bg-light mx-1 shadow edit"><i class="fa-regular fa-pen-to-square p-1 text-black"></i></a>
                                <a href="" data-id={{$task->id}} class="p-1 bg-light  shadow delete"><i class="fa-solid fa-trash p-1 text-danger"></i></a>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between align-content-end">
                            <div>
                                <i class="fas fa-clock"></i> {{Carbon\Carbon::parse($task->start_date)->format('M-d') }}<br>
                                @if ($task->priority == "high")
                                    <span class=" badge badge-pill bg-danger text-white rounded">High</span>
                                @elseif ($task->priority == "middle")
                                    <span class=" badge badge-pill bg-info text-white rounded">Middle</span>
                                @elseif ($task->priority == "low")
                                    <span class=" badge badge-pill bg-primary text-white rounded">Low</span>
                                @endif
                            </div>
                            <div class=" align-self-end">
                                @foreach ($task->task_members as $member)
                                    @if ($member->image != null)
                                    <img src="{{ asset('storage/'.$member->image)}}" alt="Admin"
                                    style="width: 30px; height:30px;" class="border border-success p-1 rounded rounded-circle">
                                    @else
                                    <img src="https://bootdey.com/img/Content/avatar/avatar7.png" alt="Admin"
                                    style="width: 30px; height:30px;" class="border border-success p-1 rounded rounded-circle">
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @endforeach

            </div>
            <div class="card-footer">
                <button class="btn btn-success w-100 text-white complete_btn" style="background-color: #b9e4c2;"><i class="fa fa-plus-circle"></i> Add Task</button>
            </div>
        </div>
    </div>
</div>
