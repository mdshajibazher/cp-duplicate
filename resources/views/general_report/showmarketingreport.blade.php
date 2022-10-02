<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="ASOjne3KXoYfj3Bf24x8FUsRK920YOgbS7CcIRxa">

    <title>ecommerce</title>

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
                <h5 class="text-center">Marketing Sales Report</h5>
                @if($general_opt_value['inv_diff_invoice_heading'] == 1)
                <p style="font-weight: bold;text-align: center">{{$general_opt_value['inv_invoice_heading']}}</p>
                <p  style="text-align: center;font-size: 11px">{{$general_opt_value['inv_invoice_address']}} <br> <b>Email :</b>  {{$general_opt_value['inv_invoice_email']}}</p>
                @else
                <p style="font-weight: bold;text-align: center">{{$CompanyInfo->company_name}}</p>
                <p style="text-align: center;font-size: 11px">{{$CompanyInfo->address}} <br> <b>Email :</b>  {{$CompanyInfo->email}} <br> <b>Phone:</b>  {{$CompanyInfo->phone}}</p>
                @endif

              </div>


                      <div class="customer-table" style="width: 60%;">
                        <p>Print Date: {{date("d-M-Y g:i a", strtotime(now()))}}</p>
                        <table class="table table-sm table-borderless">
                          <tr>
                            <td>Sales Officer Name : </td>
                            <td>{{$employee->name}}</td>
                          </tr>
                          <tr>
                            <td>Email : </td>
                            <td>{{$employee->email}}</td>
                          </tr>
                          <tr>
                            <td>Phone : </td>
                            <td>{{$employee->phone}}</td>
                          </tr>
                          <tr>
                            <td>Address : </td>
                            <td>{{$employee->address}}</td>
                          </tr>
                        </table>
                      </div>



                  <div class="statement_table table-responsive">
                    <p style="text-align: center;margin-bottom: 10px;font-weight: bold">From {{date("d-M-Y", strtotime($request->start) )}} To {{date("d-M-Y", strtotime($request->end) )}}</p>
                  <table class="table  table-bordered table-sm">
                    <tbody>
                      <tr style="background: #dddddd">
                        <th scope="col">Date</th>
                        <th scope="col">Order</th>
                        <th scope="col">Delivery</th>
                        <th scope="col">Market</th>
                        <th scope="col">Comment & Productinfo</th>
                      </tr>


                      @php
                      $ordersum = 0;
                      $deliverysum = 0;
                      @endphp
                      @foreach($marketingreport as $report)
                      @php
                      $ordersum = $ordersum+$report->order;
                      $deliverysum = $deliverysum+$report->delivery;
                      @endphp
                      <tr>
                        <td class="align-middle">{{date("d-m-Y", strtotime($report->at))}}</td>
                          <td class="align-middle">{{$report->order}}</td>
                          <td class="align-middle">{{$report->delivery}}</td>
                          <td class="align-middle">{{$report->market}}</td>
                          <td class="align-middle">
                           <b>Comment: {{$report->comment}}</b><br><br>
                            @if($report->productinfo != null)

                              <table class="table table-sm">
                                <tr>
                                  <th>Product Name</th>
                                  <th>Qty</th>
                                </tr>
                                @php
                                $productinfo = json_decode($report->productinfo,true);
                                $productinfo = json_decode($productinfo);

                                @endphp
                                @foreach($productinfo as $pd)
                                <tr>
                                  <td>{{$pd->o_name}}</td>
                                  <td>{{$pd->qty}}</td>
                                </tr>
                                @endforeach
                              </table>
                              @else
                              <b>(No Product Info Found)</b>
                            @endif
                          </td>
                        </tr>
                        @endforeach



                    </tbody>
                  </table>
                </div>
                <div class="amount-box" style="width: 40%;margin-left: 60%">
                    <table class="table sm">
                      <tr>
                        <th>Total Order</th>
                        <th>{{$ordersum}}</th>
                      </tr>
                      <tr>
                        <th>Total Delivery</th>
                        <th>{{$deliverysum}}</th>
                      </tr>
                    </table>
                </div>




</body>
</html>

















