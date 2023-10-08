<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Attendance</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">

    <link rel="stylesheet" href="{{ asset('bootstrap-pincode.css')}}">
</head>
<body>
    <div class="container-fluid">
        <div class="row vh-100 justify-content-center align-items-center align-content-center">
            <div class="col-md-6">
                <div class="card border-0 p-3 shadow">
                    <div class="card-header bg-transparent">
                        <h4>QR Code</h4>
                    </div>
                    <div class="card-body text-center">
                        <img class="my-2" style="height: 250px;" src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(100)->generate($hash_value)) !!} ">
                    </div>
                    <div class="card-footer bg-transparent">
                        <h4>Pin Code</h4>
                        <input type="text" name="mycode" id="pincode-input1">
                    </div>
                </div>
            </div>
        </div>
    </div>








    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
    <script src="{{ asset('bootstrap-pincode.js')}}"></script>
<script>
    $(document).ready(function(){

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('#pincode-input1').pincodeInput({inputs:6,complete:function(value, e, errorElement){
            $('.pincode-input-text').first().select().focus();

          //console.log("code entered: " + value);
          $.ajax({
             url:'/pincode',
             type:'get',
             data: {
                'value' : value,
             },
             success : function (re){
                if(re.status == "fail")
                {
                    Swal.fire({
                                icon: 'warning',
                                title: re.message,
                                showConfirmButton: false,
                                timer: 1500
                    })
                    }else{
                        Swal.fire({
                        icon: 'success',
                        title: re.message,
                        showConfirmButton: false,
                        timer: 1500
                    })
                }
            $(".pincode-input-container .pincode-input-text").val("");
            $('.pincode-input-text').first().select().focus();


            }
          })
          $('.pincode-input-text').first().select().focus();


          /*do some code checking here*/

          //$(errorElement).html("I'm sorry, but the code not correct");
        }});

    })
</script>
</body>
</html>
