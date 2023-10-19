@extends('layouts.app')
@section('title','Payroll')
@section('content')
    <div class="container-fluid">
        <div class="row d-flex justify-content-center mt-5">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">
                       <div class="row text-center">
                        <div class="col-3">
                            <input type="text" class="form-control e_name" placeholder="Employee Name" name="employee_name">
                        </div>
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
                        <div class="payroll_table"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('script')
<script>

        $(document).ready(function(){
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
            payrolloverviewtable();
            function payrolloverviewtable(){
                var months=$('.month').val();
                var years=$('.year').val();
                var employee=$('.e_name').val();
                $.ajax({
                    url:`/payroll_table?months=${months}&years=${years}&employee=${employee}`,
                    type:'get',
                    success:function(res){
                        $('.payroll_table').html(res)
                    }
                })
            }
           $('#select').on("click",function(event){
                event.preventDefault();
                payrolloverviewtable();
           })

        })



</script>
@endsection

