@extends('layouts.adminlayout')
@section('title','Inventory Return')
@section('content')

    <section class="invoice_content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">


                    <!-- Main content -->
                    <div class="invoice p-3 mb-3">
                        <!-- title row -->
                        <div class="row">
                            <div class="col-lg-6">
                                @if(Route::current()->getName() == 'viewreturns.show')

                                    <a href="{{route('admin.inventorydashboard')}}" class="btn btn-info btn-sm mb-5"><i
                                            class="fa fa-angle-left"></i> back</a>
                                @else
                                    <a href="{{route('returnproduct.index')}}" class="btn btn-info btn-sm mb-5"><i
                                            class="fa fa-angle-left"></i> back</a>
                                @endif
                            </div>
                            <div class="col-lg-6">
                                <div class="d-flex justify-content-end">
                                    <div class="mr-3">
                                        @if($returnDetails->return_status == 0)
                                            @can('return_invoice.approve')
                                                <button
                                                    onclick="returnApprove('{{route('returnproduct.approve',$returnDetails->id)}}')"
                                                    type="submit" class="btn btn-warning btn-sm mb-3 float-right"
                                                    style="margin-right: 5px;">
                                                    <i class="fas fa-check"></i> APPROVE THIS RETURN ?
                                                </button>
                                            @endcan
                                        @else
                                            <button disabled type="button" class="btn btn-success mb-5"><i
                                                    class="fas fa-check"></i> Approved by {{$signature->name}} <br><span
                                                    class="badge badge-warning">{{$returnDetails->updated_at->format('d-F-Y g:i a')}}</span>
                                            </button>
                                        @endif
                                    </div>
                                    <div>

                                        @can('return_invoice.approve')
                                            <form action="{{route('returnproduct.destroy',$returnDetails->id)}}"
                                                  method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button
                                                    onclick="return confirm('Are You Sure You Want To Cancel This Order')"
                                                    type="submit" class="btn btn-danger btn-sm mb-5"
                                                    style="margin-right: 5px;">
                                                    <i class="fas fa-trash"></i> Cancel
                                                </button>
                                            </form>
                                        @endcan
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="col-12">
                            <h4>
                                <i class="fas fa-money-bill-alt"></i> Return Details
                                <small
                                    class="float-right">Date: {{$returnDetails->returned_at->format('d-M-Y g:i a')}}</small>
                            </h4>
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- info row -->
                    <div class="row invoice-info">
                        <div class="col-sm-6 invoice-col">
                            <h5>From</h5>
                            <hr>
                            <table class="table table-borderless">

                                <tr>
                                    <th>Name:</th>
                                    <td><strong>{{$returnDetails->user->name}}</strong></td>
                                </tr>
                                <tr>
                                    <th>Email:</th>
                                    <td>{{$returnDetails->user->inventory_email}}</td>
                                </tr>
                                <tr>
                                    <th>Phone:</th>
                                    <td>{{$returnDetails->user->phone}}</td>
                                </tr>
                                <tr>
                                    <th>Division:</th>
                                    <td>{{$returnDetails->user->division->name}}</td>
                                </tr>
                                <tr>
                                    <th>Address:</th>
                                    <td>{{$returnDetails->user->address}}</td>
                                </tr>


                            </table>

                        </div>


                        <div class="col-sm-6">
                            <P>Other Infotmation</P>
                            <table class="table table-bordered">
                                <tr>
                                    <th>Customer Division:</th>
                                    <td>{{$returnDetails->user->division->name}}</td>
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

                        <!-- accepted payments column -->
                        <div class="col-6 mt-5">

                            Service Provided By :
                            <hr>
                            <strong> {{$returnDetails->returned_by}} <small> <br>
                                    at {{$returnDetails->created_at->format('d-M-Y g:i a')}}</small> </strong>
                        </div>
                        <!-- /.col -->
                        <div class="col-6">
                            <div class="">
                                <table class="table">
                                    <tr>
                                        <th>Subtotal:</th>
                                        <td>{{$sum}}</td>
                                    </tr>
                                    <tr>
                                        <th>Discount</th>
                                        <td>-{{$returnDetails->discount}}</td>
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

                            @if($returnDetails->return_status == 1)
                                <form action="{{route('returnproduct.invoice',$returnDetails->id)}}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-primary float-right"
                                            style="margin-right: 5px;">
                                        <i class="fas fa-download"></i> Generate PDF
                                    </button>
                                </form>
                            @else
                                <img style="width: 350px;float:right" src="{{asset('assets/images/pending.png')}}"
                                     alt="">

                            @endif


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


@push('js')
    <script src="{{asset('assets/js/axios.min.js')}}"></script>
    <script>
        function returnApprove(return_approve_url) {
            axios.post(return_approve_url)
                .then(function (response) {
                    let feedback = JSON.parse(response.request.response);
                    if (feedback.status == 0) {
                        toastr.error(feedback.msg, 'Notifications')
                    } else if (feedback.status == 1) {

                        toastr.success('Return Invoice Approved Successfully', 'Notifications')
                        location.reload();

                    }


                })
                .catch(function (error) {
                    console.log(error);

                });
        }
    </script>

@endpush
