@extends('layouts.adminlayout')
@section('title','Purchase')
@section('content')

  <div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-lg-4">
                        <h5 class="card-title">Purchase</h5>
                    </div>
                    <div class="col-lg-8">
                        <a href="{{route('purchase.create')}}" class="btn btn-info btn-sm float-right"><i class="fa fa-plus"></i> New Purchase</a>
                    </div>
                </div>

            </div>
            <div class="card-body">
                <form action="{{route('purchase.result')}}" method="POST">
                    @csrf
                      <div class="row mb-3 justify-content-center">
                        <div class="col-lg-1">
                          <div class="form-group">
                            <strong>FROM : </strong>
                          </div>
                        </div>
                        <div class="col-lg-3">

                          <div class="form-group">
                            <input type="text" class="form-control @error('start') is-invalid @enderror" name="start" id="start" placeholder="Select Start Date" value="{{Carbon\Carbon::now()->toDateString()}}">
                                @error('start')
                                <small class="form-error">{{ $message }}</small>
                                @enderror
                          </div>
                        </div>
                        <div class="col-lg-1">
                          <div class="form-group">
                            <strong>To : </strong>
                          </div>
                        </div>

                        <div class="col-lg-3">
                          <div class="form-group">
                            <input type="text" class="form-control @error('end') is-invalid @enderror" name="end" id="end" placeholder="Select End Date" value="{{Carbon\Carbon::now()->toDateString()}}">
                            @error('end')
                            <small class="form-error">{{ $message }}</small>
                            @enderror
                          </div>
                        </div>


                        <div class="col-lg-2">
                          <div class="form-group">
                            <button type="submit" class="btn btn-info">submit</button>
                          </div>

                        </div>
                      </div>
                    </form>

                    <table class="table">
                        <tr class="thead-light">
                            <th>Sl</th>
                            <th>Date</th>
                            <th>Supplier</th>
                            <th>Amount</th>
                        </tr>

                        @foreach ($purchases as $key => $item)
                          <tr>
                              <td>{{$key+1}}</td>
                              <td>{{$item->purchased_at->format('d-m-Y g:i a')}}</td>
                              <td>{{$item->supplier->name}}</td>
                              <td>{{round($item->amount+$item->cost)}}</td>
                          </tr>
                        @endforeach
                    </table>

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
  sessionStorage.clear();
  $('#user').select2({
width: '100%',
  theme: "bootstrap"
});
</script>
<script src="{{asset('assets/js/flatpicker.min.js')}}"></script>
<script>
  $("#start").flatpickr({dateFormat: 'Y-m-d'});
  $("#end").flatpickr({dateFormat: 'Y-m-d'});
</script>

@endpush


