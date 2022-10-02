@extends('layouts.adminlayout')
@section('title','Inventory User Statements')
@section('content')

  <div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                 Managers Performance Report
            </div>
            <div class="card-body">
              <div class="alert alert-success">To get the managers report first  you have to set distributor for selective date range for each managers</div>
            <form action="{{route('report.showemployeewiseperformance')}}" method="POST">
              @csrf


                    <div class="form-group">
                        <label for="employee">employee</label>
                        <select onchange="getDateRange(this)" name="employee" id="employee" class="form-control @error('employee') is-invalid @enderror" >
                            <option  value="">Select employee</option>

                            @foreach ($employees as $item)
                            <option value="{{$item->id}}" {{ (old('employee') == $item->id ? 'selected' : '') }}>{{$item->name}}</option>
                            @endforeach


                        </select>
                        @error('employee')
                        <small class="form-error">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group">
                      <label for="date_range">Date Range</label>
                      <select class="form-control @error('date_range') is-invalid @enderror" name="date_range" id="date_range" placeholder="Select Date Range">

                      </select>
                      @error('date_range')
                      <small class="form-error">{{ $message }}</small>
                      @enderror
                    </div>





                    <div style="margin-top: 40px;">
                      <button type="submit" class="btn btn-info">submit</button>
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
<script src="{{asset('assets/js/axios.min.js')}}"></script>
<script src="{{asset('assets/js/flatpicker.min.js')}}"></script>
<script>
  $("#start").flatpickr({dateFormat: 'Y-m-d'});
  $("#end").flatpickr({dateFormat: 'Y-m-d'});
  let baseurl = '{{url('/')}}';
  function getDateRange(arg){
    $("#date_range").text('');
      let currentemp = document.querySelector("#employee");
      let currentemp_id = currentemp.selectedOptions[0].value;
  axios.get(baseurl+'/admin/getemployeecust/'+currentemp_id)
  .then(function (response) {
    let assignedcustdata = response.data.data;
    let assignedcustoption = "";

    assignedcustdata.forEach(element => {
      assignedcustoption += `<option value="${element.id}">${element.fromformatted} TO ${element.toformatted}</option>`;

    $("#date_range").html(`${assignedcustoption}`);
    });

    // handle success
    console.log(response.data);
  })
  .catch(function (error) {
    // handle error
    console.log(error);
  })


  }

  $('#employee').select2({
    width: '100%',
    theme: "bootstrap",
    placeholder: "Select a Employee",
});
</script>

@endpush


