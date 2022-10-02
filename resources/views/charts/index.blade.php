@extends('layouts.adminlayout')
@section('title','Growth Charts')
@section('content')
  <div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                  <h5 class="card-title">Compnay Growth Charts</h5>
            </div>
            <div class="card-body">
                <form action="{{route('charts.show')}}" method="POST">
                    @csrf
                    <div class="form-group">
                      <span>Start Date : </span>
                    </div>
                    <div class="form-group">
                      <input type="text" class="form-control @error('start') is-invalid @enderror" name="start" id="start" placeholder="Select Start Date" value="{{date('Y-m-d', strtotime('first day of january this year'))}}">
                          @error('start')
                          <small class="form-error">{{ $message }}</small>
                          @enderror
                    </div>

                    <div class="form-group">
                      <span>End Date : </span>
                    </div>
                    <div class="form-group">
                      <input type="text" class="form-control @error('end') is-invalid @enderror" name="end" id="end" placeholder="Select End Date" value="{{date('Y-m-d', strtotime('today'))}}">
                      @error('end')
                      <small class="form-error">{{ $message }}</small>
                      @enderror
                    </div>

                    <div class="form-group">
                      <select name="type" id="type" class="form-control" name="type">
                          <option value="bar">Bar</option>
                          <option value="line">Line</option>
                      </select>
                    </div>


                    <div class="form-group">
                      <button type="submit" class="btn btn-success">Submit</button>
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
