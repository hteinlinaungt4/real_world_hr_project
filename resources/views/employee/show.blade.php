@extends('layouts.app')
@section('title', 'Employee Detail')
@section('content')
<div class="container">
    <div class="main-body">
        <div class="row gutters-sm mt-5" >
            <div class="col-md-4 mb-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex flex-column align-items-center text-center">
                            @if ($employee->image != null)
                            <img src="{{ $employee->img_path() }}" alt="Admin"
                                class="rounded-circle" width="150">
                            @else
                            <img src="https://bootdey.com/img/Content/avatar/avatar7.png" alt="Admin"
                                class="rounded-circle" width="150">
                            @endif
                            <div class="mt-3">
                                <h4>{{ $employee->name}}</h4>
                                <p class="text-secondary mb-1">{{ $employee->department->title }}</p>
                                <p class="text-muted font-size-sm">{{ $employee->address}}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="mb-0">Employee ID</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                               {{ $employee->employee_id}}
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="mb-0">Name</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                               {{ $employee->name}}
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="mb-0">Email</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                {{ $employee->email}}
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="mb-0">Phone</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                {{ $employee->phone}}
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="mb-0">NRC Number</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                {{ $employee->nrc_number}}
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="mb-0">Gender</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                {{ $employee->gender}}
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="mb-0">Birthday</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                               {{ $employee->birthday}}
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="mb-0">Address</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                               {{ $employee->address}}
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="mb-0">Department</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                               {{ $employee->department->title}}
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="mb-0">Date of Join</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                               {{ $employee->date_of_join}}
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="mb-0">Is Present</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                @if ($employee->is_present == 1)
                                    Present
                                @else
                                    Absent
                                @endif
                            </div>
                        </div>
                        <hr>
                    </div>
                </div>




            </div>
        </div>
    </div>
</div>
@endsection
@section('script')

@endsection
