<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
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
                        <form action="{{ route('login')}}" method="post">
                            @csrf
                            <div class="form-group mb-2">
                                <label for="">Email</label>
                                <input type="email" name="email" class="form-control" placeholder="Enter Email ....">
                            </div>
                            <div class="form-group mb-2">
                                <label for="">Password</label>
                                <input type="password" name="password" class="form-control" placeholder="Enter Password ....">
                            </div>
                            <button class="btn btn-primary">Login</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
</body>
</html>
