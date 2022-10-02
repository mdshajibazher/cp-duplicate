<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="ASOjne3KXoYfj3Bf24x8FUsRK920YOgbS7CcIRxa">
    <!-- Poppins Font -->
    <link href="{{ asset('assets/css/poppins-font.css') }}" rel="stylesheet"/>
    <title>Datewise Product Report</title>

    <!-- Bootstrap css -->

    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }

        .table {
            width: 100%;
            max-width: 100%;
            margin-bottom: 1rem;
            background-color: transparent;
            display: table;
        }

        .table tr {

        }

        .table tr td, .table tr th {
            vertical-align: bottom;
            border-bottom: 2px solid #dee2e6;
            padding: .3rem;

        }

        .align-middle {
            vertical-align: middle;
        }


    </style>

</head>
<body style="background: #fff;font-size: 12px;">
<div style="width: 50%;margin: 0 auto">
    <h2 style="text-align: center;font-family: Tahoma,sans-serif">Datewise Product Report</h2>
    @if($general_opt_value['inv_diff_invoice_heading'] == 1)
        <p style="font-weight: bold;text-align: center">{{$general_opt_value['inv_invoice_heading']}}</p>
        <p style="text-align: center;font-size: 11px">{{$general_opt_value['inv_invoice_address']}} <br> <b>Email
                :</b> {{$general_opt_value['inv_invoice_email']}} <br> <b>Phone
                :</b> {{$general_opt_value['inv_invoice_phone']}}</p>
    @else
        <p style="font-weight: bold;text-align: center">{{$CompanyInfo->company_name}}</p>
        <p style="text-align: center;font-size: 11px">{{$CompanyInfo->address}} <br> <b>Email
                :</b> {{$CompanyInfo->email}} <br> <b>Phone:</b> {{$CompanyInfo->phone}}</p>
    @endif

</div>


<p style="text-align: center;margin-bottom: 30px;font-weight: bold;width: 100%">
    From {{date("d-M-Y", strtotime($request->start) )}} To {{date("d-M-Y", strtotime($request->end) )}}</p>

<div class="statement_table" style="display: flex;justify-content: center">
    <table class="table">
        <tr style="background: #ddd">
            <td class="align-middle">Sl.</td>
            <td class="align-middle">Date</td>
            <td class="align-middle">Customer Name</td>
            <td class="align-middle">Product Name</td>
            <td class="align-middle">Unit Price</td>
            <td class="align-middle">Qty</td>
            <td class="align-middle">Type</td>
            <td class="align-middle">Amount</td>
        </tr>
        @php
            $total = 0;
            $totalSalesQty = 0;
            $totalReturnQty = 0;
        @endphp
        @foreach ($sorted_product_data as $key => $item)
            @php
                $price = $item->price;
                $qty = $item->qty;
                $subtotal = $price*$qty;
                $total = $total+$subtotal;
                 if(strtolower($item->type) === 'sales'){
                     $totalSalesQty = $totalSalesQty+$qty;
                 }else if(strtolower($item->type) === 'returns'){
                     $totalReturnQty = $totalReturnQty+$qty;
                 }
            @endphp

            <tr>
                <td class="align-middle">{{$key+1}}</td>
                <td class="align-middle">{{date('d/m/Y', strtotime($item->date))}}</td>
                <td class="align-middle">{{$item->customer_name}}</td>
                <td class="align-middle"><small>{{$item->product_name}} </small></td>
                <td class="align-middle">{{round($price)}}</td>
                <td class="align-middle">{{$qty}}</td>
                <td>{{$item->type}}</td>
                <td class="align-middle">{{$subtotal}}</td>
            </tr>

        @endforeach

    </table>
</div>

<div style="width: 100%;text-align: right">
    <h2>
        Total Amount: {{$total}}
    </h2>
    <h4> Total Sales Qty : {{$totalSalesQty}}</h4>
    <h4>Total Return Qty :{{$totalReturnQty}}</h4>
    <h4>
        Profitable Qty : {{ $totalSalesQty - $totalReturnQty}}
    </h4>

    <div>
        <p>In Words: {{convertNumberToWord($total)}}</p>
    </div>
</div>
</body>
</html>
