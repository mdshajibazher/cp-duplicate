@extends('layouts.adminlayout')
@section('title','Inventory supplier Statements')
@section('content')

  <div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                Supplier  Due
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-lg-12">
                <form action="{{route('report.showsupplierdue')}}" method="POST">
                    @csrf
                      <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group">
                              <span>Supplier : </span>
                            </div>
                            <div class="form-group">
                              <select data-placeholder="Select a supplier" name="supplier" id="supplier" class="form-control @error('supplier') is-invalid @enderror">
                                <option></option>
                                @foreach ($suppliers as $supplier)
                                  <option value="{{$supplier->id}}" @if ($request['supplier'] == $supplier->id) selected @endif>{{$supplier->name}}</option>
                                @endforeach
                              </select>
                              @error('supplier')
                              <small class="form-error">{{ $message }}</small>
                              @enderror
                            </div>
                        </div>
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
                  <div class="row">
                    <div class="col-lg-6">`
                      <div class="customer-table">
                        <p>Supplier Details</p>
                        <table class="table">
                          <tr>
                            <td>Supplier Name : </td>
                            <td>{{$current_supplier->name}}</td>
                          </tr>
                          <tr>
                            <td>Email : </td>
                            <td>{{$current_supplier->email}}</td>
                          </tr>
                          <tr>
                            <td>Phone : </td>
                            <td>{{$current_supplier->phone}}</td>
                          </tr>
                          <tr>
                            <td>Address : </td>
                            <td>{{$current_supplier->address}}</td>
                          </tr>
                        </table>
                      </div>
                    </div>
                  </div>

                  <div class="statement_table table-responsive">
                    <h5 class="text-center mb-5">From {{date("d-M-Y", strtotime($request->start) )}} To {{date("d-M-Y", strtotime($request->end) )}}</h5>
                  <table class="table table-striped table-hover table-bordered">
                    <thead>
                      <tr>
                        <th scope="col">Date</th>
                        <th scope="col">Bill</th>
                        <th scope="col">Particular</th>
                        <th scope="col">Debit</th>
                        <th scope="col">Credit</th>
                        <th scope="col">Reference</th>
                        <th scope="col">Balance</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                      <td>{{date("d-m-Y", strtotime($request->start))}}</td>
                        <td>N/A</td>
                        <td>Balance</td>
                        <td></td>
                        <td></td>
                        <td></td>
                      <td>{{$balance}}</td>
                      </tr>
                      @php
                        $c_due = $balance;
                        $sum = 0;
                        $paymentamount = 0;
                        $purchaseamount = 0;
                        $prevdueamount = 0;
                      @endphp
                      @foreach ($datewise_sorted_data as $item)
                      @php
                        if($item['particular'] === 'payment'){
                          $paymentamount = $paymentamount + $item['credit'];
                        }
                        if($item['particular'] === 'prevdue'){
                          $prevdueamount = $prevdueamount + $item['debit'];
                        }
                        if($item['particular'] === 'purchase'){
                          $purchaseamount = $purchaseamount + $item['debit'];
                        }
                        $sum = $sum + ($item['debit'] - $item['credit']);
                      @endphp
                      <tr>
                        <td>{{$item['date']}}</td>
                        <td>{{$item['id']}}</td>
                        <td>{{$item['particular']}}</td>
                        <td>{{$item['debit']}}</td>
                        <td>{{$item['credit']}}</td>
                        <td><small>{{$item['reference']}}</small></td>
                      <td>{{ $c_due =  $sum+$balance}}</td>
                      </tr>

                      @endforeach

                    </tbody>
                  </table>
                </div>

                <div class="row">
                  <div class="col-lg-6">
                    <div class="pdf-link text-center mt-5">
                    <form action="{{route('report.pdfsupplierdue')}}" method="POST">
                      @csrf
                      <input type="hidden" name="start" value="{{$request->start}}">
                      <input type="hidden" name="end" value="{{$request->end}}">
                      <input type="hidden" name="supplier" value="{{$current_supplier->id}}">
                      <button type="submit" class="btn  btn-lg"><img style="width: 40px;margin-right: 10px" src="{{asset('assets/images/pdf2.png')}}"> Download</button>
                      </form>
                    </div>
                  </div>
                <div class="col-lg-6">
                  <table class="table table-striped table-bordered">
                    <tr>
                      <td>Previous Balance: </td>
                    <td>{{$balance}}</td>
                    </tr>
                    <tr>
                      <td>Net Purchase: </td>
                    <td>{{$purchaseamount}}</td>
                    </tr>
                    <tr>
                      <td>Net Previous Due: </td>
                      <td>{{$prevdueamount}}</td>
                    </tr>
                    <tr>
                      <td>Net Payment: </td>
                      <td>{{$paymentamount}}</td>
                    </tr>

                    <tr>
                      <td>Current Due: </td>
                    <td style="font-weight: bold">@if($c_due > 0) <span class="text-danger">{{$c_due}}</span> @else <span class="text-success">{{$c_due}}</span>  @endif</td>
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
  $('#supplier').select2({
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


