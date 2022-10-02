@extends('layouts.adminlayout')
@section('title','Inventory User Statements')
@section('content')

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    Sales Report
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <form action="{{route('report.sale_details_result')}}" method="POST">
                                @csrf
                                <div class="row justify-content-center">

                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <span>Start Date : </span>
                                        </div>
                                        <div class="form-group">
                                            <input type="text" class="form-control @error('start') is-invalid @enderror"
                                                   name="start" id="start" placeholder="Select Start Date"
                                                   value="{{$request['start']}}">
                                            @error('start')
                                            <small class="form-error">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <span>End Date : </span>
                                        </div>
                                        <div class="form-group">
                                            <input type="text" class="form-control @error('end') is-invalid @enderror"
                                                   name="end" id="end" value="{{$request['end']}}"
                                                   placeholder="Select End Date">
                                            @error('end')
                                            <small class="form-error">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-lg-2">
                                        <div style="margin-top: 40px;">
                                            <button type="submit" class="btn btn-info">submit</button>
                                        </div>

                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">


                            <div class="statement_table table-responsive">
                                <h5 class="text-center mb-5">From {{date("d-M-Y", strtotime($request->start) )}}
                                    To {{date("d-M-Y", strtotime($request->end) )}}</h5>
                                <table class="table table-striped table-hover table-bordered">

                                    <tr>
                                        <th scope="col">Sales ID</th>
                                        <th scope="col">Date</th>
                                        <th scope="col">Customer</th>
                                        <th scope="col">Address</th>
                                        <th scope="col">Products</th>
                                        <th scope="col">Amount</th>
                                    </tr>

                                    @php
                                        $salessum = 0;
                                    @endphp
                                    @foreach($datewise_sorted_data as $item)
                                        @php
                                            $salessum = $salessum + $item['amount']
                                        @endphp

                                        <tr>
                                            <td>#{{$item['id']}}</td>
                                            <td>{{$item['date']}}</td>
                                            <td>{{$item['customer']}}</td>
                                            <td>{{$item['address']}} <br> {{$item['phone']}}</td>
                                            <td class="align-middle">
                                                @php
                                                    $pdsum = 0;
                                                @endphp
                                                @if(count($item['products_info']) > 0)
                                                    <div style="border-bottom: 1px solid #aaa;padding-bottom: 15px;">
                                                        @foreach ($item['products_info'] as $pd)

                                                            @php
                                                                $pd_price = $pd->pivot->price;
                                                                $pd_qty = $pd->pivot->qty;
                                                                $pd_subtotal = $pd_price*$pd_qty;
                                                                $pdsum = $pdsum+$pd_subtotal;

                                                            @endphp

                                                            <small>{{Str::limit($pd->product_name,12)}} ({{$pd_qty}}
                                                                x {{$pd_price}}) = {{ $pd_subtotal}} </small> <br>

                                                        @endforeach
                                                    </div>
                                                    <small>ST : {{ $pdsum}}</small>,
                                                    <small>D: {{ $item['discount']}}</small>,
                                                    <small>C&L : {{ $item['carrying_and_loading']}}</small><br>
                                                    <small>Grand Total : <span
                                                            class="badge badge-success">{{ ($pdsum+$item['carrying_and_loading']) - ($item['discount']) }} </span>
                                                    </small><br>
                                                @else
                                                    <small>not applicable</small>
                                                @endif


                                            </td>
                                            <td>{{round($item['amount'])}}</td>
                                        </tr>
                                    @endforeach

                                </table>


                            </div>
                            <div class="row justify-content-end">
                                <div class="col-lg-3 text-right">
                                    <table class="table">
                                        <tr>
                                            <td><b>Total: </b></td>
                                            <td><b>{{$salessum}}</b></td>
                                        </tr>
                                    </table>

                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="pdf-link text-center mt-5">
                                        <form action="{{route('report.export_sale_details')}}" method="POST">
                                            @csrf
                                            <input type="hidden" name="start" value="{{$request->start}}">
                                            <input type="hidden" name="end" value="{{$request->end}}">
                                            <button type="submit" class="btn  btn-lg"><img
                                                    style="width: 40px;margin-right: 10px"
                                                    src="{{asset('assets/images/pdf2.png')}}"> Download
                                            </button>
                                        </form>
                                    </div>
                                </div>

                            </div>

                        </div>

                    </div>


                </div>
            </div>
        </div>
    </div>

@endsection

@push('css')
    <link rel="stylesheet" href="{{asset('assets/css/flatpicker.min.css')}}">
@endpush

@push('js')
    <script>
        $('#user').select2({
            width: '100%',
            theme: "bootstrap"
        });
    </script>
    <script src="{{asset('assets/js/flatpicker.min.js')}}"></script>
    <script src="{{asset('assets/js/datatables.min.js')}}"></script>
    <script src="{{asset('assets/js/dataTables.bootstrap4.min.js')}}"></script>


    <script>
        $("#start").flatpickr({dateFormat: 'Y-m-d'});
        $("#end").flatpickr({dateFormat: 'Y-m-d'});

        $('#order_table').DataTable({});
        $('#cash_table').DataTable({});
    </script>

@endpush


