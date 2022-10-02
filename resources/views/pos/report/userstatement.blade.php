@extends('layouts.adminlayout')
@section('title','Inventory User Statements')
@section('content')

  <div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                Customer  Statement
            </div>
            <div class="card-body">
            <form action="{{route('report.showposuserstatement')}}" method="POST">
              @csrf
                <div class="row">
                  <div class="col-lg-4">
                      <div class="form-group">
                        <span>Customer : </span>
                      </div>
                      <div class="form-group">
                        <select data-placeholder="Select a Customer" name="user" id="user" class="form-control @error('user') is-invalid @enderror">
                          <option></option>
                          @foreach ($users as $user)
                            <option value="{{$user->id}}" @if (old('user') == $user->id) selected  @endif>{{$user->name}}</option>
                          @endforeach
                        </select>
                        @error('user')
                        <small class="form-error">{{ $message }}</small>
                        @enderror
                      </div>
                  </div>
                  <div class="col-lg-3">
                    <div class="form-group">
                      <span>Start Date : </span>
                    </div>
                    <div class="form-group">
                      <input type="text" class="form-control @error('start') is-invalid @enderror" name="start" id="start" placeholder="Select Start Date">
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
                      <input type="text" class="form-control @error('end') is-invalid @enderror" name="end" id="end" placeholder="Select End Date">
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
<script>
  $("#start").flatpickr({dateFormat: 'Y-m-d'});
  $("#end").flatpickr({dateFormat: 'Y-m-d'});
</script>

@endpush


