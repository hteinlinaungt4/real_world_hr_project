@extends('layouts.app')
@section('title', 'My Project')
@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card mt-5 p-3 border-0">
                    <div class="card-header">
                        @can('project_create')
                        <a href="{{ route('project.create') }}" class=" text-decoration-none btn btn-sm btn-primary"><i
                            class="fa-solid fa-circle-plus"></i> Add New</a>
                        @endcan
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered  w-100 display " id="usertable">
                            <thead class="text-center">
                                <th>Title</th>
                                <th>Description</th>
                                <th>Leaders</th>
                                <th>Members</th>
                                <th>Start Date</th>
                                <th>Deadline</th>
                                <th>Priority</th>
                                <th>Status</th>
                                <th class="nosort">Actions</th>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            var table=$('#usertable').DataTable({
                mark:true,
                responsive: true,
                processing: true,
                serverSide: true,
                ajax: 'ssd/myproject',
                columns: [
                    {
                        data: 'title',
                        name: 'title'
                    },
                    {
                        data: 'description',
                        name: 'description',
                    },
                    {
                        data: 'leader',
                        name: 'leader',
                    },
                    {
                        data: 'member',
                        name: 'member',
                    },
                    {
                        data: 'start_date',
                        name: 'start_date',
                    },
                    {
                        data: 'deadline',
                        name: 'deadline',
                    },
                    {
                        data: 'priority',
                        name: 'priority',
                    },
                    {
                        data: 'status',
                        name: 'status',
                    },
                    {
                        data: 'actions',
                        name: 'actions',
                        class: 'mx-5'
                    }
                ],
                columnDefs: [{
                    orderable: false,
                    targets: 'nosort'
                },
            ],
            });
            @if (session('successmsg'))
                Swal.fire({
                    icon: 'success',
                    title: 'Success...',
                    text: '{{ session('successmsg') }}',
                });
            @endif
            $(document).on('click', '.delete_btn', function(e) {
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
                        url: `project/${id}`,
                        })
                        .done(function( msg ) {
                            table.ajax.reload();
                            Swal.fire(
                            'Deleted!',
                            'Your are successfully deleted.',
                            'success'
                        )
                        });

                    }
                })
            })

        });
    </script>
@endsection
