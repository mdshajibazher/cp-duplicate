@extends('layouts.adminlayout')
@section('title','Stock Report')

@section('content')

  <div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                Stock Report
            </div>
            <div class="card-body">
            <form action="{{route('stockreport.show')}}" method="POST">
              @csrf
                <div class="row">
                  <div class="col-lg-2">
                    <span>Start Date : </span>
                  </div>
                  <div class="col-lg-3">
                    <div class="form-group">
                      <input type="text" class="form-control @error('start') is-invalid @enderror" name="start" id="start" value="{{Carbon\Carbon::now()->toDateString()}}">
                          @error('start')
                          <small class="form-error">{{ $message }}</small>
                          @enderror
                    </div>
                  </div>
                  <div class="col-lg-2">
                    <span>End Date : </span>
                  </div>
                  <div class="col-lg-3">
                    <div class="form-group">
                      <input type="text" class="form-control @error('end') is-invalid @enderror" name="end" id="end" value="{{Carbon\Carbon::now()->toDateString()}}">
                      @error('end')
                      <small class="form-error">{{ $message }}</small>
                      @enderror
                    </div>
                  </div>
                  <div class="col-lg-2">
                    <button type="submit" class="btn btn-info">submit</button>
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
<script src="{{asset('assets/js/flatpicker.min.js')}}"></script>
<script>
  $("#start").flatpickr({dateFormat: 'Y-m-d'});
  $("#end").flatpickr({dateFormat: 'Y-m-d'});
</script>

@endpush


