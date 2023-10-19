@extends('layouts.app')
@section('title','My Project Detail')
@section('extracss')
    <style>
        .task-menu{
            padding: 8px;
            background-color: #ffff;
            border: 1px solid black;
            border-radius: 5px;
            margin-bottom: 5px;

        }
        label{
            display: block !important;
            text-align: left;
        }
        div:where(.swal2-container) .swal2-checkbox input {
            flex-shrink: 0;
            margin: 0 0.4em;
            display: none !important;
        }
        #pending,#progress,#complete{
            padding: 5px;
        }


        .select2-container {
            box-sizing: border-box;
            display: inline-block;
            margin: 0;
            position: relative;
            vertical-align: middle;
            z-index: 9999!important;
        }
        .select2-container--bootstrap-5 .select2-selection--single .select2-selection__rendered {
            padding: 0;
            font-weight: 400;
            line-height: 1.5;
            color: #212529;
            text-align: left !important;
        }
        .ghost{
            background-color: #eee;
            border: 2px dashed #333;
        }
        .handle{
            cursor: move;
	        cursor: -webkit-grabbing;
        }

    </style>
@endsection
@section('content')
<div class="container-fluid vh-100">
    <div class="row justify-content-center align-content-center mt-5">
        <div class="col-md-10">
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
                <div class="row my-2">
                    <h3>Task</h3>
                    <div class="task_table"></div>
                </div>
        </div>
    </div>

</div>
@endsection
@section('script')
    <script>
        $(document).ready(function(){
            var project_id = "{{ $project->id }}";
            var leaders=@json($project->leaders);
            var members=@json($project->members);
           new Viewer(document.getElementById('images'));
           task_table();
            function task_table(){
                $.ajax({
                    url:`/task_table?id=${project_id}`,
                    type:'get',
                    success:function(res){
                        $('.task_table').html(res);
                        sortable();
                    }
                })
            }
        // sortablbe
        function sortable(){
            var pendingtask = document.getElementById('pendingtask');
            var inprogresstask = document.getElementById('inprogresstask');
            var completetask = document.getElementById('completetask');

             Sortable.create(pendingtask,{
                group: "task",
                animation: 200,
                draggable: ".task-menu",
                ghostClass: "ghost",
                store:{
                    set:function(sortable){
                        var order = sortable.toArray();
                        localStorage.setItem('pendingtask', order.join(','));
                    }
                },
            	onSort: function (evt) {
                    setTimeout(function() {
                        var pendingtask=localStorage.getItem('pendingtask');
                        $.ajax({
                            url : `/task_sort?project_id=${project_id}&pendingtask=${pendingtask}`,
                            method:'get',
                            success:function(re){
                            }
                        })
                    },1000);
	            },
             });
             Sortable.create(inprogresstask,{
                group: "task",
                animation: 200,
                draggable: ".task-menu",
                ghostClass: "ghost",
                store:{
                    set:function(sortable){
                        var order = sortable.toArray();
                        localStorage.setItem('inprogresstask', order.join(','));
                    }
                },
            	onSort: function (evt) {
                    setTimeout(function() {
                        var inprogresstask=localStorage.getItem('inprogresstask');
                        $.ajax({
                            url : `/task_sort?project_id=${project_id}&inprogresstask=${inprogresstask}`,
                            method:'get',
                            success:function(re){
                            }
                        })
                    },1000);
	            },

             });
             Sortable.create(completetask,{
                group: "task",
                animation: 200,
                draggable: ".task-menu",
                ghostClass: "ghost",
                store:{
                    set:function(sortable){
                        var order = sortable.toArray();
                        localStorage.setItem('completetask', order.join(','));
                    }
                },
            	onSort: function (evt) {
                    setTimeout(function() {
                        var completetask=localStorage.getItem('completetask');
                        $.ajax({
                            url : `/task_sort?project_id=${project_id}&completetask=${completetask}`,
                            method:'get',
                            success:function(re){
                                console.log(re);
                            }
                        })
                    },1000);
	            },
             });
        }
        // edit
        $(document).on("click",".edit",function(e){
            e.preventDefault();
            var task=$(this).data('task');
            var task_members=JSON.parse(atob($(this).data('member')));
            var task_members_options = '';
                leaders.forEach(function(leader){
                    task_members_options +=`<option value="${leader.id}" ${(task_members.includes(leader.id) ? 'selected' : '')}>${leader.name}(${leader.employee_id})</option>`;
                });
                members.forEach(function(member){
                    task_members_options +=`<option value="${member.id}" ${(task_members.includes(member.id) ? 'selected' : '')}>${member.name}(${member.employee_id})</option>`;
                });
                Swal.fire({
                    title: 'Edit Task',
                    html:`
                    <form id="complete">
                        <div class="form-group mb-2">
                            <label for="" class="mb-2">Title</label>
                            <input type="text" value='${task.title}' name="title" class="form-control" placeholder="Enter Title Name ...">
                        </div>
                        <div class="form-group mb-2">
                            <label for="" class="mb-2">Description</label>
                            <textarea name="description"  class="form-control" rows="5" placeholder="Enter Description ..." >${task.description}</textarea>
                        </div>

                        <div class="form-group mb-2">
                            <label for="" class="mb-2">Start Date</label>
                            <input id="start_date" value='${task.start_date}' type="text" name="start_date" class="form-control" placeholder="Enter Start Date ...">
                        </div>
                        <div class="form-group mb-2">
                            <label for="" class="mb-2">Deadline</label>
                            <input id="deadline" type="text" value='${task.deadline}' name="deadline" class="form-control" placeholder="Enter Deadline ...">
                        </div>
                        <div class="form-group mb-2">
                                <label for="" class="mb-2">Members</label>
                                <select name="members[]" id="" class="select_hr form-control" multiple>
                                    <option value="">--Please Choose--</option>
                                    ${task_members_options}
                                </select>
                        </div>
                        <div class="form-group mb-2">
                                <label for="" class="mb-2">Priority</label>
                                <select name="priority" id="" class="select_hr form-control">
                                    <option value="">--Please Choose--</option>
                                    <option value="high" ${(task.priority == "high" ? 'selected' : '')}>High</option>
                                    <option value="middle" ${(task.priority == "middle" ? 'selected' : '')}>Middle</option>
                                    <option value="low" ${(task.priority == "low" ? 'selected' : '')}>Low</option>
                                </select>
                        </div>
                    </form>
                    `,
                    showCancelButton: false,
                    confirmButtonText: 'Create',

                    }).then((result) => {
                        var form_data=$('#complete').serialize();
                        $.ajax({
                            url:`/task/${task.id}`,
                            data:`${form_data}`,
                            type:'put',
                            success:function(re){
                                task_table();
                            }
                        })
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
                    $('.select_hr').select2( {
                        theme: 'bootstrap-5',
                    } );

        })
        //delete
         $(document).on('click', '.delete', function(e) {
                e.preventDefault();
                var id= $(this).data('id');
                Swal.fire({
                    title: 'Are you sure you want to Delete?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                        method: "Delete",
                        url: `/task/${id}`,
                        })
                        .done(function( msg ) {
                            task_table();
                            Swal.fire(
                            'Deleted!',
                            'Your are successfully deleted.',
                            'success'
                        )
                        });

                    }
                })
            })




        //complete
        $(document).on("click",".complete_btn",function(e){
                e.preventDefault();
                var task_members_options = '';
                leaders.forEach(function(leader){
                    task_members_options +=`<option value="${leader.id}">${leader.name}(${leader.employee_id})</option>`;
                });
                members.forEach(function(member){
                    task_members_options +=`<option value="${member.id}">${member.name}(${member.employee_id})</option>`;
                });
                Swal.fire({
                    title: 'Add Complete Task',
                    html:`
                    <form id="complete">
                        <input type="hidden" name="project_id" value="{{$project->id}}">
                        <input type="hidden" name="status" value="complete">
                        <div class="form-group mb-2">
                            <label for="" class="mb-2">Title</label>
                            <input type="text" name="title" class="form-control" placeholder="Enter Title Name ...">
                        </div>
                        <div class="form-group mb-2">
                            <label for="" class="mb-2">Description</label>
                            <textarea name="description" class="form-control" rows="5" placeholder="Enter Description ..." ></textarea>
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
                                <label for="" class="mb-2">Members</label>
                                <select name="members[]" id="" class="select_hr form-control" multiple>
                                    <option value="">--Please Choose--</option>
                                    ${task_members_options}
                                </select>
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
                    </form>
                    `,
                    showCancelButton: false,
                    confirmButtonText: 'Create',

                    }).then((result) => {
                        var form_data=$('#complete').serialize();
                        $.ajax({
                            url:'/task',
                            data:`${form_data}`,
                            type:'Post',
                            success:function(re){
                                task_table();
                            }
                        })
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
                    $('.select_hr').select2( {
                        theme: 'bootstrap-5',
                    } );

           })
        //pending
        $(document).on("click",".pending_btn",function(e){
                e.preventDefault();
                var task_members_options = '';
                leaders.forEach(function(leader){
                    task_members_options +=`<option value="${leader.id}">${leader.name}(${leader.employee_id})</option>`;
                });
                members.forEach(function(member){
                    task_members_options +=`<option value="${member.id}">${member.name}(${member.employee_id})</option>`;
                });
                Swal.fire({
                    title: 'Add Pending Task',
                    html:`
                    <form id="pending">
                        <input type="hidden" name="project_id" value="{{$project->id}}">
                        <input type="hidden" name="status" value="pending">
                        <div class="form-group mb-2">
                            <label for="" class="mb-2">Title</label>
                            <input type="text" name="title" class="form-control" placeholder="Enter Title Name ...">
                        </div>
                        <div class="form-group mb-2">
                            <label for="" class="mb-2">Description</label>
                            <textarea name="description" class="form-control" rows="5" placeholder="Enter Description ..." ></textarea>
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
                                <label for="" class="mb-2">Members</label>
                                <select name="members[]" id="" class="select_hr form-control" multiple>
                                    <option value="">--Please Choose--</option>
                                    ${task_members_options}
                                </select>
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
                    </form>
                    `,
                    showCancelButton: false,
                    confirmButtonText: 'Create',

                    }).then((result) => {
                        var form_data=$('#pending').serialize();
                        $.ajax({
                            url:'/task',
                            data:`${form_data}`,
                            type:'Post',
                            success:function(re){
                                task_table();
                            }
                        })
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
                    $('.select_hr').select2( {
                        theme: 'bootstrap-5',
                    } );

         })
        //progress
        $(document).on("click",".progress_btn",function(e){
                e.preventDefault();
                var task_members_options = '';
                leaders.forEach(function(leader){
                    task_members_options +=`<option value="${leader.id}">${leader.name}(${leader.employee_id})</option>`;
                });
                members.forEach(function(member){
                    task_members_options +=`<option value="${member.id}">${member.name}(${member.employee_id})</option>`;
                });
                Swal.fire({
                    title: 'Add In_Progress Task',
                    html:`
                    <form id="progress">
                        <input type="hidden" name="project_id" value="{{$project->id}}">
                        <input type="hidden" name="status" value="in_progress">
                        <div class="form-group mb-2">
                            <label for="" class="mb-2">Title</label>
                            <input type="text" name="title" class="form-control" placeholder="Enter Title Name ...">
                        </div>
                        <div class="form-group mb-2">
                            <label for="" class="mb-2">Description</label>
                            <textarea name="description" class="form-control" rows="5" placeholder="Enter Description ..." ></textarea>
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
                                <label for="" class="mb-2">Members</label>
                                <select name="members[]" id="" class="select_hr form-control" multiple>
                                    <option value="">--Please Choose--</option>
                                    ${task_members_options}
                                </select>
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
                    </form>
                    `,
                    showCancelButton: false,
                    confirmButtonText: 'Create',

                    }).then((result) => {
                        var form_data=$('#progress').serialize();
                        $.ajax({
                            url:'/task',
                            data:`${form_data}`,
                            type:'Post',
                            success:function(re){
                                task_table();
                            }
                        })
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
                    $('.select_hr').select2( {
                        theme: 'bootstrap-5',
                    } );

                })
            })






    </script>
@endsection


