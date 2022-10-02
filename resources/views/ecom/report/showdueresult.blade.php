@extends('layouts.adminlayout')
@section('title','Eommerce Divisionwise Report')
@section('content')

  <div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
              Eommerce  Report
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-lg-12">
                  <form action="{{route('report.ecomduereportresult')}}" method="POST">
                    @csrf
                      <div class="row">

                        <div class="col-lg-3">
                          <div class="form-group">
                            <span>Start Date : </span>
                          </div>
                          <div class="form-group">
                          <input type="text" class="form-control @error('start') is-invalid @enderror" name="start" id="start" placeholder="Select Start Date" value="{{$request->start}}">
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
                            <input type="text" class="form-control @error('end') is-invalid @enderror" name="end" id="end" placeholder="Select End Date" value="{{$request->end}}">
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
                    <h4 style="text-align: center;text-transform: uppercase;padding: 30px 0;font-family:Sans-serif">Ecommerce Due Report</h4>
                    <h5 class="text-center mb-5">From {{date("d-M-Y", strtotime($request->start) )}} To {{date("d-M-Y", strtotime($request->end) )}}</h5>

                </div>

                <table class="table table-bordered table-striped">

                  <tr style="background: #ddd">
                    <td style="width: 200px" class="align-middle">Name</td>
                    <td style="width: 150px" class="align-middle">Address</td>
                    <td class="align-middle">Prev. Bal</td>
                    <td class="align-middle">Sales</td>
                    <td class="align-middle">Receive</td>
                    <td class="align-middle">Return</td>
                    <td class="align-middle">Due</td>
                  </tr>

                  @php
                    $total_sales = 0;
                    $total_cash = 0;
                    $total_return = 0;
                    $total_p_due = 0;
                  @endphp


                  @foreach ($division_report as $item)
                  @php
                  $prev_balance = $item['prev_balance'];
                  $sales = $item['sales'];
                  $cash = $item['cashes'];
                  $sreturn = $item['returns'];

                  $total_sales = $total_sales+ $sales;
                  $total_cash = $total_cash+$cash;
                  $total_return = $total_return+$sreturn;

                  $c_due = ($prev_balance+$sales)-($cash+$sreturn);

                  @endphp

                  <tr>
                    <td class="align-middle"  style="width: 200px">{{$item['customer']}}</td>
                    <td  class="align-middle"style="width: 150px">{{$item['address']}}</td>
                    <td class="align-middle">{{$prev_balance}}</td>
                    <td class="align-middle">{{$sales}}</td>
                    <td class="align-middle">{{$cash}}</td>
                    <td class="align-middle">{{$sreturn}}</td>
                  <td class="align-middle">{{$c_due}}</td>
                  </tr>
                  @endforeach


                </table>


                <div class="row justify-content-center">
                  <div class="col-lg-4">
                    <table class="table table-bordered table-striped">
                      <tr>
                        <td>Total Customer</td>
                      <td>{{count($division_report)}}</td>
                      </tr>
                      <tr>
                        <td>Total Sales</td>
                        <td>{{ $total_sales}}</td>
                      </tr>
                      <tr>
                        <td>Total Cash</td>
                        <td>{{ $total_cash}}</td>
                      </tr>
                      <tr>
                        <td>Total Return</td>
                        <td>{{ $total_return}}</td>
                      </tr>


                      <tr>
                        <td>Action</td>
                        <td>
                        <form action="{{route('report.pdfecomduereportresult')}}" method="POST">
                            @csrf
                              <input type="hidden" name="end" value="{{$request->end}}">
                              <input type="hidden" name="start" value="{{$request->start}}">
                              <button type="submit" class="btn btn-success">Download PDF</button>
                          </form>

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


