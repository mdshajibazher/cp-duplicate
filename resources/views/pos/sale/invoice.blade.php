<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="ASOjne3KXoYfj3Bf24x8FUsRK920YOgbS7CcIRxa">

    <title>Sales Invoice</title>


    <style>
        table {
            margin-bottom: .1rem;
            width: 100%;
            background-color: transparent;
            border-collapse: collapse;
        }

        .main-table, .main-table td, .main-table th {
            border: 1px solid black;
        }

        hr {
            margin: 0;
            border-top: 1px solid #000;
        }

        .summery-table tr {
            text-align: left;
        }

        .summery-table tr td {
            text-align: left;
        }

    </style>

</head>
<body style="background: #fff;font-size: 12px;font-family: Tahoma, sans-serif">
<h4 style="text-align: center;margin-bottom: 25px;font-weight: bold">SALES INVOICE</h4>
<div style="overflow: auto">
    <div style="width: 39%;display: inline-block;">
        <p style="font-size: 11px; margin-bottom: 25px;">Print Date: {{date("d-M-Y g:i a", strtotime(now()))}}</p>
        <table>
            <tr>
                <td><b>Customer : </b></td>
                <td>{{$current_user->name}}</td>
            </tr>
            @if($current_user->inventory_email)
                <tr>
                    <td><b>Email : </b></td>
                    <td>{{$current_user->inventory_email}}</td>
                </tr>
            @endif
            <tr>
                <td><b>Phone : </b></td>
                <td>{{$current_user->phone}}</td>
            </tr>
            <tr>
                <td><b>Address : </b></td>
                <td>{{$current_user->address}}</td>
            </tr>
        </table>

    </div>
    <div style="width: 20%;display: inline-block;margin-top: 15px">
        @php
            $url = "https://api.qrserver.com/v1/create-qr-code/?data=Customer: ".$current_user->name." Phone: ".$current_user->phone." Amount: ".$sale->amount."&size=130x130";
        @endphp
        @if($url)
            <img src="{{$url}}" alt="">
        @endif


    </div>
    <div style="width: 40%;display: inline-block;">
        @if($general_opt_value['inv_diff_invoice_heading'] == 1)

            <p style="font-weight: bold">{{$general_opt_value['inv_invoice_heading']}}</p>
            <p>{{$general_opt_value['inv_invoice_address']}} <br> <b>Email
                    :</b> {{$general_opt_value['inv_invoice_email']}} <br> <b>Phone
                    :</b> {{$general_opt_value['inv_invoice_phone']}}</p>

        @else
            <p style="font-weight: bold">{{$CompanyInfo->company_name}}</p>
            <p>{{$CompanyInfo->address}} <br> <b>Email :</b> {{$CompanyInfo->email}} <br>
                <b>Phone:</b> {{$CompanyInfo->phone}}</p>

        @endif


    </div>
    <p><b>Order Date: {{$sale->sales_at->format('d-M-Y')}}</b> - <b>Order ID: # {{$sale->id}}</b></p>
</div>


<table class="main-table">

    <tr style="background: #ddd;">
        <th>Sl</th>
        <th>Product</th>
        <th>Size</th>
        <th>Qty</th>
        <th>Price</th>
        <th>Total</th>
    </tr>

    @php
        $i=1;
        $sum =0;
    @endphp

    @foreach ($sale->product as $sales_info)

        <tr>
            <td>{{$i++}}</td>
            <td>{{$sales_info->product_name}} @if($sales_info->pivot->free > 0) + {{$sales_info->pivot->free}} Pc
                Free @endif</td>
            <td>{{$sales_info->size->name}}</td>
            <td>{{$sales_info->pivot->qty}}</td>
            <td>{{$sales_info->pivot->price}}</td>
            <td>{{($sales_info->pivot->price)*($sales_info->pivot->qty)}}</td>
        </tr>

        @php
            $sum = ($sum) +($sales_info->pivot->price)*($sales_info->pivot->qty);
        @endphp
    @endforeach

</table>


<div style="width:40%;margin-left: 60%">


    <table class="summery-table">
        <tr>
            <th>Subtotal:</th>
            <td>{{$sum}}</td>
        </tr>
        <tr>
            <th>Discount</th>
            <td>{{$sale->discount}}</td>
        </tr>
        <tr>
            <th>Carrying cost:</th>
            <td>{{$sale->carrying_and_loading}}</td>
        </tr>
        <tr>
            <th>Total:</th>
            <td>{{round(($sum+$sale->carrying_and_loading)-($sale->discount))}}</td>
        </tr>
    </table>


</div>
<div style="margin-top: 50px;">
    <div
        style="width: 33%;display: inline-block;text-align:center;@if($general_opt_value['auto_signature_inv'] == 1) margin-top: 23px @endif">
        <p>{{$sale->provided_by}}</p>
        <hr>
        <p style="text-align:center">Service Provided By </p>

    </div>
    <div style="width: 33%;display: inline-block;text-align:center;margin-bottom: -30px @if($general_opt_value['auto_signature_inv'] == 1) margin-top: 23px @endif">
        <p></p>
        <hr>
        <p style="text-align:center">Received By </p>
    </div>
    <div style="width: 33%;display: inline-block;text-align:center">
        @if($general_opt_value['auto_signature_inv'] == 1)
            @if($signature)
                <img style="height: 50px" src="{{asset('uploads/admin/signature/'.$signature->signature)}}"
                     alt="">
                <p>{{$signature->name}}</p>
            @else
                <p>(pending)</p>
            @endif

        @else
            <br><br>
        @endif
        <hr>
        <p style="text-align:center">Authorized By </p>
    </div>
</div>


</body>
</html>































