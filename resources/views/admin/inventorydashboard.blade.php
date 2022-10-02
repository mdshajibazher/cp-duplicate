@php

    $monthname = \Carbon\Carbon::now()->format('F');
    $upto =\Carbon\Carbon::now()->format('d-M-Y g:i a');

@endphp
@extends('layouts.adminlayout')
@section('title','Admin Dashboard')
@section('modal')
    <!-- Button trigger modal -->
    <!-- Modal -->
    <div class="modal fade" id="InfoModal" tabindex="-1" role="dialog" aria-labelledby="InfoModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="InfoModalLabel"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="salesdata"></div>
                </div>
                <div class="modal-footer" id="InfoModal-footer">

                </div>
            </div>
        </div>
    </div>

@endsection







@section('content')
    @php
        $sales_summation = 0;
        $cash_summation = 0;
        $return_summation = 0;
        $pending_sales_summation = 0;
        $expensesum  = 0;
    @endphp





    <div class="row">
        <div class="col-12 col-md-6 col-lg-6" style="overflow: hidden">
            <div class="card px-3 py-3 mb-3">
                <div class="text-center">
                    @if($general_opt_value['inv_diff_invoice_heading'] == 1)
                        <img style="width: 300px"
                             src="{{asset('uploads/logo/invoicelogo/'.$general_opt_value['inv_invoice_logo'])}}"
                             alt="">
                        <h5>{{$general_opt_value['inv_invoice_heading']}}</h5>
                        <small>{{$general_opt_value['inv_invoice_email']}}
                            <br>{{$general_opt_value['inv_invoice_address']}}</small>

                    @else
                        <img src="{{asset('uploads/logo/cropped/'.$CompanyInfo->logo)}}" alt="">
                        <h5>{{$CompanyInfo->company_name}}</h5>
                        <small>{{$CompanyInfo->email}} <br> {{$CompanyInfo->phone}} <br>{{$CompanyInfo->address}}
                        </small>
                    @endif

                    <h5>Inventory Dashboard </h5>

                </div>
            </div>
            @can('dashboard.overview')
                <div class="row">
                    <div class="col-6 col-md-6 col-lg-6">
                        <!-- small box -->
                        <div class="small-box bg-warning">
                            <div class="inner">

                                <h3>{{round($current_month_sale)}}</h3>

                                <span class="text-white">{{$monthname}} Sales upto <h5
                                        class="badge badge-dark">{{$upto}} </h5></span>
                            </div>


                        </div>
                    </div>
                    <div class="col-6 col-md-6 col-lg-6">
                        <!-- small box -->
                        <div class="small-box" style="background: #78e08f">
                            <div class="inner">

                                <h3>{{round($current_month_cash)}}</h3>

                                <span class="text-white">{{$monthname}} Cashes  upto <h5
                                        class="badge badge-danger">{{$upto}} </h5> </span>
                            </div>


                        </div>
                    </div>
                    <div class="col-6 col-md-6 col-lg-6">
                        <!-- small box -->
                        <div class="small-box" style="background: #B53471">
                            <div class="inner">

                                <h3>{{round($current_month_return)}}</h3>

                                <span class="text-white">{{$monthname}} Returns upto <h5
                                        class="badge badge-warning">{{$upto}} </h5></span>
                            </div>


                        </div>
                    </div>
                    <div class="col-6 col-md-6 col-lg-6">
                        <!-- small box -->
                        <div class="small-box" style="background: #747d8c">
                            <div class="inner">
                                <h3>{{round($current_month_expense)}}</h3>

                                <p><b>{{$monthname}} Expenses upto <span
                                            class="badge badge-primary">{{$upto}}</span></b></p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-hand-holding-usd"></i>
                            </div>

                        </div>
                    </div>
                </div>
            @endcan
        </div>
        <div class="col-12 col-md-6 col-lg-6">
            @can('dashboard.chart')
                <div class="row">
                    <div class="card" style="width: 100%;margin-bottom: 50px;padding: 50px">
                        <h3 class="text-center">Monthly Overview</h3>
                        <canvas id="chart-container"></canvas>
                    </div>
                </div>
            @endcan
        </div>
    </div>
    @can('dashboard.overview')
        <div class="row justify-content-center">
            <div class="col-6 col-md-2 col-lg-2">
                <!-- small box -->
                <div class="small-box bg-white text-center">
                    <div class="inner">

                        <h3 class="text-dark" id="sales"></h3>

                        <p class="text-dark"><b>Todays Sales</b></p>
                    </div>


                </div>
            </div>

            <div class="col-6 col-md-2 col-lg-2">
                <!-- small box -->
                <div class="small-box bg-white text-center">
                    <div class="inner">
                        <h3 class="text-dark" id="cashes"></h3>

                        <p class="text-dark"><b>Todays Cashes</b></p>
                    </div>

                </div>
            </div>

            <div class="col-6 col-md-2 col-lg-2">
                <!-- small box -->
                <div class="small-box bg-white text-center">
                    <div class="inner">
                        <h3 class="text-dark" id="returns"></h3>

                        <p class="text-dark"><b>Todays Return</b></p>
                    </div>

                </div>
            </div>

            <div class="col-6 col-md-2 col-lg-2">
                <!-- small box -->
                <div class="small-box bg-white text-center">
                    <div class="inner">
                        <h3 class="text-dark" id="todays_expense">0</h3>

                        <p class="text-dark"><b>Todays Expense</b></p>
                    </div>

                </div>
            </div>
        </div>
    @endcan
    <div class="row">
        <div class="col-lg-5 mt-5">
            @can('dashboard.overview')
                <!-- Card Start -->
                <div class="card">
                    <div class="card-header">
                        <strong>Sales Invoice Pending For Approval</strong>
                    </div>
                    <div class="card-body">

                        @if(count($pending_sales) > 0)

                            <table class="table table-sm table-bordered table-striped" style="font-size: 14px;">
                                <thead class="thead-light">
                                <tr>
                                    <th class="align-middle">Sl</th>
                                    <th class="align-middle">Pending List</th>
                                    <th class="align-middle">Status</th>
                                </tr>
                                </thead>
                                <tbody>

                                @foreach ($pending_sales as $key => $pending_sales_item)
                                    @php
                                        $sales_amount = round($pending_sales_item->amount);
                                    @endphp

                                    <tr class="sale-{{$pending_sales_item->id}}">
                                        <td class="align-middle"><strong>{{$key+1}}</strong></td>
                                        <td class="align-middle"><a
                                                onclick="PendingSalesInfo('{{route('pendingsaleinfo.api',$pending_sales_item->id)}}','{{route('sale.approve',$pending_sales_item->id)}}',{{$pending_sales_item->user_id}})"
                                                style="color: #000;text-decoration: underline"
                                                href="javascript:void(0)"><small>{{$pending_sales_item->sales_at->format('d-M-Y')}}
                                                    - <span
                                                        class="badge badge-warning">ID: {{$pending_sales_item->id}}</span>
                                                </small>
                                                <br> <strong>{{$pending_sales_item->user->name}}</strong>
                                                <br> @if($pending_sales_item->is_condition == false)

                                                    {!!fuc_is_conditioned($pending_sales_item->is_condition)!!}
                                                @else
                                                    {!!fuc_is_conditioned($pending_sales_item->is_condition)!!} <span
                                                        class="badge badge-dark">
				{{$pending_sales_item->condition_amount}} tk </span>
                                                @endif
                                                @if($pending_sales_item->edited)
                                                    <span class="badge badge-info">edited</span>
                                                @endif
                                            </a></td>

                                        <th class="align-middle"
                                            id="sale-{{$pending_sales_item->id}}">{!!FashiSalesStatus($pending_sales_item->sales_status)!!}</th>

                                    </tr>

                                @endforeach


                                </tbody>

                            </table>

                        @else
                            <div class="row">
                                <span class="alert alert-success">No Pending Sales Found</span>
                            </div>
                        @endif
                        <hr>
                    </div>
                </div>
                <!-- End -->
                <div class="card mt-3">
                    <div class="card-header bg-dark text-white">
                        <strong>Cash Pending For Approval</strong>
                    </div>
                    <div class="card-body">

                        @if(count($pending_cash) > 0)
                            <div class="table-responsive">
                                <table class="table table-sm" style="font-size: 14px;">
                                    <thead class="thead-light">
                                    <tr>
                                        <th class="align-middle">Pending Cash</th>
                                        <th class="align-middle">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    @foreach ($pending_cash as $key => $pending_cash_item)
                                        @php
                                            $sales_amount = round($pending_cash_item->amount);
                                        @endphp
                                        <tr class="cash-{{$pending_cash_item->id}} bglight">
                                            <td class="align-middle">
                                                <table class="table table-sm">
                                                    <tr>
                                                        <td>Name:</td>
                                                        <th>{{$pending_cash_item->user->name}}</th>
                                                    </tr>
                                                    <tr>
                                                        <td>Addr:</td>
                                                        <td><small>{{$pending_cash_item->user->address}}</small></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Amount:</td>
                                                        <th><h4>{{round($pending_cash_item->amount)}}/-</h4></th>
                                                    </tr>
                                                    @if($pending_cash_item->discount > 0)
                                                        <tr>
                                                            <td>Discount:</td>
                                                            <th><h5>{{round($pending_cash_item->discount)}}/-</h5></th>
                                                        </tr>
                                                    @endif

                                                    <tr>
                                                        <td>References:</td>
                                                        <th>{{$pending_cash_item->reference}}</th>
                                                    </tr>
                                                    <tr>
                                                        <td>Date:</td>
                                                        <td>{{$pending_cash_item->received_at->format('d-M-Y')}}</td>
                                                    </tr>
                                                    @can('cash.approve')
                                                        <tr>
                                                            <td>Action:</td>
                                                            <td>
                                                                <button id="cash-{{$pending_cash_item->id}}"
                                                                        onclick="Confirmation('{{route('cash.approve',$pending_cash_item->id)}}','{{str_replace("'", "", $pending_cash_item->user->name)}}','{{$pending_cash_item->amount}}',{{$pending_cash_item->id}})"
                                                                        type="button" class="btn btn-sm btn-danger">
                                                                    Approve
                                                                </button>
                                                            </td>
                                                        </tr>
                                                    @endcan
                                                </table>


                                            </td>
                                            <td class="align-middle">
                                                @if($pending_cash_item->status == 0)
                                                    <span class="badge badge-warning">pending</span>
                                                @endif</td>

                                        </tr>

                                    @endforeach


                                    </tbody>

                                </table>
                            </div>

                        @else
                            <div class="row">
                                <span class="alert alert-success">No Pending Cash Found</span>
                            </div>
                        @endif
                        <hr>
                    </div>
                </div>
                <!-- Card Start -->
                <div class="card mt-3">
                    <div class="card-header" style="background: #b8e994">
                        <strong>Return Invoice Pending For Approval</strong>
                    </div>
                    <div class="card-body">

                        @if(count($pending_returns) > 0)

                            <table class="table table-sm table-bordered" style="font-size: 14px;">
                                <thead class="thead-light">
                                <tr>
                                    <th class="align-middle">Sl</th>
                                    <th class="align-middle">Pending List</th>
                                    <th class="align-middle">Status</th>
                                </tr>
                                </thead>
                                <tbody>

                                @foreach ($pending_returns as $key => $pending_returns_item)
                                    @php
                                        $sales_amount = round($pending_returns_item->amount);
                                    @endphp
                                    <tr class="return-{{$pending_returns_item->id}}">
                                        <td class="align-middle"><strong>{{$key+1}}</strong></td>
                                        <td class="align-middle"><a
                                                onclick="PendingReturnInfo('{{route('pendingreturninfo.api',$pending_returns_item->id)}}','{{route('returnproduct.approve',$pending_returns_item->id)}}')"
                                                style="color: #000;text-decoration: underline" data-toggle="tooltip"
                                                data-placement="top"
                                                title="Service Provided by {{$pending_returns_item->provided_by}}  at {{$pending_returns_item->created_at->format('d-M-Y g:i a')}}   - Click Here For Details"
                                                class="btn btn-link" href="javascript:void(0);">
                                                <small>{{$pending_returns_item->returned_at->format('d-M-Y')}} </small>
                                                <br> <strong>{{$pending_returns_item->user->name}}</strong> </a></td>
                                        <th class="align-middle"
                                            id="return-{{$pending_returns_item->id}}">{!!InvReturnStatus($pending_returns_item->return_status)!!}</th>

                                    </tr>
                                @endforeach


                                </tbody>

                            </table>

                        @else
                            <div class="row">
                                <span class="alert alert-success">No Pending Returns Found</span>
                            </div>
                        @endif
                        <hr>
                    </div>
                </div>
                <!-- End -->
                <div class="card mt-3">
                    <div class="card-header text-white" style="background: #6ab04c">
                        <strong>Todays Expenses</strong>
                    </div>
                    <div class="card-body">
                        @php
                            $expensesum = 0;
                        @endphp
                        @if(count($todays_expense) > 0)
                            <table class="table">
                                <tr>
                                    <th>Sl</th>
                                    <th>Amount</th>
                                    <th>Reasons</th>
                                </tr>
                                @foreach ($todays_expense as $key => $item)
                                    @php
                                        $expensesum = $expensesum+$item->amount
                                    @endphp

                                    <tr>
                                        <td>{{$key+1}}</td>
                                        <td>{{$item->amount}}</td>
                                        <td><small>{{$item->reasons}}</small></td>
                                    </tr>
                                @endforeach
                            </table>
                            <strong class="float-right">Total: {{$expensesum}}</strong>
                        @else
                            <p class="alert alert-success">No Expense Found Today</p>
                        @endif
                    </div>
                </div>
            @endcan
            @can('dashboard.delivery')
                <!-- Card Start -->
                <div class="card mt-3">
                    <div class="card-header bg-warning">
                        <strong>Invoice Pending For Delivery</strong>
                    </div>
                    <div class="card-body">

                        @if(count($pending_delivery) > 0)

                            <table class="table table-sm table-bordered" style="font-size: 14px;">
                                <thead class="thead-light">
                                <tr>
                                    <th class="align-middle">Sl</th>
                                    <th class="align-middle">Pending List</th>
                                </tr>
                                </thead>
                                <tbody>

                                @foreach ($pending_delivery as $key => $pending_delivery_item)
                                    @php
                                        $sales_amount = round($pending_delivery_item->amount);
                                    @endphp
                                    <tr class="delivery-{{$pending_delivery_item->id}}">
                                        <td class="align-middle">
                                            <strong>{{$pending_delivery->firstItem() + $key}}</strong>
                                        </td>
                                        <td class="align-middle">
                                            <table class="table">
                                                <tr>
                                                    <td>Date:</td>
                                                    <td>{{$pending_delivery_item->sales_at->format('d-M-Y')}}</td>
                                                </tr>
                                                <tr>
                                                    <td>Customer:</td>
                                                    <td>{{$pending_delivery_item->user->name}}</td>
                                                </tr>
                                                <tr>
                                                    <td>Status:</td>
                                                    <td>{!!FashiShippingStatus($pending_delivery_item->delivery_status)!!}</td>
                                                </tr>

                                            </table>
                                            <button
                                                onclick="DeliveryModalPopup('{{route('pendingdeliveryinfo.api',$pending_delivery_item->id)}}','{{route('sale.delivery',$pending_delivery_item->id)}}')"
                                                id="delivery-{{$pending_delivery_item->id}}" type="button"
                                                class="btn btn-sm btn-dark btn-block">Click Here To Mark As Deliverd
                                            </button>

                                        </td>


                                    </tr>
                                @endforeach


                                </tbody>

                            </table>
                            <p>Page: </p>    {{$pending_delivery->links()}}

                        @else
                            <div class="row">
                                <span class="alert alert-success">No Pending Delivery Found</span>
                            </div>
                        @endif
                        <hr>
                    </div>
                </div>
                <!-- End -->
            @endcan
        </div>
        <div class="col-lg-7 mt-5">
            <div class="card">
                <div class="card-header bg-light-red">
                    <span class="card-title text-white"> <strong>Inventory Section</strong></span>
                </div>
                <div class="card-body">
                    @can('dashboard.overview')
                    <h5>Today's Sale</h5>
                    @if(count($todays_pos_sales) > 0)

                        <table class="table table-sm table-bordered" style="font-size: 14px;">
                            <thead class="thead-light">
                            <tr>
                                <th class="align-middle">ID</th>
                                <th class="align-middle">Date</th>
                                <th class="align-middle">Customer</th>
                                <th class="align-middle">Amount</th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach ($todays_pos_sales as $todays_sales_item)
                                @php
                                    $sales_amount = round($todays_sales_item->amount);
                                    $sales_summation = $sales_summation+$sales_amount;
                                @endphp
                                <tr @if($todays_sales_item->sales_status == 2) style="background: #f8a5c2" @endif>
                                    <td class="align-middle">#{{$todays_sales_item->id}}</td>
                                    <td class="align-middle"><a data-toggle="tooltip" data-placement="top"
                                                                title="Service Provided by {{$todays_sales_item->provided_by}}  at {{$todays_sales_item->created_at->format('d-M-Y g:i a')}}    Click Here For Details"
                                                                class="btn btn-link"
                                                                href="{{route('viewsales.show',$todays_sales_item->id)}}">{{$todays_sales_item->sales_at->format('d-M-Y')}} </a>
                                    </td>
                                    <td class="align-middle">{{$todays_sales_item->user->name}}</td>
                                    <td class="align-middle">{{$sales_amount}}</td>

                                </tr>
                            @endforeach


                            </tbody>

                        </table>
                        <div class="row justify-content-end">
                            <div class="col-lg-3 ">
                                <table class="table">
                                    <tr>
                                        <th>Total</th>
                                        <th>{{$sales_summation}}</th>
                                    </tr>
                                </table>
                            </div>
                        </div>

                    @else
                        <div class="row">
                            <span class="alert alert-success">No Sales Found Today</span>
                        </div>

                    @endif
                    <hr>


                    <h5>Todays Cash</h5>
                    @if(count($todays_pos_cash) > 0)

                        <table class="table table-sm table-bordered" style="font-size: 14px;">
                            <thead class="thead-light">
                            <tr>
                                <th class="align-middle">ID</th>
                                <th class="align-middle">Date</th>
                                <th class="align-middle">Customer</th>
                                <th class="align-middle">Amount</th>
                                <th class="align-middle">Ref</th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach ($todays_pos_cash as $todays_pos_cash_item)
                                @php
                                    $cash_amount = round($todays_pos_cash_item->amount);
                                    $cash_summation = $cash_summation+$cash_amount;
                                @endphp
                                <tr @if($todays_pos_cash_item->status == 2) style="background: #f8a5c2"
                                    @elseif($todays_pos_cash_item->status == 1)  style="background: #b8e994" @endif>
                                    <td class="align-middle">#{{$todays_pos_cash_item->id}}</td>
                                    <td data-toggle="tooltip" data-placement="top"
                                        title="Posted By {{$todays_pos_cash_item->posted_by}}   At {{$todays_pos_cash_item->created_at->format('d-M-Y g:i a')}}"
                                        class="align-middle">{{$todays_pos_cash_item->received_at->format('d-m-Y')}}</td>
                                    <td class="align-middle">{{$todays_pos_cash_item->user->name}}</td>
                                    <td class="align-middle">{{$cash_amount}}</td>
                                    <td class="align-middle">{{$todays_pos_cash_item->reference}}</td>

                                </tr>
                            @endforeach


                            </tbody>
                        </table>
                        <div class="row justify-content-end">
                            <div class="col-lg-3 ">
                                <table class="table">
                                    <tr>
                                        <th>Total</th>
                                        <th>{{$cash_summation}}</th>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    @else
                        <div class="row">
                            <span class="alert alert-success">No Cash Found Today</span>
                        </div>




                        <hr>
                        <h5>Todays Returns</h5>

                        @if(count($todays_pos_returns) > 0)

                            <table class="table table-sm table-bordered" style="font-size: 14px;">
                                <thead class="thead-light">
                                <tr>
                                    <th class="align-middle">ID</th>
                                    <th class="align-middle">Date</th>
                                    <th class="align-middle">Customer</th>
                                    <th class="align-middle">Amount</th>
                                </tr>
                                </thead>
                                <tbody>

                                @foreach ($todays_pos_returns as $todays_pos_return_item)
                                    @php
                                        $return_amount = round($todays_pos_return_item->amount);
                                        $return_summation = $return_summation+$return_amount;
                                    @endphp
                                    <tr>
                                        <td class="align-middle">#{{$todays_pos_return_item->id}}</td>
                                        <td class="align-middle"><a data-toggle="tooltip" data-placement="top"
                                                                    title="Service Provided by {{$todays_pos_return_item->returned_by}}     at {{$todays_pos_return_item->created_at->format('d-M-Y g:i a')}} - Click Here For Details"
                                                                    href="{{route('viewreturns.show',$todays_pos_return_item->id)}}">{{$todays_pos_return_item->returned_at->format('d-m-Y')}}</a>
                                        </td>
                                        <td class="align-middle">{{$todays_pos_return_item->user->name}}</td>
                                        <td class="align-middle">{{$return_summation}}</td>

                                    </tr>
                                @endforeach


                                </tbody>
                            </table>
                            <div class="row justify-content-end">
                                <div class="col-lg-3 ">
                                    <table class="table">
                                        <tr>
                                            <th>Total</th>
                                            <th>{{$return_summation}}</th>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        @else
                            <div class="row">
                                <span class="alert alert-success">No Returns Found Today</span>
                            </div>

                        @endif

                    @endif

                    @endcan

                    @can('daily_order.index')
                        <hr>

                        <h5>Todays Daily Order</h5>
                        @if(count($todays_daily_orders) > 0)

                            <table class="table table-sm table-bordered" style="font-size: 14px;">
                                <thead class="thead-light">
                                <tr>
                                    <th class="align-middle">ID</th>
                                    <th class="align-middle">Date</th>
                                    <th class="align-middle">Customer</th>
                                    <th class="align-middle">Amount</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($todays_daily_orders as $todays_daily_order_item)
                                    @php
                                        $do_amount_summation= 0;
                                        $do_amount = round($todays_daily_order_item->amount);
                                        $do_amount_summation = $do_amount_summation+$do_amount;
                                    @endphp
                                    <tr>
                                        <td class="align-middle">#{{$todays_daily_order_item->id}}</td>
                                        <td class="align-middle"><a href="javascript:void(0)">{{$todays_daily_order_item->date->format('d-m-Y')}}</a>
                                        </td>
                                        <td class="align-middle">{{$todays_daily_order_item->user->name}}</td>
                                        <td class="align-middle">{{$todays_daily_order_item->amount}}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="row justify-content-end">
                                <div class="col-lg-3 ">
                                    <table class="table">
                                        <tr>
                                            <th>Total</th>
                                            <th>{{$do_amount_summation}}</th>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        @else
                            <div class="row">
                                <span class="alert alert-success">No Daily Order Found Today</span>
                            </div>
                        @endif
                    @endcan



                        <hr>
                    @can('dashboard.delivery')
                    <h5>Last 10 Delivery </h5>
                    @if(count($last_ten_dlv) > 0)

                        <table class="table table-sm table-bordered" style="font-size: 14px;">
                            <thead class="thead-light">
                            <tr>
                                <th>Sl</th>
                                <th class="align-middle">Delivery Information</th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach ($last_ten_dlv as $key => $last_ten_item)

                                @if($last_ten_item->deliveryinfo != null)
                                    @php
                                        $d_info = json_decode($last_ten_item->deliveryinfo,true);
                                    @endphp
                                @endif


                                <tr>
                                    <th class="align-middle">{{$key+1}}</th>

                                    <td class="align-middle">
                                        <table class="table mb-3">
                                            <tr>
                                                <td>Sales ID</td>
                                                <td>#{{$last_ten_item->id}}</td>
                                            </tr>
                                            <tr>
                                                <td>Date</td>
                                                <td><a data-toggle="tooltip" data-placement="top"
                                                       title="Service Provided by {{$last_ten_item->provided_by}}  at {{$last_ten_item->created_at->format('d-m-Y')}}    Click Here For Details"
                                                       class="btn btn-link"
                                                       href="{{route('viewsales.show',$last_ten_item->id)}}">{{$last_ten_item->sales_at->format('d-m-Y')}} </a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Delivery Status:</td>
                                                <td>{!!FashiShippingStatus($last_ten_item->delivery_status)!!}</td>
                                            </tr>
                                            <tr>
                                                <td>Customer</td>
                                                <td>{{$last_ten_item->user->name}}</td>
                                            </tr>

                                            @if($last_ten_item->deliveryinfo != null)
                                                @php
                                                    $d_info = json_decode($last_ten_item->deliveryinfo,true);
                                                @endphp

                                                @if($d_info['is_condition'] === true)
                                                    <tr>
                                                        <td>Is Condition</td>
                                                        <td><span class="badge badge-success">true</span></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Condition Amount</td>
                                                        <td>{{$d_info['condition_amount']}}</td>
                                                    </tr>
                                                @endif

                                                <tr>
                                                    <td>Delivery Mode</td>
                                                    <td>{!!delivereyMode($d_info['deliverymode'])!!}</td>
                                                </tr>
                                                <tr>
                                                    <td>Transportation Charge</td>
                                                    <td>{{$d_info['transportation_expense']}}</td>
                                                </tr>
                                                @if($d_info['deliverymode'] === 'courier')
                                                    <tr>
                                                        <td>Courier/Transport</td>
                                                        <td>{{$d_info['courier_name']}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Booking Charge</td>
                                                        <td>{{$d_info['booking_amount']}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>CN Number</td>
                                                        <td>{{$d_info['cn_number']}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Delivered By</td>
                                                        <td>{{App\Admin::find($d_info['delivered_by'])->name}}</td>
                                                    </tr>

                                                @endif

                                            @endif
                                        </table>
                                    </td>


                                </tr>
                            @endforeach


                            </tbody>

                        </table>

                    @else
                        <div class="row">
                            <span class="alert alert-success">No Delivery Found</span>
                        </div>

                    @endif

                        @endcan


                </div>
            </div>


        </div>


    </div>

@endsection
@push('css')
    <link rel="stylesheet" href="{{asset('assets/css/flatpicker.min.css')}}">
@endpush

@push('js')
    <script src="{{asset('assets/js/axios.min.js')}}"></script>
    <script src="{{asset('assets/js/chartjs.js')}}"></script>
    <script src="{{asset('assets/js/flatpicker.min.js')}}"></script>
    {{-- <script src="{{asset('assets/js/canvasjs.min.js')}}"></script> --}}

    <script>
        var sales_amount = '{{round($sales_summation)}}';
        var cash_amount = '{{round($cash_summation)}}';
        var return_amount = '{{round($return_summation)}}';
        var expense_amount = '{{round($expensesum)}}';

        $("#sales").text(sales_amount);
        $("#cashes").text(cash_amount);
        $("#returns").text(return_amount);
        $("#todays_expense").text(expense_amount);

        function sms_status_bootstrap_badge(responsetext) {
            if (responsetext == 'success') {
                return `<span class="badge badge-success">${responsetext}</span>`;
            } else {
                return `<span class="badge badge-danger">${responsetext}</span>`;
            }
        }


        const MonthChartdata = {
            labels: [
                'Sales',
                'Cashes',
                'Returns',
                'Expenses'
            ],
            datasets: [{
                label: 'My First Dataset',
                data: [{{round($current_month_sale)}}, {{round($current_month_cash)}}, {{round($current_month_return)}}, {{round($current_month_expense)}}],
                backgroundColor: [
                    '#FFC312',
                    '#badc58',
                    '#f8a5c2',
                    '#12CBC4',
                ],
                hoverOffset: 4
            }]
        };

        const config = {
            type: 'doughnut',
            data: MonthChartdata,
        };

        new Chart(
            document.getElementById('chart-container'),
            config
        );

        var baseurl = '{{url('/')}}';
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-success',
                cancelButton: 'btn btn-warning  mr-3'
            },
            buttonsStyling: false
        });

        var CashApprovalPermission = false;
        var ReturnApprovalPermission = false;

        @can('sales_invoice.approve')
            CashApprovalPermission = true;
        @endcan
            @can('return_invoice.approve')
            ReturnApprovalPermission = true;
        @endcan

        function PendingSalesInfo(salesinfourl, salesapproveurl, customerid) {

            function getSalesInfo() {
                return axios.get(salesinfourl);
            }

            function getDueInfo() {
                return axios.get(baseurl + "/api/invdueinfo/" + customerid);
            }


            axios.all([getSalesInfo(), getDueInfo()])
                .then(function (response) {

                    let salesdata = JSON.parse(response[0].request.response);
                    let productData = '';
                    let returnstatus = '';
                    let pdsum = 0;
                    if (salesdata.sales_status == 0) {
                        salesstatus = '<span class="badge badge-warning">pending</span>';
                    } else if (salesdata.sales_status == 1) {
                        salesstatus = '<span class="badge badge-success">approved</span>';
                    }

                    if (salesdata.is_condition == true) {
                        condition_data = `<tr>
				<td>Booking Status</td>
				<td><span class="badge badge-success">conditioned</span></td>
				</tr>
				<tr>
				<td>Condition Amount</td>
				<td><b>${salesdata.condition_amount}</b></td>
				</tr>`;
                    } else {
                        condition_data = `<tr>
				<td>Booking Status</td>
				<td><span class="badge badge-danger">normal</span></td>
				</tr>`;
                    }


                    salesdata.product.forEach(function (item, index, arr) {
                        let s_qty = item.pivot.qty;
                        let s_free = item.pivot.free;
                        let s_price = item.pivot.price;
                        let s_total = s_qty * s_price;
                        pdsum += s_total;
                        if (s_free > 0) {
                            productData += '<tr><td>' + item.product_name + '<span style="color: #eb3b5a">+ free = ' + s_free + ' pc </span> </td><td>' + s_qty + '</td><td>' + s_price + '</td><td>' + Math.round(s_total) + '</td></tr>';
                        } else {
                            productData += '<tr><td>' + item.product_name + '</td><td>' + s_qty + '</td><td>' + s_price + '</td><td>' + Math.round(s_total) + '</td></tr>';
                        }

                    });

                    $('#salesdata').html(`<table class="table table-sm">
    <tr>
	  <td>Invoice ID</td>
	  <td>#${salesdata.id}</td>
	</tr>
	<tr>
	  <td>Date</td>
	  <td>${new Date(salesdata.sales_at).toLocaleString("en-IN", {dateStyle: "long"})}</td>
	</tr>
	<tr>
      <td>Customer</td>
	  <td>${salesdata.user.name}</td>
	</tr>
	<tr>
      <td>Phone</td>
	  <td>${salesdata.user.phone}</td>
	</tr>
	${condition_data}
	<tr>
      <td>Address</td>
	  <td>${salesdata.user.address}</td>
	</tr>
	<tr>
      <td>Approval Status</td>
	  <td>${salesstatus}</td>
	</tr>
	<tr>
      <td>Current Due</td>
	  <th><h5 style="color: #eb3b5a;">` + response[1].request.response + `</h5> </th>
	</tr>
</table>
<h5 class="text-center">Product Information</h5>
<div class="table-responsive">
	<table class="table table-sm">
	 <tr style="background: #ddd">
		<td>Product:</td>
		<td>Qty</td>
		<td>Price</td>
		<td>Total</td>
	</tr>
	${productData}
	</table>
	<table class="table table-sm">
		<tr>
			<th>Subtotal: </th>
			<th>${pdsum}</th>
		</tr>
		<tr>
			<th>Discount: </th>
			<th>${Math.round(salesdata.discount)}</th>
		</tr>
		<tr>
			<th>Carrying: </th>
			<th>${Math.round(salesdata.carrying_and_loading)}</th>
		</tr>


		<tr>
			<th>Total: </th>
			<th>${Math.round(salesdata.amount)}</th>
		</tr>
	</table>

    <p>Service Provided By :</p>
	<hr>
	<b>${salesdata.provided_by}</b> <br>
	<small>at ${new Date(salesdata.created_at).toLocaleString()}</small>

	</div> `)

                    $("#InfoModalLabel").text('Pending Sales Information');
                    $(".modal-header").css('background', '#F6E58D')
                    if (CashApprovalPermission == true) {
                        $("#InfoModal-footer").html(`<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> <button onclick="SalesApprove('${salesapproveurl}')" type="button" id="sales_approval" class="btn btn-success">Approve</button>`);
                    } else {
                        $("#InfoModal-footer").html(`<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>`);
                    }


                    $("#InfoModal").modal('show');

                })
                .catch(function (error) {
                    toastr.error(error.response.data.message, error.response.status)
                });

        }


        function PendingReturnInfo(returninfourl, returnapproveurl) {


            axios.get(returninfourl)
                .then(function (response) {

                    let returndata = JSON.parse(response.request.response);
                    let productData = '';
                    let returnstatus = '';
                    let pdsum = 0;
                    if (returndata.return_status == 0) {
                        returnstatus = '<span class="badge badge-warning">pending</span>'
                    } else if (returndata.return_status == 1) {
                        returnstatus = '<span class="badge badge-success">approved</span>';
                    }

                    returndata.product.forEach(function (item, index, arr) {
                        let s_qty = item.pivot.qty;
                        let s_price = item.pivot.price;
                        let s_total = s_qty * s_price;
                        pdsum += s_total;
                        productData += '<tr><td>' + item.product_name + '</td><td>' + s_qty + '</td><td>' + s_price + '</td><td>' + Math.round(s_total) + '</td></tr>'
                    })

                    $('#salesdata').html(`<table class="table table-sm">
	<tr>
	  <td>Date</td>
	  <td>${new Date(returndata.returned_at)}</td>
	</tr>
	<tr>
      <td>Customer</td>
	  <td>${returndata.user.name}</td>
	</tr>
	<tr>
      <td>Phone</td>
	  <td>${returndata.user.phone}</td>
	</tr>
	<tr>
      <td>Address</td>
	  <td>${returndata.user.address}</td>
	</tr>
	<tr>
      <td>Approval Status</td>
	  <td>${returnstatus}</td>
	</tr>
</table>
<h5 class="text-center">Product Information</h5>
<div class="table-responsive">
	<table class="table table-sm">
	 <tr>
		<td>Product:</td>
		<td>Qty</td>
		<td>Price</td>
		<td>Total</td>
	</tr>
	${productData}
	</table>
	<table class="table table-sm">
		<tr>
			<th>Subtotal: </th>
			<th>${Math.round(pdsum)}</th>
		</tr>
		<tr>
			<th>Discount: </th>
			<th>${Math.round(returndata.discount)}</th>
		</tr>
		<tr>
			<th>Carrying: </th>
			<th>${Math.round(returndata.carrying_and_loading)}</th>
		</tr>
		<tr>
			<th>Total: </th>
			<th>${Math.round(returndata.amount)}</th>
		</tr>
	</table>
	</div> `)

                    $("#InfoModalLabel").text('Pending Return Information');
                    $(".modal-header").css('background', '#b8e994')
                    if (ReturnApprovalPermission == true) {
                        $("#InfoModal-footer").html(`<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> <button onclick="returnApprove('${returnapproveurl}')" type="button" id="sales_approval" class="btn btn-success">Approve</button>`);
                    } else {
                        $("#InfoModal-footer").html(`<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>`);
                    }


                    $("#InfoModal").modal('show');

                })
                .catch(function (error) {
                    toastr.error(error.response.data.message, error.response.status)
                });

        }


        function returnApprove(return_approve_url) {
            axios.post(return_approve_url)
                .then(function (response) {
                    let feedback = JSON.parse(response.request.response);
                    if (feedback.status == 0) {
                        toastr.error(feedback.msg, 'Notifications')
                    } else if (feedback.status == 1) {

                        $("#return-" + feedback.id).html('<button type="button" class="btn btn-success btn-sm"><i class="fas fa-check"></i> done</button>');
                        $(".return-" + feedback.id).css('background', '#f1f2f6').delay(6000).fadeOut('slow');
                        toastr.success('Return Invoice Approved Successfully', 'Notifications')

                    }
                    $("#InfoModal").modal('hide');


                })
                .catch(function (error) {
                    toastr.error(error.response.data.message, error.response.status)
                    console.log(error);

                });
        }


        function SalesApprove(sales_approve_url) {
            $('#sales_approval').html('<i class="fas fa-spinner fa-spin"></i> Please Wait...').attr('disabled', true);
            axios.post(sales_approve_url)
                .then(function (response) {
                    let feedback = JSON.parse(response.request.response);
                    console.log(feedback);

                    $('#sales_approval').html('Approve').attr('disabled', false);
                    $(".sale-" + feedback.id).html(`<td>#</td>
			<td>
				<table class="table table-sm">
				<tr>
					<td>Customer</td>
					<td>` + feedback.cust_name + `<td>
				</tr>
				<tr>
					<td>Amount</td>
					<td>` + feedback.amount + `<td>
				</tr>
				<tr>
					<td>Delivery Agent SMS Status</td>
					<td>${sms_status_bootstrap_badge(feedback.delivery_agent_sms_status)}<td>
				</tr>
				<tr>
					<td>Delivery Agent Number</td>
					<td>${feedback.delivery_agent_number}<td>
				</tr>
				<tr>
					<td>Delivery Agent SMS Body</td>
					<td>${feedback.delivery_agent_sms_body}<td>
				</tr>

				<tr>
					<td>Customer SMS Status</td>
					<td>${sms_status_bootstrap_badge(feedback.cust_sms_status)}<td>
				</tr>
				<tr>
					<td>Customer Number</td>
					<td>${feedback.cust_number}<td>
				</tr>
				<tr>
					<td>Customer SMS Body</td>
					<td>${feedback.cust_sms_body}<td>
				</tr>

			</table>
			</td>

	<td><button type="button" class="btn btn-success btn-sm" disabled=""><i class="fas fa-check"></i> done</button></td>`).css('background', '#f1f2f6');
                    toastr.success(feedback.msg, 'Notifications')


                    $("#InfoModal").modal('hide');


                })
                .catch(function (error) {
                    $('#sales_approval').html('Approve').attr('disabled', false);
                    toastr.error(error.response.data.message, error.response.status)
                    console.log(error);
                })
        }


        function CashApprove(cash_aprove_url, col_id) {
            $(".cash-" + col_id).html(`<th><h5>Status</h5></th> <th> <h5><i class="fas fa-spinner fa-spin"></i> Please Wait...</h5></th>`);
            axios.post(cash_aprove_url)
                .then(function (response) {

                    let server_response = JSON.parse(response.request.response);

                    let smsstatus = "";
                    if (server_response.smsstatuscode == 1101) {
                        smsstatus = `<span class="badge badge-success">${server_response.smsstatus}</span>`;
                    } else {
                        smsstatus = `<span class="badge badge-danger">${server_response.smsstatus}</span>`;
                    }

                    $(".cash-" + server_response.id).html(`<td class="align-middle">
			<table class="table">
				<tr>
					<td>Customer</td>
					<td>${server_response.customer}</td>
				</tr>
				<tr>
					<td>SMS Status</td>
					<td>${smsstatus}</td>
				</tr>

				<tr>
					<td>SMS Body</td>
					<td><small>${server_response.smsbody}</small></td>
				</tr>
			 </table>

			<td class="align-middle"><span class="badge badge-success">approved</span></td>

			</td>`).css('background', '#ffffff');

                    swalWithBootstrapButtons.fire(
                        'Approved Successfully!',
                        'sms status: ' + server_response.smsstatus,
                        'success'
                    );

                })
                .catch(function (error) {
                    toastr.error(error.response.data.message, error.response.status)
                    console.log(error);
                });

        }


        function getDeliveryStatus(status) {
            if (status == 0) {
                return '<span class="badge badge-warning">pending</span>';
            } else if (status == 1) {
                return '<span class="badge badge-success">Delivered</span>';
            } else if (status == 2) {
                return '<span class="badge badge-danger">Canceled</span>';
            }
        }


        function DeliveryModalPopup(deliveryinfourl, confirmation_url) {
            $("#delivery_form").trigger("reset");

            function getSalesInfo() {
                return axios.get(deliveryinfourl);
            }

            function getDeliveryman() {
                return axios.get(baseurl + "/api/deliveryman");
            }


            axios.all([getSalesInfo(), getDeliveryman()])
                .then(response => {
                    let deliverymanData = "";
                    response[1].data.forEach(function (deliveryman) {
                        deliverymanData += "<option value=" + deliveryman.id + ">" + deliveryman.name + "</option>";
                    })

                    if (response[0].data.is_condition == true) {
                        var condition_input_display = '';
                        var is_cond = 'checked';
                        var cond_amount = response[0].data.condition_amount;
                    } else {
                        var condition_input_display = `style="display:none"`;
                        var is_cond = '';
                        var cond_amount = 0;
                    }

                    $('#InfoModalLabel').text('Delivery Form');
                    $("#salesdata").html(`
	<table class="table table-sm">
		<tr>
			<td>Order ID:</td>
			<td> #${response[0].data.id}</td>
		</tr>
		<tr>
			<td>Invoice Date:</td>
			<td> ${new Date(response[0].data.sales_at)}</td>
		</tr>
		<tr>
			<td>Customer:</td>
			<td>${response[0].data.user.name}</td>
		</tr>
		<tr>
			<td>Phone:</td>
			<td>${response[0].data.user.phone}</td>
		</tr>
		<tr>
			<td>Delivery Status:</td>
			<td>${getDeliveryStatus(response[0].data.delivery_status)}</td>
		</tr>
	</table>
	<form action="javascript:void(0)" id="delivery_form">

	<label><b>Delivery Method</b></label>
	<div class="from-group mb-3">
		<div class="custom-control custom-radio custom-control-inline">
  <input type="radio" id="courier" name="deliverymode" class="custom-control-input" value="courier" checked="checked">
  <label class="custom-control-label" for="courier">Courier/Transport</label>

</div>
		<div class="custom-control custom-radio custom-control-inline">
  <input type="radio" id="office" value="office" name="deliverymode" class="custom-control-input">
  <label class="custom-control-label" for="office">Office Delivery</label>

</div>

<hr>
<div class="form-group">
		<label for="delivery_date"><b>Delivery Date</b></label>
		<input type="text" class="form-control" id="delivery_date" name="delivery_date" placeholder="Enter  Delivery Date">
		<span class="text-danger delivery_date_err"></span>
	</div>


<div class="form-group">
		<label for="delivered_by"><b>Delivered By</b></label>
		<select class="form-control" name="delivered_by" id="delivered_by">
         ${deliverymanData}
        </select>
		<span class="text-danger delivered_by_err"></span>
	</div>
	</div>
	<div class="form-group">
		<label for="transportation_expense"><b>Transportation Charge</b></label>
		<input type="text" class="form-control" id="transportation_expense" name="transportation_expense" placeholder="Enter Transportation Charge">
		<span class="text-danger transportation_expense_err"></span>
	</div>
	<div id="courier-info">


	<div class="form-group">
		<label for="courier_name"><b>Courier/ Transport Name</b></label>
		<input type="text" class="form-control" id="courier_name" name="courier_name" placeholder="Enter Courier Name">
		<span class="text-danger courier_name_err"></span>
	</div>

	<div class="form-group">
		<label for="cn_number"><b>CN Number</b></label>
		<input type="text" class="form-control" id="cn_number" name="cn_number" placeholder="Enter CN Number">
		<span class="text-danger cn_number_err"></span>
	</div>
	<div class="form-group">
		<label for="booking_amount"><b>Booking Charge</b></label>
		<input type="text" class="form-control" id="booking_amount" name="booking_amount" placeholder="Enter Booking Amount">
		<span class="text-danger booking_amount_err"></span>
	</div>

	<div class="form-group">
	<div class="row">
		<div class="col-4"><b>Is Condition</b></div>
		<div class="col-8">   <div class="onoffswitch">
			<input type="checkbox" name="is_condition" class="onoffswitch-checkbox" id="is_condition" value="1" ${is_cond}>
			<label class="onoffswitch-label" for="is_condition">
				<span class="onoffswitch-inner"></span>
				<span class="onoffswitch-switch"></span>
			</label>
		</div></div>
	</div>

	</div>

	<div class="form-group" id="condition_field" ${condition_input_display}>
		<label for="condition_amount"><b>Condition Amount</b></label>
		<input type="text" class="form-control" id="condition_amount" name="condition_amount" placeholder="Enter Condition Amount" value="${cond_amount}">
		<span class="text-danger condition_amounte_err"></span>
	</div>

	</div>

	<div class="form-group">
<div class="col-4"><b>Send SMS</b></div>
<div class="col-8">   <div class="onoffswitch">
    <input type="checkbox" name="send_sms" class="onoffswitch-checkbox" id="send_sms" value="1" checked>
    <label class="onoffswitch-label" for="send_sms">
        <span class="onoffswitch-inner"></span>
        <span class="onoffswitch-switch"></span>
    </label>
</div></div>
</div>

	<div class="float-right mt-3">
	<button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button> <button type="button" id="send_form" onclick="sendDeliveryForm('` + confirmation_url + `')" class="btn btn-sm btn-success">Mark As Delivered</button>
	</form>

	`);

                    $("#delivery_date").flatpickr({dateFormat: 'Y-m-d'});

                    $("input[name='deliverymode']").change(function () {
                        if (this.value === "office") {
                            $("#courier-info").hide('slow');
                        } else {
                            $("#courier-info").show('slow');
                        }

                    });
                    $("#is_condition").change(function () {
                        $("#condition_field").toggle('slow');

                    });


                })
            $("#InfoModal-footer").html('');
            $('#InfoModal').modal('show');
        }

        function sendDeliveryForm(delivery_marked_url) {
            $(".text-danger").hide().text("");
            $(".red-border").removeClass("red-border");
            $('#send_form').html('<i class="fas fa-spinner fa-spin"></i> Please Wait...').attr('disabled', true);
            let data = $("#delivery_form").serialize();

            axios.post(delivery_marked_url, data)
                .then(res => {

                    $('#InfoModal').modal('hide');

                    let feedback = JSON.parse(res.request.response);
                    console.log(res);
                    if (feedback.smsstatus == 1101) {
                        $(".delivery-" + feedback.id).html(`<td>#</td>
	<td><table class="table">
	<tr>
		<td>Notification:</td>
		<td>${feedback.msg}</td>
	</tr>
	<tr>
		<td>Customer</td>
		<td>${feedback.customer}</td>
	</tr>
	<tr>
		<td>sms status:</td>
		<td><span class="badge badge-success">sent</span></td>
	</tr>
	<tr>
		<td>sms number:</td>
		<td>${feedback.smsnumber}</td>
	</tr>
	<tr>
		<td>sms Body:</td>
		<td>${feedback.sms}</td>
	</tr>
	</table></td>`);

                        //.delay(5000).fadeOut('slow');
                        toastr.success(feedback.msg, 'Notifications')
                    } else {

                        $(".delivery-" + feedback.id).html(`<td>#</td>
	<td><table class="table">
	<tr>
		<td>Notification: </td>
		<td>${feedback.msg}</td>
	</tr>
	<tr>
		<td>Customer</td>
		<td>${feedback.customer}</td>
	</tr>
	<tr>
		<td>sms status:</td>
		<td><p class="alert alert-danger">${feedback.error_code}</p></td>
	</tr>
	</table></td>`);
                        toastr.error(feedback.error_code, 'Notifications')
                        toastr.success(feedback.msg, 'Notifications')
                    }
                    console.log(feedback);

                })

                .catch(err => {
                    let errors = err.response.data.errors;
                    console.log(errors);
                    Object.keys(errors).forEach(function (value) {
                        $("#" + value + "").addClass("red-border");
                        $("." + value + "_err").text(errors[value][0]);
                    });

                    $('#send_form').html('submit').attr('disabled', false);
                    $(".text-danger").show();


                });

        }


        function Confirmation(cash_aprove_url, customer, amount, col_id) {
            swalWithBootstrapButtons.fire({
                title: 'Are you sure? ' + customer + ' Amount: ' + Math.round(amount) + '/-',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, approve it!',
                cancelButtonText: 'Later',
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    CashApprove(cash_aprove_url, col_id);
                } else if (
                    /* Read more about handling dismissals below */
                    result.dismiss === Swal.DismissReason.cancel
                ) {
                    swalWithBootstrapButtons.fire(
                        'Denied',
                        'No More Changes On Database :)',
                        'error'
                    )
                }
            });
        }
    </script>
@endpush
