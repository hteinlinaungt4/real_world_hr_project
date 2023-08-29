@extends('layouts.app')
@section('title', 'Role')
@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card mt-5 p-3 border-0">
                    <div class="card-header">
                        @can('role_create')
                        <a href="{{ route('role.create') }}" class=" text-decoration-none btn btn-sm btn-primary"><i
                            class="fa-solid fa-circle-plus"></i> Add New</a>
                        @endcan
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered  w-100 display nowrap" id="usertable">
                            <thead>
                                <th class="text-center">ID</th>
                                <th class="text-center">Role</th>
                                <th class="text-center">Permissions</th>
                                <th class="nosort text-center">Actions</th>
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
                ajax: 'ssd/role',
                columns: [
                    {
                        data: 'id',
                        name: 'id',
                        class: 'text-center'
                    },
                    {
                        data: 'name',
                        name: 'name',
                        class: 'text-center'
                    },
                    {
                        data : 'permission',
                        name : 'permission',
                    },
                    {
                        data: 'actions',
                        name: 'actions',
                        class: 'mx-5 text-center'
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
                        url: `http://127.0.0.1:8000/role/${id}`,
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
