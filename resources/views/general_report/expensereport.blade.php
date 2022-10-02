@extends('layouts.adminlayout')
@section('title','Eocmmerce  Order Report')
@section('content')

  <div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                Expense Report
            </div>
            <div class="card-body">
            <form action="{{route('expensereport.pdf')}}" method="POST">
              @csrf
                <div class="row">

                  <div class="col-lg-12">
                    <div class="form-group">
                      <span>Start Date : </span>
                    </div>
                    <div class="form-group">
                      <input type="text" class="form-control @error('start') is-invalid @enderror" name="start" id="start" placeholder="Select Start Date" value="{{old('start')}}">
                          @error('start')
                          <small class="form-error">{{ $message }}</small>
                          @enderror
                    </div>
                  </div>

                  <div class="col-lg-12">
                    <div class="form-group">
                      <span>End Date : </span>
                    </div>
                    <div class="form-group">
                    <input type="text" class="form-control @error('end') is-invalid @enderror" name="end" id="end" placeholder="Select End Date" value="{{old('end')}}">
                      @error('end')
                      <small class="form-error">{{ $message }}</small>
                      @enderror
                    </div>
                  </div>

                  <div class="col-lg-12">
                    <div class="form-group">
                      <span>Filter</span>
                    </div>
                    <div class="form-group">

                      <select  class="form-control @error('filter') is-invalid @enderror" name="filter" placeholder="Select a Expense Type">
                        <option value="all">All</option>
                        @foreach ($expensetype as $item)
                      <option value="{{$item->id}}">{{$item->name}}</option>
                        @endforeach
                      </select>
                      @error('filter')
                      <small class="form-error">{{ $message }}</small>
                      @enderror
                    </div>
                  </div>
                  <div class="col-lg-12">
                    <div style="margin-top: 40px;">
                      <button type="submit" class="btn btn-info">submit</button>
                    </div>

                  </div>
                </div>
              </form>

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
<script>
  $("#start").flatpickr({dateFormat: 'Y-m-d'});
  $("#end").flatpickr({dateFormat: 'Y-m-d'});
</script>

@endpush


