@extends('layouts.adminlayout')
@section('title','Inventory Divisionwise Statements')
@section('content')

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    Cash Report
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <form action="{{route('report.showcashreport')}}" method="POST">
                                @csrf
                                <div class="row justify-content-center">

                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <span>Start Date : </span>
                                        </div>
                                        <div class="form-group">
                                            <input type="text" class="form-control @error('start') is-invalid @enderror"
                                                   name="start" id="start" placeholder="Select Start Date"
                                                   value="{{$request->start}}">
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
                                                   name="end" id="end" placeholder="Select End Date"
                                                   value="{{$request->end}}">
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
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <div class="statement_table table-responsive">
                                <h4 style="text-align: center;text-transform: uppercase;padding: 30px 0;font-family:Sans-serif">
                                    Cash Report</h4>
                                <h5 class="text-center mb-5">From {{date("d-M-Y", strtotime($request->start) )}}
                                    To {{date("d-M-Y", strtotime($request->end) )}}</h5>

                            </div>

                            <table class="table table-bordered table-striped">

                                <tr style="background: #ddd">
                                    <td class="align-middle">Date</td>
                                    <td class="align-middle">Customer</td>
                                    <td class="align-middle">Address</td>
                                    <td class="align-middle">Phone</td>
                                    <td class="align-middle">Amount</td>
                                    <td class="align-middle">Ref</td>
                                    <td class="align-middle">Source</td>
                                </tr>

                                @php
                                    $sum = 0;
                                @endphp
                                @foreach ($datewise_sorted_data as $item)
                                    @php
                                        $userinfo = DB::table('users')->where('id',$item['user_id'])->select('name','phone','address')->first();
                                        $sum = $sum+$item['amount'];
                                    @endphp
                                    <tr>
                                        <td class="align-middle">{{$item['date']}}</td>
                                        <td class="align-middle">{{ $userinfo->name}}</td>
                                        <td style="width: 80px" class="align-middle">{{ $userinfo->address}}</td>
                                        <td class="align-middle">{{ $userinfo->phone}}</td>
                                        <td class="align-middle">{{round($item['amount'])}}</td>
                                        <td class="align-middle">{{$item['reference']}}</td>
                                        <td class="align-middle">{{$item['source']}}</td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td><b>Total Amount:</b></td>
                                    <td><b>{{$sum}}</b></td>
                                    <td></td>
                                    <td></td>
                                </tr>


                            </table>

                            <form action="{{route('report.pdfcashreport')}}" method="POST">
                                @csrf
                                <input type="hidden" name="start" value="{{$request->start}}">
                                <input type="hidden" name="end" value="{{$request->end}}">
                                <button type="submit" class="btn  btn-lg"><img style="width: 40px;margin-right: 10px"
                                                                               src="{{asset('assets/images/pdf2.png')}}">
                                    Download
                                </button>
                            </form>

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
        $('#division').select2({
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


