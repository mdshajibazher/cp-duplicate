@extends('layouts.adminlayout')
@section('title','Show Inventory Sales')
@section('content')


    <section class="invoice_content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 loader-wrapper p-5 m-5" style="display: none">
                    <div class="w-100 text-center">
                        <div>
                            <img style="width: 200px;" src="{{asset(config('custom_variable.logo_path'))}}" alt="">
                        </div>
                        <div>
                            <div class="lds-facebook">
                                <div></div>
                                <div></div>
                                <div></div>
                            </div>
                            <h5 style="color: #A2CB3F">Please wait while invoice is processing.....</h5>
                        </div>
                        <div>
                            <small class="text-danger">Attaintion: Please dont close your brwoser untill process is
                                complete</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row invoice-wrapper">
                <div class="col-12">
                @if($sale->sales_status != 2)

                    <!-- Main content -->
                        <div class="invoice p-3 mb-3">
                            <!-- title row -->
                            <div class="row">
                                <div class="col-lg-8">
                                    @if(Route::current()->getName() == 'viewsales.show')

                                        <a href="{{route('admin.inventorydashboard')}}"
                                           class="btn btn-info btn-sm mb-5"><i class="fa fa-angle-left"></i> back to
                                            dashboard</a>
                                    @else
                                        <a href="{{route('sale.index')}}" class="btn btn-info btn-sm mb-5"><i
                                                class="fa fa-angle-left"></i> back</a>
                                    @endif
                                </div>
                                <div class="col-lg-4 invoice-wrapper">
                                    @if($sale->sales_status == 0)
                                        @can('sales_invoice.approve')

                                            <button onclick="SalesApproval('{{route('sale.approve',$sale->id)}}')"
                                                    type="submit" class="btn btn-warning btn-sm mb-3 float-right"
                                                    style="margin-right: 5px;">
                                                <i class="fas fa-check"></i> APPROVE THIS ORDER ?
                                            </button>

                                        @endcan
                                        @can('sales_invoice.approve')
                                            <form id="delete-from-{{$sale->id}}"
                                                  action="{{route('sale.destroy',$sale->id)}}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button onclick="deleteItem({{$sale->id}})" type="button"
                                                        class="btn btn-danger btn-sm mb-5" style="margin-right: 5px;">
                                                    <i class="fas fa-trash"></i> Cancel
                                                </button>
                                            </form>
                                            @endcan
                                       
                                    @else
                                        <button disabled type="button" class="btn btn-success"><i
                                                class="fas fa-check"></i> Approved by {{$signature->name}} <br><span
                                                class="badge badge-warning">{{$sale->updated_at->format('d-F-Y g:i a')}}</span>
                                        </button>

                                    @endif
                                </div>


                                <div class="col-12">
                                    <h4>
                                        <i class="fas fa-money-bill-alt"></i> Sales Details
                                        <small
                                            class="float-right">Date: {{$sale->sales_at->format('d-M-Y g:i a')}}</small>
                                    </h4>
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- info row -->
                            <div class="row invoice-info">
                                <div class="col-sm-6 invoice-col">
                                    From
                                    <table class="table table-borderless">

                                        <tr>
                                            <th>Name:</th>
                                            <td><strong>{{$sale->user->name}}</strong></td>
                                        </tr>
                                        <tr>
                                            <th>Email:</th>
                                            <td>{{$sale->user->inventory_email}}</td>
                                        </tr>
                                        <tr>
                                            <th>Phone:</th>
                                            <td>{{$sale->user->phone}}</td>
                                        </tr>

                                        <tr>
                                            <th> Address:</th>
                                            <td>{{$sale->user->address}}</td>
                                        </tr>


                                    </table>
                                </div>
                                <div class="col-sm-6">
                                    <P>Other Infotmation</P>
                                    <table class="table table-bordered">
                                        <tr>
                                            <td>Booking Type</td>
                                            <td>@if($sale->is_condition == true){!!fuc_is_conditioned($sale->is_condition)!!}
                                                <span
                                                    class="badge badge-light">{{$sale->condition_amount}} Tk @else {!!fuc_is_conditioned($sale->is_condition)!!}  @endif </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Customer Division:</td>
                                            <td>{{$sale->user->division->name}}</td>
                                        </tr>

                                        <tr>
                                            <td>Delivery Staus</td>
                                            <td>
                                                {!! FashiShippingStatus($sale->delivery_status) !!}
                                            </td>
                                        </tr>
                                        @if($sale->delivery_status == 1)
                                            <tr>
                                                <td>Delivery Confirmed By</td>
                                                <td>{{$delivered_by->name}}</td>
                                            </tr>

                                            @if($sale->deliveryinfo != null)
                                                @php
                                                    $d_info = json_decode($sale->deliveryinfo,true);
                                                @endphp
                                                <tr>
                                                    <td>Delivered By</td>
                                                    <td>{{App\Admin::find($d_info['delivered_by'])->name}}</td>
                                                </tr>

                                                <tr>
                                                    <td>Delivery Mode</td>
                                                    <td><span
                                                            class="badge badge-warning">{{$d_info['deliverymode']}}</span>
                                                    </td>
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
                                                        <td>Transportation Expense</td>
                                                        <td>{{$d_info['transportation_expense']}}</td>
                                                    </tr>
                                                @endif


                                            @endif


                                        @endif

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
                                            <th>Size</th>
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
                                        @foreach ($sale->product as $sales_info)

                                            <tr>
                                                <td>{{$i++}}</td>
                                                <td>{{$sales_info->product_name}} @if($sales_info->pivot->free > 0)
                                                        + {{$sales_info->pivot->free}} Pc Free @endif</td>
                                                <td>{{$sales_info->size->name}} </td>
                                                <td>{{$sales_info->pivot->qty}}</td>
                                                <td>{{$sales_info->pivot->price}}</td>
                                                <td>{{($sales_info->pivot->price)*($sales_info->pivot->qty)}}</td>
                                            </tr>

                                            @php
                                                $sum = ($sum) +($sales_info->pivot->price)*($sales_info->pivot->qty);
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
                                <div class="col-6 mt-5">
                                    Service Provided By :
                                    <hr>
                                    <strong> {{$sale->provided_by}} <small> <br>
                                            at {{$sale->created_at->format('d-M-Y g:i a')}}</small> </strong>

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
                                                <td>{{round($sale->discount)}}</td>
                                            </tr>
                                            <tr>
                                                <th>Carrying & Loading:</th>
                                                <td>{{round($sale->carrying_and_loading)}}</td>
                                            </tr>
                                            <tr>
                                                <th>Total:</th>
                                                <td>{{round(($sum+$sale->carrying_and_loading)-($sale->discount))}}</td>
                                            </tr>
                                        </table>

                                    </div>
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- /.row -->

                            <!-- this row will not appear when printing -->
                            <div class="row no-print">
                                <div class="col-6">

                                    @if($sale->sales_status == 1)

                                        @can('sales_invoice.cancel')
                                            <form id="delete-from-{{$sale->id}}" style="display: inline-block;"
                                                  action="{{route('sale.destroy',$sale->id)}}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" onclick="deleteItem({{$sale->id}})"
                                                        class="btn btn-danger"><i class="fa fa-trash"></i> Cancel</a>
                                                </button>
                                            </form>
                                        @endif
                                </div>
                                <div class="col-6">

                                    <form action="{{route('sale.invoice',$sale->id)}}" method="POST">
                                        @csrf
                                        <button onclick="" type="submit" class="btn btn-primary float-right"
                                                style="margin-right: 5px;">
                                            <i class="fas fa-download"></i> Generate PDF
                                        </button>
                                    </form>
                                    @else
                                        <img style="width: 350px;" src="{{asset('assets/images/pending.png')}}"
                                             alt="">

                                    @endif


                                </div>
                            </div>

                        </div>
                        <!-- /.invoice -->
                </div><!-- /.col -->


                @else
                    <table class="table table-borderless">
                        <tr>
                            <td>Sales Date</td>
                            <td>{{$sale->sales_at->format('d-M-Y g:i a')}}</td>
                        </tr>
                        <tr>
                            <th>Name:</th>
                            <td><strong>{{$sale->user->name}}</strong></td>
                        </tr>
                        <tr>
                            <th> Address:</th>
                            <td>{{$sale->user->address}}</td>
                        </tr>
                        <tr>
                            <td>Status</td>
                            <td><span class="badge badge-danger">Canceled</span></td>
                        </tr>


                    </table>
                @endif


            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->

@endsection

@push('css')
    <style>
        .lds-facebook {
            display: inline-block;
            position: relative;
            width: 80px;
            height: 80px;
        }

        .lds-facebook div {
            display: inline-block;
            position: absolute;
            left: 8px;
            width: 16px;
            background: #A2CB3F;
            animation: lds-facebook 1.2s cubic-bezier(0, 0.5, 0.5, 1) infinite;
        }

        .lds-facebook div:nth-child(1) {
            left: 8px;
            animation-delay: -0.24s;
        }

        .lds-facebook div:nth-child(2) {
            left: 32px;
            animation-delay: -0.12s;
        }

        .lds-facebook div:nth-child(3) {
            left: 56px;
            animation-delay: 0;
        }

        @keyframes lds-facebook {
            0% {
                top: 8px;
                height: 64px;
            }
            50%, 100% {
                top: 24px;
                height: 32px;
            }
        }

    </style>
@endpush
@push('js')
    <script src="{{asset('assets/js/axios.min.js')}}"></script>

    <script>
        let baseUrl = '{{url('/')}}';
        @if(Session::has('send_mail_notification'))
        $(".invoice-wrapper").hide();
        $(".loader-wrapper").show();
        axios.post('{{route('notification.mail')}}')
            .then(function (response) {
                toastr.success(response.data.message)
            })
            .catch(function (error) {
                toastr.error(error.response.data.message)
            })
            .finally(() => {
                $(".invoice-wrapper").show();
                $(".loader-wrapper").hide();
            })
        @endif

        function SalesApprove(sales_approve_url) {
            axios.post(sales_approve_url)
                .then(function (response) {
                    let feedback = JSON.parse(response.request.response);
                    toastr.success(feedback.message, 'Notifications')
                    location.reload();
                })
                .catch(function (error) {
                    console.log(error);

                });
        }


        function SalesApproval(sales_approve_url) {
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success mr-3',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false
            })

            swalWithBootstrapButtons.fire({
                title: 'Are you sure you want to Confirm this order?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, Approve it!'
            }).then((result) => {
                if (result.value) {
                    SalesApprove(sales_approve_url);

                } else if (
                    /* Read more about handling dismissals below */
                    result.dismiss === Swal.DismissReason.cancel
                ) {
                    swalWithBootstrapButtons.fire(
                        'Denied',
                        'Your Data  is safe :)',
                        'error'
                    )
                }
            });
        }


        function deleteItem(id) {
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: true
            })

            swalWithBootstrapButtons.fire({
                title: 'Are you sure you want to cancel this order?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Cancel it!'
            }).then((result) => {
                if (result.value) {
                    event.preventDefault();
                    document.getElementById('delete-from-' + id).submit();
                } else if (
                    /* Read more about handling dismissals below */
                    result.dismiss === Swal.DismissReason.cancel
                ) {
                    swalWithBootstrapButtons.fire(
                        'Cancelled',
                        'Your Data  is safe :)',
                        'error'
                    )
                }
            });
        }
    </script>

@endpush
