@extends('layouts.adminlayout')
@section('title','Show Returns')
@section('content')




<section class="invoice_content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">



            <!-- Main content -->
            <div class="invoice p-3 mb-3">
              <!-- title row -->
              <div class="row">
                <a href="{{route('return.index')}}" class="btn btn-info btn-sm mb-5"><i class="fa fa-angle-left"></i> back</a> 
                <div class="col-12">
                  <h4>
                    <i class="fas fa-money-bill-alt"></i> Return Details
                  <small class="float-right">Date:  {{$returnDetails->returned_at->format('d-M-Y g:i a')}}</small>
                  </h4>
                </div>
                <!-- /.col -->
              </div>
              <!-- info row -->
              <div class="row invoice-info">
                <div class="col-lg-9">
                  <h5>From</h5> <hr>
                  <table class="table table-borderless">
                    
                    <tr>
                      <th>Name: </th>
                      <td><strong>{{$returnDetails->user->name}}</strong></td>
                    </tr>
                    <tr>
                      <th>Email: </th>
                      <td>{{$returnDetails->user->email}}</td>
                    </tr>
                    <tr>
                      <th>Phone: </th>
                      <td>{{$returnDetails->user->phone}}</td>
                    </tr>
                    <tr>
                      <th>Division: </th>
                      <td>{{$returnDetails->user->division->name}}</td>
                    </tr>
                    <tr>
                      <th>District: </th>
                      <td>{{$returnDetails->user->district->name}}</td>
                    </tr>

                    <tr>
                      <th>Area: </th>
                      <td>{{$returnDetails->user->area->name}}</td>
                    </tr>
                    <tr>
                      <th>Address: </th>
                      <td>{{$returnDetails->user->address}}</td>
                    </tr>
      
   

                   
                  </table>
        
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
                      <th>Price</th>
                      <th>Total</th>
                    </tr>
                    </thead>
                    <tbody>
                      @php
                      $i=1;
                      $sum =0;
                      @endphp
                      @foreach ($returnDetails->product as $return_product_info)
      
                      <tr>
                        <td>{{$i++}}</td>
                        <td>{{$return_product_info->product_name}}</td>
                        <td>{{$return_product_info->pivot->qty}}</td>
                        <td>{{$return_product_info->pivot->price}}</td>
                        <td>{{($return_product_info->pivot->price)*($return_product_info->pivot->qty)}}</td>
                      </tr>

                      @php
                      $sum = ($sum) +($return_product_info->pivot->price)*($return_product_info->pivot->qty);
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
                        <th style="width:50%">Subtotal:</th>
                      <td>{{$sum}}</td>
                      </tr>
                      <tr>
                        <th>Discount</th>
                      <td>-
                        {{$returnDetails->discount}}
                        </td>
                      </tr>
                      <tr>
                        <th>Carrying & Loading:</th>
                      <td>+{{$returnDetails->carrying_and_loading}}</td>
                      </tr>
                      <tr>
                        <th>Total:</th>
                        <td>{{($sum+$returnDetails->carrying_and_loading)-($returnDetails->discount)}}</td>
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