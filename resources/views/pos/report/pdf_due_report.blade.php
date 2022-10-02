<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="ASOjne3KXoYfj3Bf24x8FUsRK920YOgbS7CcIRxa">

    <title>Due Report</title>

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

    <h5 style="text-transform: uppercase;text-align: center">Customer Due Report </h5>
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

    <table class="table table-bordered table-sm">

        <tr style="background: #ddd">
            <td class="align-middle">Name</td>
            <td class="align-middle">Address</td>
            <td class="align-middle">Prev. Bal</td>
            <td class="align-middle">Sales</td>
            <td class="align-middle">Receive</td>
            <td class="align-middle">Return</td>
            <td class="align-middle">Due</td>
        </tr>
        @php
            $total_sales = 0;
            $total_cash = 0;
            $total_return = 0;
            $total_p_due = 0;
        @endphp

        @foreach ($due_report as $item)
            @php
                $prev_balance = $item['prev_balance'];
                $p_due = $item['prevdues'];
                $sales = $item['sales'];
                $cash = $item['cashes'];
                $sreturn = $item['returns'];

                $total_sales = $total_sales+ $sales;
                $total_cash = $total_cash+$cash;
                $total_return = $total_return+$sreturn;
                $total_p_due = $total_p_due+$p_due;

                $c_due = ($prev_balance+$sales+$p_due)-($cash+$sreturn);

            @endphp

            <tr>
                <td class="align-middle">{{$item['customer']}}</td>
                <td class="align-middle">{{$item['address']}}</td>
                <td class="align-middle">{{round($prev_balance + $p_due) }}</td>
                <td class="align-middle">{{round($sales)}}</td>
                <td class="align-middle">{{round($cash)}}</td>
                <td class="align-middle">{{round($sreturn)}}</td>
                <td class="align-middle">{{round($c_due)}}</td>
            </tr>
        @endforeach


    </table>

</div>
<div class="amount-box" style="width: 40%;margin-left: 60%">
    <table class="table table-sm">
        <tr>
            <td>Total Customer</td>
            <td>{{count($due_report)}}</td>
        </tr>
        <tr>
            <td>Total Sales</td>
            <td>{{ $total_sales}}</td>
        </tr>
        <tr>
            <td>Total Cash</td>
            <td>{{ $total_cash}}</td>
        </tr>
        <tr>
            <td>Total Return</td>
            <td>{{ $total_return}}</td>
        </tr>
    </table>
</div>


</body>
</html>

















