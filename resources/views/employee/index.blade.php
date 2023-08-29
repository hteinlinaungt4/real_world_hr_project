@extends('layouts.app')
@section('title','Employee')
@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card mt-5 p-3 border-0">
                <div class="card-header bg-white">
                    @can('employee_create')
                    <a href="{{ route('employee.create') }}" class=" text-decoration-none btn btn-sm btn-primary"><i
                        class="fa-solid fa-circle-plus"></i> Add New</a>
                    @endcan
                </div>
                <div class="card-body">
                    <table class="table table-bordered text-center w-100 display nowrap"  id="usertable" >
                        <thead>
                            <th>Employee_id</th>
                             <th class="nosort">Profile</th>
                            <th>Email</th>
                            <th>Department</th>
                            <th>Role</th>
                            <th>Present</th>
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
                ajax: '/ssd/employee',
                columns: [
                    {
                        data: 'employee_id',
                        name: 'employee_id'
                    },
                    {
                        data: 'image',
                        name: 'image',
                        class: 'nosort',
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'department_name',
                        name: 'department_name'
                    },
                    {
                        data: 'role',
                        name: 'role'
                    },
                    {
                        data: 'is_present',
                        name: 'is_present'
                    },
                    {
                        data: 'actions',
                        name: 'actions',
                        class: 'text-center'
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
            $(document).on('click','.delete_btn', function(e) {
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
                        console.log(id);
                        $.ajax({
                        method: "Delete",
                        url:  `employee/${id}`,
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
