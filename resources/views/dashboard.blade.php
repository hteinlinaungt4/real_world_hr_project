@extends('layouts.app')
@section('title','Dashboard')
@section('content')
    <div class="container-fluid">
        <div class="row d-flex justify-content-center mt-5">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h1 class="fs-3">Dashboard</h1>
                    </div>
                    <div class="card-body">
                        <form id="register-form">
                            <button type="submit" value="Register authenticator">
                        </form>
                    </div>
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
              .then(response => alert('Registration successful!'))
              .catch(error => console.log(error))
        }

        document.getElementById('register-form').addEventListener('submit', register)
    </script>
@endsection
