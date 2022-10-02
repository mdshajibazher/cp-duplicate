<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="ASOjne3KXoYfj3Bf24x8FUsRK920YOgbS7CcIRxa">

    <title>Money Recipt</title>

    <style>

        .table-bordered td, .table-bordered th {
            border: 1px solid #000;
        }

        .table-xs td, .table-xs th {
            padding: 0.2rem;
        }
    </style>

</head>
<body style="background: #fff;font-size: 12px;font-family: Tahoma, sans-serif">

<div>
    <h3 style="text-align: left;font-weight: bold;overflow: hidden;margin-bottom: 20px">MONEY RECIPT</h3>

    <div style="overflow: auto">
        <div style="width: 35%;display: inline-block">
            @if($general_opt_value['inv_diff_invoice_heading'] == 1)
                <img width="100px"
                     src="{{asset('uploads/logo/invoicelogo/'.$general_opt_value['inv_invoice_logo'])}}" alt="">
                <p style="font-weight: bold;margin-bottom: 8px;margin-top: 0px">{{$general_opt_value['inv_invoice_heading']}}</p>
                <small style="font-size: 8px">{{$general_opt_value['inv_invoice_address']}} <b>Email
                        :</b> {{$general_opt_value['inv_invoice_email']}}</small>

            @else
                <div style="margin-top: 30px">
                    <img width="100px" src="{{asset('uploads/logo/cropped/'.$CompanyInfo->logo)}}" alt="">
                    <p style="font-weight: bold">{{$CompanyInfo->company_name}}</p>
                    <p>{{$CompanyInfo->address}} <br> <b>Email :</b> {{$CompanyInfo->email}} <br>
                        <b>Phone:</b> {{$CompanyInfo->phone}}</p>
                </div>
            @endif

        </div>
        <div style="width: 32%;display: inline-block">
            <h5>CUSTOMER DEATILS</h5>
            <p>{{$cashData->user->name}}</p>
            @if(!empty($cashData->user->inventory_email))
                <p>{{$cashData->user->inventory_email}}</p>
            @endif
            <p>{{$cashData->user->phone}}</p>
            <p>{{$cashData->user->address}}</p>
        </div>
        <div style="width: 32%;display: inline-block">
            <div>
                <h5 style="margin-bottom: 5px">PAID AMOUNT:</h5>
                <h2> {{$cashData->amount}}</h2>
                <small>In words: {{convertNumberToWord($cashData->amount)}} only </small><br>
                <small>Reference: {{$cashData->reference}} </small> <br>
                <small>Posting Date: {{$cashData->received_at->format('d-M-Y')}} </small> <br>
                <small>Printed At: {{date("d-M-Y g:i a", strtotime(now()))}}</small>
            </div>

        </div>
        <div style="margin-top: 30px;">
            <div style="width: 33%;display: inline-block">
                <h4 style="text-align: center">{{\App\Admin::findOrFail($cashData->approved_by)->name}}</h4>
                <hr>
                <p style="text-align:center">Authorized signature</p>
            </div>
        </div>

    </div>


</body>
</html>































