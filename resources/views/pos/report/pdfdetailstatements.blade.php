<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="ASOjne3KXoYfj3Bf24x8FUsRK920YOgbS7CcIRxa">

    <title>Customer Details Statements</title>

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
                <h5 class="text-center">Customer Statement</h5>
                @if($general_opt_value['inv_diff_invoice_heading'] == 1)
                <p style="font-weight: bold;text-align: center">{{getCustomersSectionTitle($current_user->id)}}</p>
                <p  style="text-align: center;font-size: 11px">{{$general_opt_value['inv_invoice_address']}} <br> <b>Email :</b>  {{$general_opt_value['inv_invoice_email']}} <br> <b>Phone :</b>  {{$general_opt_value['inv_invoice_phone']}}</p>
                @else
                <p style="font-weight: bold;text-align: center">{{$CompanyInfo->company_name}}</p>
                <p style="text-align: center;font-size: 11px">{{$CompanyInfo->address}} <br> <b>Email :</b>  {{$CompanyInfo->email}} <br> <b>Phone:</b>  {{$CompanyInfo->phone}}</p>
                @endif


              </div>


                      <div class="customer-table" style="width: 60%;">
                        <p>Print Date: {{date("d-M-Y g:i a", strtotime(now()))}}</p>
                        <table class="table table-sm table-borderless">
                          <tr>
                            <td>Customer Name : </td>
                            <td>{{$current_user->name}}</td>
                          </tr>
                          <tr>
                            <td>Email : </td>
                            <td>{{$current_user->inventory_email}}</td>
                          </tr>
                          <tr>
                            <td>Phone : </td>
                            <td>{{$current_user->phone}}</td>
                          </tr>
                          <tr>
                            <td>Address : </td>
                            <td>{{$current_user->address}}</td>
                          </tr>
                        </table>
                      </div>



                  <div class="statement_table table-responsive">
                    <p style="text-align: center;margin-bottom: 10px;font-weight: bold">From {{date("d-M-Y", strtotime($request->start) )}} To {{date("d-M-Y", strtotime($request->end) )}}</p>
                  <table class="table  table-bordered table-sm">
                    <tbody>
                      <tr style="background: #dddddd">
                        <th scope="col">Date</th>
                        <th scope="col">Bill</th>
                        <th scope="col">Particular</th>
                        <th scope="col">Debit</th>
                        <th scope="col">Credit</th>
                        <th scope="col">Balance</th>
                      </tr>

                      <tr>
                        <td>{{date("d-m-Y", strtotime($request->start))}}</td>
                          <td>N/A</td>
                          <td><small>Balance</small></td>
                          <td></td>
                          <td></td>
                        <td>{{$balance}}</td>
                        </tr>


                        @php
                        $c_due = $balance;
                        $sum = 0;
                        $cashamount = 0;
                        $salesamount = 0;
                        $returnamount = 0;
                      @endphp
                      @foreach ($datewise_sorted_data as $item)
                      @php
                        if($item['particular'] === 'cash'){
                          $cashamount = $cashamount + $item['credit'];
                        }
                        if($item['particular'] === 'return'){
                          $returnamount = $returnamount + $item['credit'];
                        }
                        if($item['particular'] === 'sales'){
                          $salesamount = $salesamount + $item['debit'];
                        }
                        $sum = $sum + ($item['debit'] - $item['credit']);
                        $productInformation = $item['product'];
                      @endphp


                   <tr>
                        <td class="align-middle">{{$item['date']}}</td>
                        <td class="align-middle">{{$item['id']}}</td>
                       <td class="align-middle"><small><b>{{$item['particular']}} @if($item['reference'] != NULL) <br>({{$item['reference']}}) @endif</b></small>
                           @php
                               $pdsum = 0;
                           @endphp
                           @if(count($productInformation) > 0)
                               <div style="border-bottom: 1px solid #aaa;padding-bottom: 15px;">
                                   @foreach ($productInformation as $pd)

                                       @php
                                           $pd_price = $pd->pivot->price;
                                           $pd_qty = $pd->pivot->qty;
                                           $pd_subtotal = $pd_price*$pd_qty;
                                           $pdsum = $pdsum+$pd_subtotal;

                                       @endphp

                                       <small>{{Str::limit($pd->product_name,12)}} ({{$pd_qty}} x {{$pd_price}}) = {{ $pd_subtotal}} </small> <br>


                                   @endforeach
                               </div>


                               <small>ST : {{ $pdsum}}</small>,
                               <small>D: {{ $item['discount']}}</small>,
                               <small>C&L : {{ $item['carrying_and_loading']}}</small><br>

                               <small>Grand Total : {{ ($pdsum+$item['carrying_and_loading']) - ($item['discount']) }} </small><br>
                           @else
                               <small>not applicable</small>
                           @endif

                       </td>
                        <td class="align-middle">{{round($item['debit'])}}</td>
                        <td class="align-middle">{{round($item['credit'])}}</td>
                      <td class="align-middle">{{ $c_due =  $sum+$balance}}</td>
                      </tr>

                      @endforeach

                    </tbody>
                  </table>
                </div>
                <div class="amount-box" style="width: 40%;margin-left: 60%">
                  <table class="table table-bordered table-sm" >
                    <tr>
                      <td>Previous Balance: </td>
                    <td>{{$balance}}</td>
                    </tr>
                    <tr>
                      <td>Net Sale: </td>
                    <td>{{$salesamount}}</td>
                    </tr>
                    <tr>
                      <td>Net Return: </td>
                      <td>{{$returnamount}}</td>
                    </tr>
                    <tr>
                      <td>Net Cash: </td>
                      <td>{{$cashamount}}</td>
                    </tr>

                    <tr>
                      <td>Current Due: </td>
                    <td style="font-weight: bold">@if($c_due > 0) <span class="text-danger">{{$c_due}}</span> @else <span class="text-success">{{$c_due}}</span>  @endif</td>
                    </tr>

                  </table>
                </div>
















</body>
</html>

















