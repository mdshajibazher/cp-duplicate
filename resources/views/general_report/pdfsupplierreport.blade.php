<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="ASOjne3KXoYfj3Bf24x8FUsRK920YOgbS7CcIRxa">

    <title>Supplier Due Report</title>

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
                <h5 style="text-align: center;font-family: Tahoma,sans-serif">Supplier Due Report/h5>
                @if($general_opt_value['inv_diff_invoice_heading'] == 1)
                <p style="font-weight: bold;text-align: center">{{$general_opt_value['inv_invoice_heading']}}</p>
                <p  style="text-align: center;font-size: 11px">{{$general_opt_value['inv_invoice_address']}} <br> <b>Email :</b>  {{$general_opt_value['inv_invoice_email']}} <br> <b>Phone :</b>  {{$general_opt_value['inv_invoice_phone']}}</p>
                @else
                <p style="font-weight: bold;text-align: center">{{$CompanyInfo->company_name}}</p>
                <p style="text-align: center;font-size: 11px">{{$CompanyInfo->address}} <br> <b>Email :</b>  {{$CompanyInfo->email}} <br> <b>Phone:</b>  {{$CompanyInfo->phone}}</p>
                @endif

                </div>

                    <div class="statement_table table-responsive">
                    <p style="text-align: center;margin-bottom: 10px;font-weight: bold">From {{date("d-M-Y", strtotime($request->start) )}} To {{date("d-M-Y", strtotime($request->end) )}}</p>
                    <table class="table table-sm table-bordered">
                        <thead>
                            <tr>
                            <th scope="col">Date</th>
                            <th scope="col">Bill</th>
                            <th scope="col">Particular</th>
                            <th scope="col">Debit</th>
                            <th scope="col">Credit</th>
                            <th scope="col">Reference</th>
                            <th scope="col">Balance</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                            <td>{{date("d-m-Y", strtotime($request->start))}}</td>
                            <td>N/A</td>
                            <td>Balance</td>
                            <td></td>
                            <td></td>
                            <td></td>
                          <td>{{$balance}}</td>
                          </tr>
                          @php
                            $c_due = $balance;
                            $sum = 0;
                            $paymentamount = 0;
                            $purchaseamount = 0;
                            $prevdueamount = 0;
                          @endphp
                          @foreach ($datewise_sorted_data as $item)
                          @php
                            if($item['particular'] === 'payment'){
                              $paymentamount = $paymentamount + $item['credit'];
                            }
                            if($item['particular'] === 'prevdue'){
                              $prevdueamount = $prevdueamount + $item['debit'];
                            }
                            if($item['particular'] === 'purchase'){
                              $purchaseamount = $purchaseamount + $item['debit'];
                            }
                            $sum = $sum + ($item['debit'] - $item['credit']);
                          @endphp
                          <tr>
                            <td>{{$item['date']}}</td>
                            <td>{{$item['id']}}</td>
                            <td>{{$item['particular']}}</td>
                            <td>{{$item['debit']}}</td>
                            <td>{{$item['credit']}}</td>
                            <td><small>{{$item['reference']}}</small></td>
                          <td>{{ $c_due =  $sum+$balance}}</td>
                          </tr>

                          @endforeach

                        </tbody>
                      </table>
                </div>
                <div class="amount-box" style="width: 40%;margin-left: 60%">
                  <table class="table table-sm">
                    <tr>
                      <td>Previous Balance: </td>
                    <td>{{$balance}}</td>
                    </tr>
                    <tr>
                      <td>Net Purchase: </td>
                    <td>{{$purchaseamount}}</td>
                    </tr>
                    <tr>
                      <td>Net Previous Due: </td>
                      <td>{{$prevdueamount}}</td>
                    </tr>
                    <tr>
                      <td>Net Payment: </td>
                      <td>{{$paymentamount}}</td>
                    </tr>

                    <tr>
                      <td>Current Due: </td>
                    <td style="font-weight: bold">@if($c_due > 0) <span class="text-danger">{{$c_due}}</span> @else <span class="text-success">{{$c_due}}</span>  @endif</td>
                    </tr>

                  </table>
                </div>


</body>
</html>

















