<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="ASOjne3KXoYfj3Bf24x8FUsRK920YOgbS7CcIRxa">

    <title>Product Export</title>

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
                <h5 style="text-align: center;font-family: Tahoma,sans-serif">Price List</h5>
                @if($general_opt_value['inv_diff_invoice_heading'] == 1)
                <p style="font-weight: bold;text-align: center">{{$general_opt_value['inv_invoice_heading']}}</p>
                <p  style="text-align: center;font-size: 11px">{{$general_opt_value['inv_invoice_address']}} <br> <b>Email :</b>  {{$general_opt_value['inv_invoice_email']}} <br> <b>Phone :</b>  {{$general_opt_value['inv_invoice_phone']}}</p>
                @else
                <p style="font-weight: bold;text-align: center">{{$CompanyInfo->company_name}}</p>
                <p style="text-align: center;font-size: 11px">{{$CompanyInfo->address}} <br> <b>Email :</b>  {{$CompanyInfo->email}} <br> <b>Phone:</b>  {{$CompanyInfo->phone}}</p>
                @endif

              </div>

                  <div class="statement_table">
                    <table class="table table-sm table-bordered">
                        <thead>
                          <tr>
                            <th scope="col">#</th>
                            <th scope="col">Product_name</th>
                            <th scope="col">Size</th>
                            <th scope="col">Ecommerce Price</th>
                            <th scope="col">Trade Price</th>
                          </tr>
                        </thead>
                        <tbody>
                          @php
                            $i=1;
                          @endphp
                          @foreach ($products as $item)

                          <tr>
                          <td class="align-middle">{{$i++}}</td>
                            <td class="align-middle">{{$item->product_name}}</td>
                            <td class="align-middle">{{$item->size->name}}</td>
                            <td class="align-middle">{{$item->current_price ? $item->current_price : 0}}</td>
                            <td class="align-middle">{{$item->tp}}</td>
                          </tr>
                          @endforeach
                        </tbody>
                      </table>
                </div>
</body>
</html>
