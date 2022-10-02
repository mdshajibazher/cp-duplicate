<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">



    <title>Employeewise Performance Report</title>

    <!-- Bootstrap css -->
    <link href="{{asset('assets/css/bootstrap.css')}}" rel="stylesheet"/>
    <style>
      .table-bordered td, .table-bordered th{
        border: 1px solid #000;
      }
      .table thead th{
        border: 1px solid #000;
      }
    </style>

</head>
<body style="background: #fff;font-size: 12px;">
              <div style="width: 50%;margin: 0 auto">
                <h5 style="text-align: center"> <strong> Employeewise Performance Report </strong></h5>
                @if($general_opt_value['inv_diff_invoice_heading'] == 1)
                <p style="font-weight: bold;text-align: center">{{$general_opt_value['inv_invoice_heading']}}</p>
                <p  style="text-align: center;font-size: 11px">{{$general_opt_value['inv_invoice_address']}} <br> <b>Email :</b>  {{$general_opt_value['inv_invoice_email']}} <br> <b>Phone :</b>  {{$general_opt_value['inv_invoice_phone']}}</p>
                @else
                <p style="font-weight: bold;text-align: center">{{$CompanyInfo->company_name}}</p>
                <p style="text-align: center;font-size: 11px">{{$CompanyInfo->address}} <br> <b>Email :</b>  {{$CompanyInfo->email}} <br> <b>Phone:</b>  {{$CompanyInfo->phone}}</p>
                @endif

              </div>


                  <div class="statement_table">
                    <p style="text-align: center;margin-bottom: 30px;font-weight: bold">From {{date("d-M-Y", strtotime($request->start) )}} To {{date("d-M-Y", strtotime($request->end) )}}</p>





                        <h5>Employee Information</h5>
                        <table class="table">
                          <tr>
                            <td>Name</td>
                            <td>{{$employeeinfo->name}}</td>
                          </tr>

                          <tr>
                            <td>Phone</td>
                            <td>{{$employeeinfo->phone}}</td>
                          </tr>
                          <tr>
                            <td>Address</td>
                            <td>{{$employeeinfo->address}}</td>
                          </tr>
                          <tr>
                            <td>Assigned Customer/Distributor</td>
                            <td>@foreach ($customer_list as $item)
                                 <span class="badge badge-warning">{{$item->name}}</span>
                            @endforeach</td>
                          </tr>

                        </table>
                        <div class="mb-3">
                        <h5 class="text-center mb-3"><strong>Sales Performance from {{$from->format('d-m-Y')}} to {{$to->format('d-m-Y')}} </strong></h5>
                        @if(count($sales) > 0)
                        <table class="table">
                          <tr>
                            <td>sl</td>
                            <td>Date</td>
                            <td>customer</td>
                            <td>Amount</td>
                          </tr>

                          @php
                          $total_sales = 0;
                          @endphp
                          @foreach ($sales as $key => $item)
                          @php
                          $total_sales = $total_sales+$item->amount;
                          @endphp


                              <tr>
                                <td>{{$key+1}}</td>
                                <td>{{$item->sales_at->format('d-m-Y')}}</td>
                                <td>{{$item->user->name}}</td>
                                <td>{{$item->amount}}</td>
                              </tr>
                          @endforeach
                        </table>
                        <h5 class="text-center">Total Sales : {{$total_sales}}</h5>
                        @else

                        <p class="alert alert-danger">No Sales Found !!!</p>

                        @endif


                      <div class="mb-3">
                          <h5 class="text-center mb-3"> <strong> Cashes from {{$from->format('d-m-Y')}} to {{$to->format('d-m-Y')}} </strong> </h5>
                          @if(count($cashes) > 0)
                          <table class="table">
                            <tr>
                              <td>sl</td>
                              <td>Date</td>
                              <td>customer</td>
                              <td>Amount</td>
                            </tr>

                            @php
                            $total_cashes = 0;
                            @endphp
                            @foreach ($cashes as $key => $item)
                            @php
                            $total_cashes = $total_cashes+$item->amount;
                            @endphp
                                <tr>
                                  <td>{{$key+1}}</td>
                                  <td>{{$item->received_at->format('d-m-Y')}}</td>
                                  <td>{{$item->user->name}}</td>
                                  <td>{{$item->amount}}</td>
                                </tr>

                            @endforeach
                          </table>
                          <h5 class="text-center">Total Cashes : {{$total_cashes}}</h5>
                          @else
                          <p class="alert alert-danger">No Cashes Found !!!</p>
                          @endif
                        </div>

                        <div class="mb-3">
                          <h5 class="text-center mb-3"><strong> Product Returns from {{$from->format('d-m-Y')}} to {{$to->format('d-m-Y')}} </strong> </h5>
                          @if(count($product_returns) > 0)
                          <table class="table">
                            <tr>
                              <td>sl</td>
                              <td>Date</td>
                              <td>customer</td>
                              <td>Amount</td>
                            </tr>


                            @php
                            $total_returns = 0;
                            @endphp
                            @foreach ($product_returns as $key => $item)

                            @php
                            $total_returns = $total_returns+$item->amount;
                            @endphp
                                <tr>
                                  <td>{{$key+1}}</td>
                                  <td>{{$item->returned_at->format('d-m-Y')}}</td>
                                  <td>{{$item->user->name}}</td>
                                  <td>{{$item->amount}}</td>
                                </tr>
                            @endforeach
                          </table>

                          <h5 class="text-center">Total Cashes : {{$total_returns}}</h5>
                          @else
                          <p class="alert alert-danger">No Returns Found !!!</p>
                          @endif
                        </div>


                      </div>




                </div>


</body>
</html>
