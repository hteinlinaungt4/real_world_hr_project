@extends('layouts.app')
@section('title','Attendance')
@section('content')
    <div class="container-fluid">
        <div class="row d-flex justify-content-center mt-5">
            <div class="col-md-8">
                <div class="card text-center">
                    <div class="card-body">
                        <img src="{{asset('storage/scan.png')}}" style="width:500px;" alt="">
                        <p class=" text-muted mb-3 fs-4">Please Scan Attendance QR</p>

                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-primary px-3 w-50" data-bs-toggle="modal" data-bs-target="#exampleModal">
                            Scan
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center my-3">
            <div class="col-md-10">
                <div class="card mb-5">
                    <div class="card-header">
                       <div class="row text-center justify-content-around">
                        <div class="col-3">
                            <select name="months" id="months" class="month w-100">
                                <option value="">Select Months</option>
                                <option value="01" @if(now()->format('m') == '01') selected @endif>JAN</option>
                                <option value="02" @if(now()->format('m') == '02') selected @endif>FEB</option>
                                <option value="03" @if(now()->format('m') == '03') selected @endif>MAR</option>
                                <option value="04" @if(now()->format('m') == '04') selected @endif>APR</option>
                                <option value="05" @if(now()->format('m') == '05') selected @endif>MAY</option>
                                <option value="06" @if(now()->format('m') == '06') selected @endif>JUN</option>
                                <option value="07" @if(now()->format('m') == '07') selected @endif>JUL</option>
                                <option value="08" @if(now()->format('m') == '08') selected @endif>AUG</option>
                                <option value="09" @if(now()->format('m') == '09') selected @endif>SEP</option>
                                <option value="10" @if(now()->format('m') == '10') selected @endif>OCT</option>
                                <option value="11" @if(now()->format('m') == '11') selected @endif>NOV</option>
                                <option value="12" @if(now()->format('m') == '12') selected @endif>DEC</option>
                            </select>
                        </div>
                        <div class="col-3">
                            <select name="years" id="years" class="year w-100"  >
                                <option value="">--Choose Year--</option>
                                    @for ($i=0;$i<5;$i++)
                                        <option value="{{now()->subYears($i)->format("Y")}}" @if(now()->format('Y') == now()->subYears($i)->format("Y")) selected @endif>{{ now()->subYears($i)->format("Y")}}</option>
                                    @endfor
                            </select>
                        </div>
                        <div class="col-3">
                            <button class="btn btn-outline-primary w-100" id="select"><i class="fa-solid fa-magnifying-glass mx-3"></i> Search</button>
                        </div>
                       </div>
                    </div>
                    <div class="card-body">
                        <div class="over_view_table"></div>
                    </div>
                </div>
                <table class="table table-bordered text-center w-100 display nowrap" id="usertable">
                    <thead>
                        <th>Employee_Name</th>
                        <th>Date</th>
                        <th>Checkin_time</th>
                        <th>Checkout_time</th>
                    </thead>
                </table>
            </div>
        </div>
    </div>
     <!-- Modal -->
  <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Attendance</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <video class="w-100" id="video"></video>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
@endsection
@section('script')
<script src="{{ asset('scan/qr-scanner.umd.min.js')}}"></script>
<script>
        $(document).ready(function(){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            //table overview
            $('#months').select2( {
                placeholder: "Select Months",
                theme: 'bootstrap-5',
                allowClear: true,
            } );
            $('#years').select2( {
                placeholder: "Select Years",
                theme: 'bootstrap-5',
                allowClear: true,
            } );
             //datatable checkincheckout
             var table=$('#usertable').DataTable({
                mark:true,
                responsive: true,
                processing: true,
                serverSide: true,
                ajax: 'ssd/myattendance',
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
                ],
                columnDefs: [{
                    orderable: false,
                    targets: 'nosort'
                },
            ],
            });
            attendanceoverviewtable();
            function attendanceoverviewtable(){
                var months=$('.month').val();
                var years=$('.year').val();
                $.ajax({
                    url:`/myattendance_overview_table?months=${months}&years=${years}`,
                    type:'get',
                    success:function(res){
                        $('.over_view_table').html(res)
                    }
                })
                table.ajax.url(`ssd/myattendance?months=${months}&years=${years}`).load();
            }
           $('#select').on("click",function(event){
                event.preventDefault();
                attendanceoverviewtable();
           })






            //datatable
            var videoElem = document.getElementById('video');
            const qrScanner = new QrScanner(videoElem,function(result){
                if(result){
                    qrScanner.stop();
                    $('#exampleModal').modal('hide');
                    $.ajax({
                        url:'store/attendance-scan',
                        type:'post',
                        data: {
                            'value' : result,
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
                        }
                    })


                }
            }
            );
            const myModalEl = document.getElementById('exampleModal')
                myModalEl.addEventListener('hidden.bs.modal', event => {
                    qrScanner.stop();
            });
            const myModalE = document.getElementById('exampleModal')
                myModalE.addEventListener('show.bs.modal', event => {
                    qrScanner.start();
            });
        })



</script>
@endsection

