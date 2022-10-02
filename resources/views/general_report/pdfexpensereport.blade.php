<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="ASOjne3KXoYfj3Bf24x8FUsRK920YOgbS7CcIRxa">

    <title>Expense Report</title>

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
                <h5 style="text-align: center;font-family: Tahoma,sans-serif">Expense Report</h5>
                @if($general_opt_value['inv_diff_invoice_heading'] == 1)
                <p style="font-weight: bold;text-align: center">{{$general_opt_value['inv_invoice_heading']}}</p>
                <p  style="text-align: center;font-size: 11px">{{$general_opt_value['inv_invoice_address']}} <br> <b>Email :</b>  {{$general_opt_value['inv_invoice_email']}} <br> <b>Phone :</b>  {{$general_opt_value['inv_invoice_phone']}}</p>
                @else
                <p style="font-weight: bold;text-align: center">{{$CompanyInfo->company_name}}</p>
                <p style="text-align: center;font-size: 11px">{{$CompanyInfo->address}} <br> <b>Email :</b>  {{$CompanyInfo->email}} <br> <b>Phone:</b>  {{$CompanyInfo->phone}}</p>
                @endif

              </div>





                  <div class="statement_table">
                    <p style="text-align: center;margin-bottom: 30px;font-weight: bold">From {{date("d-M-Y", strtotime($request->start) )}} To {{date("d-M-Y", strtotime($request->end) )}}</p>
                    <table class="table table-sm">

                        <tr>
                          <th >Date</th>
                          <th>Amount</th>
                          <th>Type</th>
                          <th>Ref</th>
                        </tr>
                        @php
                        $sum = 0;
                        @endphp
                        @foreach ($expensecollection as $item)
                        @php
                            $sum = $sum+$item->amount;
                        @endphp
                        <tr>
                          <td class="align-middle">{{$item->expense_date->format('d-m-Y')}}</td>
                          <th class="align-middle">{{round($item->amount)}}</th>
                          <td class="align-middle">{{$item->expensecategory->name}}</td>
                          <td class="align-middle">{{$item->reasons}}</td>
                        </tr>
                        @endforeach

                      </table>
                      <h5 class="text-center">Total Expense: {{$sum}} Tk</h5>


                </div>


</body>
</html>
