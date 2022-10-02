<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="ASOjne3KXoYfj3Bf24x8FUsRK920YOgbS7CcIRxa">

    <title>Cash Report</title>

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
    <h5 style="text-align: center;font-family: Tahoma,sans-serif">Cash Report</h5>
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
<div class="statement_table">
    <p style="text-align: center;margin-bottom: 30px;font-weight: bold">
        From {{date("d-M-Y", strtotime($request->start) )}} To {{date("d-M-Y", strtotime($request->end) )}}</p>
    <table class="table table-sm">

        <tr style="background: #ddd">
            <td>Date</td>
            <td class="align-middle">Customer</td>
            <td class="align-middle">Address</td>
            <td class="align-middle">Amount</td>
            <td class="align-middle">Ref</td>
        </tr>
        @php
            $sum = 0;
        @endphp
        @foreach ($datewise_sorted_data as $item)
            @php
                $userinfo = DB::table('users')->where('id',$item['user_id'])->select('name','phone','address')->first();
                $sum = $sum+$item['amount'];

            @endphp
            <tr>
                <td class="align-middle">{{$item['date']}}</td>
                <td class="align-middle">{{ $userinfo->name}}</td>
                <td style="width: 80px" class="align-middle">{{ $userinfo->address}}</td>
                <td class="align-middle"><b>{{round($item['amount'])}}</b></td>
                <td class="align-middle">{{$item['reference']}}</td>
            </tr>
        @endforeach
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td><b>Total Amount:</b></td>
            <td><b>{{$sum}}</b></td>
        </tr>
    </table>
</div>
</body>
</html>
