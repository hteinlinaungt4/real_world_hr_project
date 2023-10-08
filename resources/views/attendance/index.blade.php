@extends('layouts.app')
@section('title', 'Attendance')
@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card mt-5 p-3 border-0">
                    <div class="card-header">
                        @can('department_create')
                        <a href="{{ route('attendance.create') }}" class=" text-decoration-none btn btn-sm btn-primary">
                            <i class="fa-solid fa-circle-plus"></i> Add New</a>
                        @endcan
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered text-center w-100 display nowrap" id="usertable">
                            <thead>
                                <th>Employee_Name</th>
                                <th>Date</th>
                                <th>Checkin_time</th>
                                <th>Checkout_time</th>
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
                ajax: 'ssd/attendance',
                columns: [
                    {
                        data: 'employee_name',
                        name: 'employee_name'
                    },
                    {
                        data: 'date',
                        name: 'date'
                    },
                    {
                        data: 'checkin_time',
                        name: 'checkin_time'
                    },
                    {
                        data: 'checkout_time',
                        name: 'checkout_time'
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
                        url: `attendance/${id}`,
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
