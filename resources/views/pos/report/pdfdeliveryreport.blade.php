<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="ASOjne3KXoYfj3Bf24x8FUsRK920YOgbS7CcIRxa">

    <title>Delivery Report</title>

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
                <h5 style="text-align: center;font-family: Tahoma,sans-serif">Delivery Report</h5>
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
                    <table class="table table-sm">

                      <tr>
                        <th >Sales ID</th>
                        <th>Invoice Date</th>
                        <th>Customer Info</th>
                        <th>Delivery Status</th>
                        <th>Delivery Info</th>

                      </tr>

                      @foreach($datewise_sorted_data as $item)


                      <tr>
                        <td class="align-middle">#{{$item['id']}}</td>
                        <td class="align-middle">{{$item['date']}}</td>
                        <td class="align-middle">{{$item['customer']}} <br> <small>({{$item['address']}})</small>

                          </td>
                          <td class="align-middle">{!!FashiShippingStatus($item['status'])!!}</td>
                          <td class="align-middle" style="width: 250px">
                            @if($item['delivery_info'] == null)
                              <small>No Information Found</small>
                            @else
                            @php
                             $d_info =  $item['delivery_info'];
                            @endphp

                            <small>@if(isset($d_info->delivery_date)) Delivert Date: {{$d_info->delivery_date}}  @endif Delivery Mode:{!!delivereyMode($d_info->deliverymode)!!},Transportation Expense: {{$d_info->transportation_expense}}, @if($d_info->deliverymode === "courier") Courier/Transport Name:{{$d_info->courier_name}}, Booking Amount: {{$d_info->booking_amount}},CN Number: {{$d_info->cn_number}}  Delivered By: {{App\Admin::find($d_info->delivered_by)->name}}@endif </small>


                            @endif
                          </td>


                      </tr>
                      @endforeach

                  </table>
                </div>



</body>
</html>

















