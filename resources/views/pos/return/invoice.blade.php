<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="ASOjne3KXoYfj3Bf24x8FUsRK920YOgbS7CcIRxa">

    <title>Return Invoice</title>

    <!-- Bootstrap css -->
    <link href="{{asset('assets/css/bootstrap.css')}}" rel="stylesheet"/>
    <style>
      .table{
        margin-bottom: .2rem
      }
      .table-bordered td, .table-bordered th{
        border: 1px solid #000;
      }
      .table thead th{
        border: 1px solid #000;
      }
      hr{
        margin: 0;
        border-top: 1px solid #000;
      }
      .table-xs td, .table-xs th{
        padding: 0.2rem;
      }
    </style>

</head>
<body style="background: #fff;font-size: 12px;font-family: Tahoma, sans-serif">
        <h6 style="text-align: center;margin-bottom: 25px;font-weight: bold">RETURN INVOICE</h6>
      <div style="overflow: auto">
      <div style="width: 59%;display: inline-block;">
      <p style="font-size: 11px; margin-bottom: 25px;">Print Date: {{date("d-M-Y g:i a", strtotime(now()))}}</p>
      <table>
          <tr>
          <td><b>Customer Name : </b></td>
          <td>{{$current_user->name}}</td>
          </tr>
          <tr>
          <td><b>Email : </b></td>
          <td>{{$current_user->inventory_email}}</td>
          </tr>
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
      <div style="width: 40%;display: inline-block;">
        @if($general_opt_value['inv_diff_invoice_heading'] == 1)
        <p style="font-weight: bold">{{$general_opt_value['inv_invoice_heading']}}</p>
        <p>{{$general_opt_value['inv_invoice_address']}} <br> <b>Email :</b>  {{$general_opt_value['inv_invoice_email']}} <br> <b>Phone :</b>  {{$general_opt_value['inv_invoice_phone']}}</p>
        @else
        <p style="font-weight: bold">{{$CompanyInfo->company_name}}</p>
        <p>{{$CompanyInfo->address}} <br> <b>Email :</b>  {{$CompanyInfo->email}} <br> <b>Phone:</b>  {{$CompanyInfo->phone}}</p>
        @endif



      </div>
    <p><b>Return Date: {{$returnDetails->returned_at->format('d-M-Y')}}</b> - <b>Return ID: # {{$returnDetails->id}}</b></p>
      </div>





        <table class="table table-xs table-bordered">
          <tr style="background: #ddd;">
            <th>Sl</th>
            <th>Product</th>
            <th>Qty</th>
            <th>Price</th>
            <th>Total</th>
          </tr>

            @php
            $i=1;
            $sum =0;
            @endphp
            @foreach ($returnDetails->product as $return_info)

            <tr>
              <td>{{$i++}}</td>
              <td>{{$return_info->product_name}}</td>
              <td>{{$return_info->pivot->qty}}</td>
              <td>{{$return_info->pivot->price}}</td>
              <td>{{($return_info->pivot->price)*($return_info->pivot->qty)}}</td>
            </tr>

            @php
            $sum = ($sum) +($return_info->pivot->price)*($return_info->pivot->qty);
            @endphp
            @endforeach



        </table>



    <div style="width:40%;margin-left: 60%">


    <table class="table table-xs table-bordered" >
      <tr>
        <th>Subtotal:</th>
      <td>{{$sum}}</td>
      </tr>
      <tr>
        <th>Discount</th>
      <td>{{$returnDetails->discount}}</td>
      </tr>
      <tr>
        <th>Carrying & Loading:</th>
      <td>{{$returnDetails->carrying_and_loading}}</td>
      </tr>
      <tr>
        <th>Total:</th>
        <td>{{round(($sum+$returnDetails->carrying_and_loading)-($returnDetails->discount))}}</td>
      </tr>
    </table>


  </div>
  <div style="margin-top: 50px;">
    <div style="width: 33.33%;display: inline-block;text-align:center;@if($general_opt_value['auto_signature_inv'] == 1) margin-top: 23px @endif">
    <p>{{$returnDetails->returned_by}}</p>
      <hr>
      <p style="text-align:center">Service Provided By </p>

  </div>
  <div style="width: 33.33%;display: inline-block;text-align:center;@if($general_opt_value['auto_signature_inv'] == 1) margin-top: 23px @endif">
    <p></p>
    <hr>
    <p style="text-align:center">Received By </p>
  </div>
  <div style="width: 33.33%;display: inline-block;text-align:center">
    @if($general_opt_value['auto_signature_inv'] == 1)
    @if($signature)
  <img style="height: 50px" src="{{asset('uploads/admin/signature/'.$signature->signature)}}" alt="">
  <p>{{$signature->name}}</p>
    @else
    <br><br>
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































