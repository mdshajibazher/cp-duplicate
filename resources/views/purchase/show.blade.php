@extends('layouts.adminlayout')
@section('title','Purchase')
@section('content')




<section class="invoice_content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">



            <!-- Main content -->
            <div class="invoice p-3 mb-3">
              <!-- title row -->
              <div class="row">
                <a href="{{route('purchase.index')}}" class="btn btn-info btn-sm mb-5"><i class="fa fa-angle-left"></i> back</a> 
                <div class="col-12">
                  <h4>
                    <i class="fas fa-money-bill-alt"></i> Purchase Details
                  <small class="float-right">Date:  {{$purchaseDetails->purchased_at->format('d-M-Y g:i a')}}</small>
                  </h4>
                </div>
                <!-- /.col -->
              </div>
              <!-- info row -->
              <div class="row invoice-info">
                <div class="col-sm-4 invoice-col">
                  From
                  <address>
                    <strong>{{$purchaseDetails->supplier->name}}</strong><br>
                    {{$purchaseDetails->supplier->address}}
                  </address>
                </div>


                <!-- /.col -->
              </div>
              <br>
              <!-- /.row -->

              <!-- Table row -->
              <div class="row">
                <div class="col-12 table-responsive">
                  <table class="table table-striped">
                    <thead>
                    <tr>
                      <th>Sl</th>
                      <th>Product</th>
                      <th>Qty</th>
                      <th>Sales Price</th>
                      <th>Purchase Price</th>
                      <th>Total</th>
                      <th>Extra Cost</th>
                    </tr>
                    </thead>
                    <tbody>
                      @php
                      $i=1;
                      $sum =0;
                      $totalcosting = 0;
                      @endphp
                      @foreach ($purchaseDetails->product as $purchase_info)
      
                      <tr>
                        <td>{{$i++}}</td>
                        <td>{{$purchase_info->product_name}}</td>
                        <td>{{$purchase_info->pivot->qty}}</td>
                        <td>{{round($purchase_info->pivot->sales_price)}}</td>
                        <td>{{round($purchase_info->pivot->price)}}</td>
                        <td>{{($purchase_info->pivot->price)*($purchase_info->pivot->qty)}}</td>
                        <td>{{round($purchase_info->pivot->cost)}}</td>
                      </tr>

                      @php
                      $sum = ($sum) +($purchase_info->pivot->price)*($purchase_info->pivot->qty);
                      $totalcosting = $totalcosting+$purchase_info->pivot->cost;
                      @endphp
                      @endforeach
                    
           
                    </tbody>
                  </table>
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->

              <div class="row">
                <!-- accepted payments column -->
                <div class="col-6">

          
                </div>
                <!-- /.col -->
                <div class="col-6">
                  <div class="table-responsive">
                    <table class="table">
                      <tr>
                        <td style="width:50%">Supplier Subtotal:</td>
                      <td>{{$sum}}</td>
                      </tr>
                      <tr>
                        <td>Discount</td>
                      <td>{{round($purchaseDetails->discount)}}</td>
                      </tr>
                      <tr>
                        <td>Carrying & Loading:</td>
                      <td>{{round($purchaseDetails->carrying_and_loading)}}</td>
                      </tr>
                      <tr>
                        <td>Sublier Payable Amount:</td>
                        <td>{{$s_amount =  round(($sum+$purchaseDetails->carrying_and_loading)-($purchaseDetails->discount))}}</td>
                      </tr>
                      <tr>
                        <td>Extra Costing</td>
                        <td>{{ $totalcosting}}</td>
                      </tr>
                      <tr>
                        <td>Grand Total</td>
                        <td>{{ $s_amount+$totalcosting}}</td>
                      </tr>
                    </table>
                    
                  </div>
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->

              <!-- this row will not appear when printing -->
              <div class="row no-print">
                <div class="col-12">
                  
                 
                  <button type="button" class="btn btn-primary float-right" style="margin-right: 5px;">
                    <i class="fas fa-download"></i> Generate PDF
                  </button>
                </div>
              </div>
            </div>
            <!-- /.invoice -->
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->

    @endsection








