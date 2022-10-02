<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="ASOjne3KXoYfj3Bf24x8FUsRK920YOgbS7CcIRxa">
    <title>Sales Report</title>
    <!-- Bootstrap css -->
    <link href="{{asset('assets/css/bootstrap.css')}}" rel="stylesheet"/>
    <style>
        .table-bordered td, .table-bordered th {
            border: 1px solid #000;
        }

        .table thead th {
            border: 1px solid #000;
        }
    </style>

</head>
<body style="background: #fff;font-size: 12px;">
<div style="width: 50%;margin: 0 auto">
    <h5 style="text-align: center;font-family: Tahoma,sans-serif">Sales Report According To Date</h5>
    @if($general_opt_value['inv_diff_invoice_heading'] == 1)
        <p style="font-weight: bold;text-align: center">{{getSectionTitle($request->section)}}</p>
        <p style="text-align: center;font-size: 11px">{{$general_opt_value['inv_invoice_address']}} <br> <b>Email
                :</b> {{$general_opt_value['inv_invoice_email']}} <br> <b>Phone
                :</b> {{$general_opt_value['inv_invoice_phone']}}</p>
    @else
        <p style="font-weight: bold;text-align: center">{{$CompanyInfo->company_name}}</p>
        <p style="text-align: center;font-size: 11px">{{$CompanyInfo->address}} <br> <b>Email
                :</b> {{$CompanyInfo->email}} <br> <b>Phone:</b> {{$CompanyInfo->phone}}</p>
    @endif

</div>


<div class="statement_table table-responsive">
    <p style="text-align: center;margin-bottom: 10px;font-weight: bold">
        From {{date("d-M-Y", strtotime($request->start) )}} To {{date("d-M-Y", strtotime($request->end) )}}</p>
    <table class="table table-sm">
        <tr style="background: #dddddd">
            <th scope="col">Sales ID</th>
            <th scope="col">Date</th>
            <th scope="col">Customer</th>
            <th scope="col">Address</th>
            <th scope="col">Amount</th>
        </tr>
        @php
            $salessum = 0;
        @endphp
        @foreach($datewise_sorted_data as $key => $item)
            @php
                $salessum = $salessum + $item['amount']
            @endphp
            <tr>
                <td>#{{$item['id']}}</td>
                <td>{{$item['date']}}</td>
                <td>{{$item['customer']}}</td>
                <td style="width: 100px">{{$item['address']}}</td>
                <td><b>{{round($item['amount'])}}</b></td>
            </tr>
        @endforeach

    </table>
</div>
<div class="amount-box" style="width: 40%;margin-left: 60%">
    <table class="table table-sm">
        <tr>
            <th>Total Sales</th>
            <th>{{$salessum}}</th>
        </tr>
    </table>
</div>

</body>
</html>

















