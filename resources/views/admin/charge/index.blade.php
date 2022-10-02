@extends('layouts.adminlayout')
@section('title','General Charges')
@section('modal')
<!--Insert Modal -->
@component('component.common.modal')

    @slot('modal_id')
    editDataModal
    @endslot
    @slot('modal_size')
    modal-md
    @endslot


    @slot('submit_button')
    add_modal_submit
    @endslot
    @slot('modal_title')
      Edit Charge Info
    @endslot

    @slot('modal_form')
       <form action="{{route('charge.update',$charges->id)}}" method="POST" id="addForm" enctype="multipart/form-data">
        @csrf
        @method('PUT')
    @endslot



    @slot('modal_body')
        <div class="row">
            <div class="col-lg-6">
                <div class="form-group">
                    <label for="shipping">Shipping Charge</label>
                  <input type="text" class="form-control @error('shipping') is-invalid @enderror" name="shipping" id="shipping" placeholder="Enter Shipping Charge" value="{{old('shipping')}}">
                    @error('shipping')
                   <small class="form-error">{{ $message }}</small>
                   @enderror
                  </div>
                  <div class="form-group">
                    <label for="discount">Discount</label>
                  <input type="text" class="form-control @error('discount') is-invalid @enderror" name="discount" id="discount" placeholder="Enter Discount Percentage" value="{{old('discount')}}">
                    @error('discount')
                   <small class="form-error">{{ $message }}</small>
                   @enderror
                  </div>
            </div>
            <div class="col-lg-6">
                <div class="form-group">
                    <label for="vat">Vat</label>
                  <input type="text" class="form-control @error('vat') is-invalid @enderror" name="vat" id="vat" placeholder="Enter Vat" value="{{old('vat')}}">
                    @error('vat')
                   <small class="form-error">{{ $message }}</small>
                   @enderror
                  </div>

                  <div class="form-group">
                    <label for="tax">Tax</label>
                  <input type="text" class="form-control @error('tax') is-invalid @enderror" name="tax" id="tax" placeholder="Enter Tax" value="{{old('tax')}}">
                    @error('tax')
                   <small class="form-error">{{ $message }}</small>
                   @enderror
                  </div>
            </div>
        </div>

    @endslot
@endcomponent
<!--End Insert Modal -->







@endsection

@section('content')

  <div class="row">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                <button type="button" onclick="EditProcess()" class="btn btn-info btn-sm"><i class="fas fa-edit"> EDIT</i></button>
            </div>
            <div class="card-body">

                <table class="table table-bordered table-striped table-hover mt-3">

                    <tr>
                      <th>Shipping</th>
                      <th>{{$charges->shipping}} Tk</th>
                    </tr>
                    <tr>
                      <th>Vat</th>
                      <th>{{$charges->vat}} %</th>
                    </tr>
                    <tr>
                      <th>Tax</th>
                      <th>{{$charges->tax}} %</th>
                    </tr>
                    <tr>
                      <th>Discount</th>
                      <th>{{$charges->discount}} %</th>
                    </tr>
                    <tr>

                    </tr>


                </table>

            </div>
        </div>





    </div>
  </div>

@endsection



@push('css')
  <!-- Spectrum Css -->
  <link href="{{asset('assets/css/spectrum.min.css')}}" rel="stylesheet" />
@endpush

@push('js')



@if ($errors->any())
{{-- prevent The Modal Close If Any Error In the Form --}}
<script>
    $('#editDataModal').modal('show');
</script>
@endif

<!-- Spectrum js -->
<script src="{{asset('assets/js/spectrum.min.js')}}"></script>

<script>





// Show Current Image On the Form Before Upload

function addProductreadURL(input) {
  if (input.files && input.files[0]) {
    var reader = new FileReader();

    reader.onload = function(e) {
      $('#pd_image2').attr('src', e.target.result);
    }

    reader.readAsDataURL(input.files[0]); // convert to base64 string
  }
}


$("#image").change(function() {
  addProductreadURL(this);
  $('#pd_image2').show();
});

</script>



<script>
function EditProcess(){
  $('#addForm').trigger("reset");
  $(".is-invalid").removeClass("is-invalid");
  $(".form-error").remove();

  $(document).ready(function(){
    $.get('{{route('charge.edit',$charges->id)}}', function (data) {
    //assign data
    $('#shipping').val(data.shipping);
    $('#discount').val(data.discount);
    $('#vat').val(data.vat);
    $('#tax').val(data.tax);
    $('#editDataModal').modal('show');
});




  });


}
</script>



@endpush
