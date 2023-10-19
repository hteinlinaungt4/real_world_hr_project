<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    {{-- figureprint  --}}
    {{-- @vite(['resources/js/app.js']) --}}
    <script src="{{ Vite::asset('resources/js/vendor/webauthn/webauthn.js') }}"></script>
    {{-- viewrjs --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/viewerjs/1.11.6/viewer.min.css" integrity="sha512-za6IYQz7tR0pzniM/EAkgjV1gf1kWMlVJHBHavKIvsNoUMKWU99ZHzvL6lIobjiE2yKDAKMDSSmcMAxoiWgoWA==" crossorigin="anonymous" referrerpolicy="no-referrer" />    {{-- fontawesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    {{-- bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    {{-- datatable --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">

    {{-- mark --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/datatables.mark.js/2.0.0/datatables.mark.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/plug-ins/1.10.13/features/mark.js/datatables.mark.min.css">
    {{-- datatable responsive  --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/rowreorder/1.4.1/css/rowReorder.dataTables.min.css">
    {{-- daterangepicker --}}
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    {{-- external css --}}
    <link rel="stylesheet" href="{{ asset('css/style.css')}}">
    {{-- select2 --}}
    <!-- Styles -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
<!-- Or for RTL support -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.rtl.min.css" />
{{-- extra css  --}}
@yield('extracss')

</head>
<body>
    <div class="offcanvas offcanvas-start" data-bs-backdrop="static" tabindex="-1" id="staticBackdrop" aria-labelledby="staticBackdropLabel">
        <div class="offcanvas-header">
          <h5 class="offcanvas-title fs-1" id="staticBackdropLabel">Dashboard</h5>
          <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <div class="text-center preview my-4" >
                @if (Auth::user()->image != null)
                <img src="{{ asset('storage/'.Auth::user()->image)}}" alt="Admin"
                style="width: 150px; height:150px;" class="border border-success p-1 rounded rounded-circle">
                @else
                <img src="https://bootdey.com/img/Content/avatar/avatar7.png" alt="Admin"
                style="width: 150px; height:150px;" class="border border-success p-1 rounded rounded-circle">
                @endif
                <h3 class="my-3">{{ Auth::user()->employee_id}}</h3>
            </div>
            <hr>
          <div class="mt-2">
            <ul class="list-unstyled">
                @can('employee_view')
                <li class="fs-3">
                    <a href="{{ route('employee.index')}}" class="text-decoration-none text-black">
                        <i class="fa-solid fa-users mx-2"></i>| Employee
                    </a>
                    <hr>
                </li>
                @endcan
                @can('attendance_view')
                <li class="fs-3">
                    <a href="{{ route('attendance.index')}}" class="text-decoration-none text-black">
                        <i class="fa-solid fa-calendar-week mx-2"></i>  | Attendance
                    </a>
                    <hr>
                </li>
                @endcan
                @can('attendance_overview')
                <li class="fs-3">
                    <a href="{{ route('attendance_overview') }}" class="text-decoration-none text-black">
                        <i class="fa-solid fa-calendar-week mx-2"></i>  | Attendance(Overview)
                    </a>
                    <hr>
                </li>
                @endcan
                @can('salary_view')
                <li class="fs-3">
                    <a href="{{ route('salary.index') }}" class="text-decoration-none text-black">
                        <i class="fa-solid fa-hand-holding-dollar mx-2"></i>  | Salary
                    </a>
                    <hr>
                </li>
                @endcan
                @can('payroll_view')
                <li class="fs-3">
                    <a href="{{ route('payroll') }}" class="text-decoration-none text-black">
                        <i class="fa-solid fa-money-check-dollar mx-2"></i>  | Payroll
                    </a>
                    <hr>
                </li>
                @endcan
                @can('department_view')
                <li class="fs-3">
                    <a href="{{ route('department.index')}}" class="text-decoration-none text-black">
                        <i class="fa-solid fa-briefcase mx-2"></i> | Department
                    </a>
                    <hr>
                </li>
                @endcan
                @can('permission_view')
                <li class="fs-3">
                    <a href="{{ route('permission.index')}}" class="text-decoration-none text-black">
                        <i class="fa-solid fa-shield-halved mx-2"></i> | Permission
                    </a>
                    <hr>
                </li>
                @endcan
                @can('role_view')
                <li class="fs-3">
                    <a href="{{ route('role.index')}}" class="text-decoration-none text-black">
                        <i class="fa-solid fa-user-graduate mx-2"></i>  | Role
                    </a>
                    <hr>
                </li>
                @endcan
                @can('project_view')
                <li class="fs-3">
                    <a href="{{ route('project.index')}}" class="text-decoration-none text-black">
                        <i class="fa-solid fa-toolbox mx-2"></i>  | Project
                    </a>

                    <hr>
                </li>
                @endcan
                <li class="fs-3">
                    <a href="{{ route('company_setting.show',1)}}" class="text-decoration-none text-black">
                        <i class="fa-solid fa-gear mx-2"></i> | Company Settings
                    </a>
                    <hr>
                </li>
            </ul>
          </div>
        </div>
    </div>
    <section>
        <div class="container-fluid">
            <div class="row justify-content-center shadow align-content-center">
                <div class="col-md-10">
                    <ul class="d-flex justify-content-between  list-unstyled">
                        {{-- @if( Request::url() == "http://127.0.0.1:8000/dashboard" || Request::url() == "http://127.0.0.1:8000/employee" || Request::url() == "http://127.0.0.1:8000/role" || Request::url() == "http://127.0.0.1:8000/permission" || Request::url() == "http://127.0.0.1:8000/department") --}}
                        <li class="fs-3"><i class="fa-solid fa-bars" type="button" data-bs-toggle="offcanvas" data-bs-target="#staticBackdrop" aria-controls="staticBackdrop"></i></li>
                        {{-- @else --}}
                        {{-- <a href="#" id="back"> <i class="fa-solid fa-backward"></i></a> --}}
                        {{-- @endif --}}
                        <li class="fs-3">@yield('title')</li>
                        <li class="fs-3">
                            <form action="{{ route('logout')}}" method="POST">
                                @csrf
                                <button class=" border-0 bg-transparent" >
                                    <i class="fa-solid fa-right-from-bracket"></i>
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <section class="" style="position:relative;max-height: 84vh; overflow: scroll;overflow-x:hidden" >
        @yield('content')
    </section>
    <section>
        <nav class="d-flex justify-content-between bg-light w-100 px-2 py-1 shadow-lg" style="position:absolute;bottom: 0;width: 100%">
            <a href="{{route('dashboard')}}" class="text-center text-decoration-none fs-5 text-black"> <i class="fa-solid fa-home fs-5 mx-2 text-black "></i><div>Home</div></a>
            <a href="{{route('profile')}}" class="text-center text-decoration-none fs-5 text-black"> <i class="fa-solid fa-user fs-5 mx-2 text-black "></i><div>Profile</div></a>
            <a href="{{route('myproject.index')}}" class="text-center text-decoration-none fs-5 text-black"> <i class="fa-solid fa-toolbox fs-5 mx-2 text-black "></i><div>My Project</div></a>
            <a href="{{route('attendance_scan')}}" class="text-center text-decoration-none fs-5 text-black"> <i class="fa-solid fa-calendar-week fs-5 mx-2 text-black "></i><div>Attendance</div></a>
        </nav>
    </section>

{{-- jquery --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js" integrity="sha512-3gJwYpMe3QewGELv8k/BX9vcqhryRdzRMxVfq6ngyWXwo03GFEzjsUm8Q7RZcHPHksttq7/GFoxjCVUjkjvPdw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
{{-- bootstrap --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
{{-- datatable --}}
{{-- <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script> --}}
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
{{-- mark  --}}
<script src="https://cdn.jsdelivr.net/g/mark.js(jquery.mark.min.js),datatables.mark.js"></script>
<script src="https://cdn.jsdelivr.net/g/mark.js(jquery.mark.min.js)"></script>
<script src="https://cdn.datatables.net/plug-ins/1.10.13/features/mark.js/datatables.mark.js"></script>
{{-- datatable responsive --}}
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/rowreorder/1.4.1/js/dataTables.rowReorder.min.js"></script>
{{-- Validation --}}
<script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
{{-- sweetalert --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
{{-- daterangepicker --}}
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
{{-- sortable  --}}
<!-- jsDelivr :: Sortable :: Latest (https://www.jsdelivr.com/package/npm/sortablejs) -->
<script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
{{-- select2 --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/viewerjs/1.11.6/viewer.min.js" integrity="sha512-EC3CQ+2OkM+ZKsM1dbFAB6OGEPKRxi6EDRnZW9ys8LghQRAq6cXPUgXCCujmDrXdodGXX9bqaaCRtwj4h4wgSQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script><!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
@yield('script')
<script>
    $(document).ready(function(){
        $('#back').on('click',function(e){
            e.preventDefault();
            window.history.go(-1);
            return false;

        })
        $('.select_hr').select2( {
            theme: 'bootstrap-5',
        } );
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    })
</script>
</body>
</html>
