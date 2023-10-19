@extends('layouts.app')
@section('title','Profile')
@section('content')
    <div class="container-fluid vh-100">
        <div class="row d-flex justify-content-center mt-5">
            <div class="col-md-8">
                <div class="card p-5 border-0 shadow">
                    <div class="row justify-content-center">
                        <div class="col-6 text-center">
                            <div class="text-center preview " >
                                @if (Auth::user()->image != null)
                                <img src="{{ asset('storage/'.Auth::user()->image)}}" alt="Admin"
                                style="width: 100px; height:100px;" class="border border-success p-1 rounded rounded-circle">
                                @else
                                <img src="https://bootdey.com/img/Content/avatar/avatar7.png" alt="Admin"
                                style="width: 100px; height:100px;" class="border border-success p-1 rounded rounded-circle">
                                @endif
                                <h3 class="my-3">{{ Auth::user()->name}}</h3>
                                <p>{{Auth::user()->employee_id}} | <span class="text-success fw-bold">{{Auth::user()->phone}}</span></p>
                                <p class="">{{Auth::user()->department->title ? Auth::user()->department->title : 'No_Department'  }}</p>
                            </div>
                        </div>
                        <div class="col-6 px-3" style="border-left:3px dotted black;">
                            <p>Phone: {{Auth::user()->phone}}</p>
                            <p>Email: {{Auth::user()->email}}</p>
                            <p>NRC Number: {{Auth::user()->nrc_number}}</p>
                            <p>Gender: {{Auth::user()->gender}}</p>
                            <p>Birthday: {{Auth::user()->birthday}}</p>
                            <p>Address: {{Auth::user()->address}}</p>
                            <p>Date of Join: {{Auth::user()->date_of_join}}</p>
                            <p>Is Present:
                            @if (Auth::user()->is_present == 1)
                                Present
                            @else
                                Absent
                            @endif
                            </p>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row d-flex justify-content-center mt-2 ">
            <div class="col-md-8">
                <div class="card p-3 border-0 shadow">
                    <h6 class="mb-3">Biometric Authentication</h6>
                   {{-- @foreach ($figureprint as $item)
                        a
                   @endforeach --}}
                    <form id="register-form">
                        <button id="fig"  type="submit" value="Register authenticator" class="p-2 border-0 rounded mx-2">
                            <i class="fas fa-fingerprint"></i>
                            <i class="fa-solid fa-circle-plus"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
      <!-- Registering authenticator -->
      <script>
        const register = event => {
            event.preventDefault()

            new WebAuthn().register()
              .then(function(response){
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'You are Created Biometric Successfully!',
                        showConfirmButton: false,
                        timer: 1500
                    })
              })
              .catch(function(error){
                Swal.fire({
                        position: 'top-end',
                        icon: 'warning',
                        title: 'You Already Exist Register!',
                        showConfirmButton: false,
                        timer: 1500
                    })
                // console.log(error);
              })
        }

        document.getElementById('register-form').addEventListener('submit', register)
    </script>
@endsection
