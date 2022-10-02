@php
    function getTypeBadge($type){
            if($type === 'Sales'){
                return '<span class="badge badge-success">'.$type.'</span>';
            }else if($type === 'Returns'){
                return '<span class="badge badge-warning">'.$type.'</span>';
            }else{
                 return '<span class="badge badge-dark">'.$type.'</span>';
            }
        }
@endphp
@extends('layouts.adminlayout')
@section('title','Date wise product report')
@section('content')

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    Date Wise Product Report
                </div>
                <div class="card-body">
                    <form action="{{route('report.show_date_wise_product')}}" method="POST">
                        @csrf
                        <div class="row">

                            <div class="col-lg-2">
                                <div class="form-group">
                                    <span>Start Date : </span>
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control @error('start') is-invalid @enderror"
                                           name="start" id="start" placeholder="Select Start Date"
                                           value="{{old('start',$request->start)}}">
                                    @error('start')
                                    <small class="form-error">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-lg-2">
                                <div class="form-group">
                                    <span>End Date : </span>
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control @error('end') is-invalid @enderror"
                                           name="end" id="end" placeholder="Select End Date"
                                           value="{{old('end',$request->end)}}">
                                    @error('end')
                                    <small class="form-error">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-2">

                                <div class="form-group">
                                    <span> Group By : </span>
                                </div>
                                <div class="form-group">
                                    <select class="form-control @error('group_by') is-invalid @enderror" name="group_by" id="group_by">
                                        <option value="day">Daily</option>
                                        <option value="week">Weekly</option>
                                        <option value="month">Monthly</option>
                                    </select>
                                    @error('group_by')
                                    <small class="form-error">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-lg-3">
                                <div class="form-group">
                                    <span>Product</span>
                                </div>
                                <div class="form-group">

                                    <select id="products" class="form-control @error('filter') is-invalid @enderror"
                                            name="product_id"
                                            placeholder="Select a Product">
                                        @foreach ($products as $item)
                                            <option value="{{$item->id}}"
                                                    @if($item->id == $request->product_id) selected @endif>{{$item->product_name}}</option>
                                        @endforeach
                                    </select>
                                    @error('filter')
                                    <small class="form-error">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div style="margin-top: 40px;">
                                    <button type="submit" class="btn btn-info btn-block">submit</button>
                                </div>

                            </div>
                        </div>
                    </form>


                    <div class="row mt-3">
                        <div style="text-align: center;width: 100%" class="form-group">
                            <h5> From {{date('d F , Y', strtotime($request->start))}}
                                To {{date('d F , Y', strtotime($request->end))}}</h5>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group my-5">
                                <canvas id="sales-chart"></canvas>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group my-5">
                                <canvas id="return-chart"></canvas>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="table-responsive">
                                <table class="table  table-bordered text-center" id="jq_datatables">
                                    <thead>
                                    <tr style="background: #ddd">
                                        <td>Sl.</td>
                                        <td>Date</td>
                                        <td>Customer Name</td>
                                        <td>Product Name</td>
                                        <td>Unit Price</td>
                                        <td>Qty</td>
                                        <td>Type</td>
                                        <td>Amount</td>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @php
                                        $total = 0;
                                        $totalSalesQty = 0;
                                        $totalReturnQty = 0;
                                    @endphp
                                    @foreach ($sorted_product_data as $key => $item)
                                        @php
                                            $price = $item->price;
                                            $qty = $item->qty;
                                            $subtotal = $price*$qty;
                                            $total = $total+$subtotal;
                                            if(strtolower($item->type) === 'sales'){
                                                $totalSalesQty = $totalSalesQty+$qty;
                                            }else if(strtolower($item->type) === 'returns'){
                                                $totalReturnQty = $totalReturnQty+$qty;
                                            }
                                        @endphp

                                        <tr>
                                            <td>{{$key+1}}</td>
                                            <td>{{date('d-M-Y', strtotime($item->date))}}</td>
                                            <td>{{$item->customer_name}}</td>
                                            <td><small>{{$item->product_name}}</small></td>
                                            <td>{{round($price)}}</td>
                                            <td>{{$qty}}</td>
                                            <td>{!!getTypeBadge($item->type)!!}</td>
                                            <td>{{$subtotal}}</td>
                                        </tr>

                                    @endforeach
                                    </tbody>
                                </table>

                                <div class="row">
                                    <div class="col-lg-8">
                                        <p>In Words: {{convertNumberToWord($total)}}</p>
                                    </div>
                                    <div class="col-lg-4">
                                        <table class="table table-borderless">
                                            <tr>
                                                <td>Total Amount</td>
                                                <td>{{$total}}</td>
                                            </tr>
                                            <tr>
                                                <td>Total Sales Qty</td>
                                                <td>{{$totalSalesQty}}</td>
                                            </tr>
                                            <tr>
                                                <td>Total Return Qty</td>
                                                <td>{{$totalReturnQty}}</td>
                                            </tr>
                                            <tr>
                                                <td>Profitable Qty</td>
                                                <td>{{ $totalSalesQty - $totalReturnQty}}</td>
                                            </tr>
                                            <tr>
                                                <td>Action</td>
                                                <td>
                                                    <form action="{{route('report.export_date_wise_product')}}">
                                                        <input type="hidden" name="start" value="{{$request->start}}">
                                                        <input type="hidden" name="end" value="{{$request->end}}">
                                                        <input type="hidden" name="product_id"
                                                               value="{{$request->product_id}}">
                                                        <button type="submit" class="btn btn-success">Export as PDF
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        </table>
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
    <link rel="stylesheet" href="{{asset('assets/css/dataTables.bootstrap4.min.css')}}">
@endpush

@push('js')
    <script src="{{asset('assets/js/axios.min.js')}}"></script>
    <script src="{{asset('assets/js/chartjs.js')}}"></script>
    <script src="{{asset('assets/js/flatpicker.min.js')}}"></script>
    <script src="{{asset('assets/js/datatables.min.js')}}"></script>
    <script src="{{asset('assets/js/dataTables.bootstrap4.min.js')}}"></script>
    <script>
        var baseurl = '{{url('/')}}';
        var start = '{{$request->start}}';
        var end = '{{$request->end}}';
        var group_by = '{{$request->group_by}}';
        var product_id = '{{$request->product_id}}';
        var sale_chart = [];
        var return_chart = [];

        axios.post(baseurl + '/admin/report/date_wise_product/generate_chart', {
            start,
            end,
            group_by,
            product_id,
        })
            .then(function (response) {
                console.log(response);
                // For sales Chart

                let salesChartData = {
                    datasets: [{
                        label: 'Sales Chart',
                        backgroundColor: '#2ecc71',
                        borderColor: '#27ae60',
                        data: response.data.sale_chart
                    }]
                }

                let salesChartOptions = {
                    parsing: {
                        xAxisKey: 'date_range_string',
                        yAxisKey: 'qty'
                    }
                }
                salesChartConfig = {
                    type: 'line',
                    data: salesChartData,
                    options: salesChartOptions
                };
                new Chart(
                    document.getElementById('sales-chart'),
                    salesChartConfig
                );


                // For Return Chart

                let returnChartData = {
                    datasets: [{
                        label: 'Sales Return Chart',
                        backgroundColor: '#000000',
                        borderColor: '#000000',
                        data: response.data.return_chart
                    }]
                }

                let returnChartOptions = {
                    parsing: {
                        xAxisKey: 'date_range_string',
                        yAxisKey: 'qty'
                    }
                }
                returnChartConfig = {
                    type: 'line',
                    data: returnChartData,
                    options: returnChartOptions
                };
                new Chart(
                    document.getElementById('return-chart'),
                    returnChartConfig
                );

            })
            .catch(function (error) {
                // handle error
                console.log(error);
            })


        $('#jq_datatables').DataTable();
        $("#start").flatpickr({dateFormat: 'Y-m-d'});
        $("#end").flatpickr({dateFormat: 'Y-m-d'});
        $('#products').select2({
            width: '100%',
            theme: "bootstrap"
        });
    </script>

@endpush


