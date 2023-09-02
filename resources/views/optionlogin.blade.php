<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
    <!-- Font Awesome -->
<link
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
rel="stylesheet"
/>
<!-- Google Fonts -->
<link
href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap"
rel="stylesheet"
/>
<!-- MDB -->
<link
href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.1/mdb.min.css"
rel="stylesheet"
/>
{{-- figureprint --}}
<script src="{{ Vite::asset('resources/js/vendor/webauthn/webauthn.js') }}"></script>

<link rel="stylesheet" href="{{asset('css/style.css')}}">
<style>
    .nav-pills .nav-link.active{
        background-color: #0D6EFD;
        color: white;
    }
    .btn{
        background-color: #0D6EFD;
    }


</style>
</head>
<body>
    <div class="container">
        <div class="row vh-100 justify-content-center align-items-center align-content-center">
            <div class="col-md-6">
                <div class="card p-5 shadow border-0">
                    <div class="card-body" style="line-height: 50px;">
                        <div class="text-center">
                            <img src="https://www.svgrepo.com/show/368289/ninja.svg"  alt="" width="100px" height="100px">
                        </div>
                        <div class="mt-3">
                            <ul class="nav nav-pills nav-justified mb-3" id="ex1" role="tablist">
                                <li class="nav-item" role="presentation">
                                <a
                                    class="nav-link active "
                                    id="ex1-tab-1"
                                    data-mdb-toggle="pill"
                                    href="#ex1-pills-1"
                                    role="tab"
                                    aria-controls="ex1-pills-1"
                                    aria-selected="true"
                                    >Password</a
                                >
                                </li>
                                <li class="nav-item" role="presentation">
                                <a
                                    class="nav-link"
                                    id="ex1-tab-2"
                                    data-mdb-toggle="pill"
                                    href="#ex1-pills-2"
                                    role="tab"
                                    aria-controls="ex1-pills-2"
                                    aria-selected="false"
                                    >Bio Metric</a
                                >
                                </li>
                            </ul>
                            <div class="tab-content" id="ex1-content">
                                <div
                                class="tab-pane fade show active"
                                id="ex1-pills-1"
                                role="tabpanel"
                                aria-labelledby="ex1-tab-1"
                                >
                                <form action="{{ route('login') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="email" value="{{$email}}">
                                    <div class="form-group">
                                        <label for="">Password</label>
                                        <input type="password" class="form-control" placeholder="Enter Password ... " name="password">
                                    </div>
                                    <button class="btn btn-primary w-100">Login</button>
                                </form>
                                </div>
                                <div class="tab-pane fade" id="ex1-pills-2" role="tabpanel" aria-labelledby="ex1-tab-2">
                                    <form id="login-form">
                                        <input id="email" type="hidden" value="{{$email}}" >

                                        {{-- <input id="email" type="hidden" name="email" value="{{$email}}"> --}}
                                        <form id="register-form">
                                            <button id="fig"  type="submit" value="Log in with your devicer" class="p-2 border-0 rounded mx-2">
                                                <i class="fas fa-fingerprint"></i>
                                            </button>
                                        </form>
                                    </form>
                                </div>
                          </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

  <!-- Tabs navs -->



<!-- MDB -->
<script
  type="text/javascript"
  src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.1/mdb.min.js"
></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

      <!-- Login users -->
<script>
             const login = event => {
            event.preventDefault()

            new WebAuthn().login({
            email: document.getElementById('email').value,
            }).then(function(response){
                window.location.replace('/dashboard');
            })
            .catch(function(error){
                Swal.fire({
                        position: 'center',
                        icon: 'warning',
                        title: 'You are not Register ',
                        showConfirmButton: false,
                        timer: 1500
                })
            })
            }

            document.getElementById('login-form').addEventListener('submit', login)
</script>
</body>
</html>
