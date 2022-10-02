@extends('layouts.adminlayout')
@section('title','Inventory User Statements')
@section('content')

  <div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                Delivery Report
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-lg-12">
                  <form action="{{route('report.posdeliveryresult')}}" method="POST">
                    @csrf
                      <div class="row justify-content-center">

                        <div class="col-lg-3">
                          <div class="form-group">
                            <span>Start Date : </span>
                          </div>
                          <div class="form-group">
                            <input type="text" class="form-control @error('start') is-invalid @enderror" name="start" id="start" placeholder="Select Start Date" value="{{$request['start']}}">
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
                          <input type="text" class="form-control @error('end') is-invalid @enderror" name="end" id="end" value="{{$request['end']}}" placeholder="Select End Date">
                            @error('end')
                            <small class="form-error">{{ $message }}</small>
                            @enderror
                          </div>
                        </div>
                        <div class="col-lg-3">
                          <div class="form-group">
                            <span>Filter</span>
                          </div>
                          <div class="form-group">
                            <select name="filter" id="filter" class="form-control @error('filter') is-invalid @enderror">
                              <option value="all" @if($request['filter'] === 'all') selected @endif>All</option>
                              <option value="0" @if($request['filter'] === '0') selected @endif>Pending</option>

                              <option value="1" @if($request['filter'] === '1') selected @endif>Delivered</option>
                            </select>
                            @error('filter')
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
                <div class="col-lg-6 mt-3">
                  <div class="pdf-link">
                  <form action="{{route('report.pdfposdeliveryresult')}}" method="POST">
                    @csrf
                    <input type="hidden" name="start" value="{{$request->start}}">
                    <input type="hidden" name="end" value="{{$request->end}}">
                    <input type="hidden" name="filter" value="{{$request->filter}}">
                    <button type="submit" class="btn  btn-lg"><img style="width: 40px;margin-right: 10px" src="{{asset('assets/images/pdf2.png')}}"> Download</button>
                    </form>
                  </div>
                </div>

            </div>

              <div class="row">
                <div class="col-lg-12">

                  <h5 class="text-center mt-5 mb-5">From {{date("d-M-Y", strtotime($request->start) )}} To {{date("d-M-Y", strtotime($request->end) )}}</h5>
                  <div class="table-responsive table-sm table-bordered">

                  <table class="table table-sm">

                      <tr>
                        <th >Sales ID</th>
                        <th>Invoice Date</th>
                        <th>Customer Info</th>
                        <th>Delivery Status</th>
                        <th>Delivery Info</th>

                      </tr>

                      @foreach($datewise_sorted_data as $item)


                      <tr>
                        <td class="align-middle">#{{$item['id']}}</td>
                        <td class="align-middle">{{$item['date']}}</td>
                        <td class="align-middle">{{$item['customer']}} <br> <small>({{$item['address']}})</small>

                          </td>
                          <td class="align-middle">{!!FashiShippingStatus($item['status'])!!}</td>
                          <td class="align-middle" style="width: 250px">
                            @if($item['delivery_info'] == null)
                              <small>No Information Found</small>
                            @else
                            @php
                             $d_info =  $item['delivery_info'];
                            @endphp

                            <small>@if(isset($d_info->delivery_date)) Delivert Date: {{$d_info->delivery_date}}  @endif Delivery Mode:{!!delivereyMode($d_info->deliverymode)!!},Transportation Expense: {{$d_info->transportation_expense}}, @if($d_info->deliverymode === "courier") Courier/Transport Name:{{$d_info->courier_name}}, Booking Amount: {{$d_info->booking_amount}},CN Number: {{$d_info->cn_number}}  Delivered By: {{App\Admin::find($d_info->delivered_by)->name}} @endif </small>


                            @endif
                          </td>


                      </tr>
                      @endforeach

                  </table>


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


