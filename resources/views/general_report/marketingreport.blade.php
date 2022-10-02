@extends('layouts.adminlayout')
@section('title','Inventory Employee Statements')
@section('content')

  <div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
               Marketing Sales Officer Repot
            </div>
            <div class="card-body">
            <form action="{{route('report.showmarketingreport')}}" method="POST">
              @csrf

                    <div class="form-group">
                      <label for="employee">Employee :</label>
                      <select data-placeholder="Select a Employee" name="employee" id="employee" class="form-control @error('employee') is-invalid @enderror">
                        <option></option>
                        @foreach ($employees as $employee)
                          <option value="{{$employee->id}}" @if (old('employee') == $employee->id) selected  @endif>{{$employee->name}}</option>
                        @endforeach
                      </select>
                      @error('employee')
                      <small class="form-error">{{ $message }}</small>
                      @enderror
                    </div>




                    <div class="form-group">
                      <label for="start">Start date:</label>
                      <input type="text" class="form-control @error('start') is-invalid @enderror" name="start" id="start" placeholder="Select Start Date">
                          @error('start')
                          <small class="form-error">{{ $message }}</small>
                          @enderror
                    </div>



                    <div class="form-group">
                      <label for="end">End date:</label>
                      <input type="text" class="form-control @error('end') is-invalid @enderror" name="end" id="end" placeholder="Select End Date">
                      @error('end')
                      <small class="form-error">{{ $message }}</small>
                      @enderror
                    </div>


                    <div style="margin-top: 40px; form-group">
                      <button type="submit" class="btn btn-info btn-block">Generate PDF Report</button>
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
  $('#employee').select2({
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


