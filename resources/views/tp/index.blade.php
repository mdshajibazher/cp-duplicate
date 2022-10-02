@extends('layouts.adminlayout')

@section('title','Product Price')
@section('modal')
<!--Insert Modal -->
@component('component.common.modal')

    @slot('modal_id')
        EditDataModal
    @endslot
    @slot('modal_size')
    modal-md
    @endslot


    @slot('submit_button')
    add_modal_submit
    @endslot
    @slot('modal_title')
      Edit Price
    @endslot

    @slot('modal_form')
       <form action="" method="POST" id="addForm">
        @csrf
        @method('PUT')
    @endslot



    @slot('modal_body')

        <div id="product-price-information"></div>

          <div class="row">

            <div class="col-lg-4">
              <label for="decrease">Decrease by (%)</label>
              <input type="number" class="form-control" id="decrease">
            </div>
            <div class="col-lg-4">
              <label for="increase">Increase by (%)</label>
              <input type="number" class="form-control" id="increase">
            </div>
            <div class="col-lg-4">
              <div class="form-group">
                <label for="price">Trade Price</label>
              <input type="text" class="form-control @error('price') is-invalid @enderror" name="price" id="price" placeholder="Enter New Price" value="{{old('price')}}">
                @error('price')
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
<div class="col-lg-12">
	<div class="card">
    <div class="card-header">

          <h5 class="card-title text-left">CHANGE TRADE PRICE</h5>


    </div>
    <div class="card-body table-responsive">


      <table class="table table-bordered table-striped table-hover mt-3" id="jq_datatables">
        <thead>
          <tr>
            <th>#</th>
            <th>Name</th>
            <th>Image</th>
            <th>Trade Price</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>

        @foreach ($products as $key => $product)

            <tr>
            <td>{{$key+1}}</td>
                <td>{{$product['product_name']}}</td>
                <td> <img style="height: 50px;" class="img-responsive img-thumbnail" src="{{asset('uploads/products/thumb/'.$product['image'])}}" alt=""></td>
                <td>{{$product->tp}}</td>
            <td>
            <button type="button" onclick="EditProcess('{{route('price.api',$product->id)}}','{{route('tp.update',$product->id)}}')"  class="btn btn-primary btn-sm" ><i class="fas fa-edit"></i></button>

              </td>
            </tr>
        @endforeach



        </tbody>
      </table>

    </div>
  </div>
</div>
</div>


@endsection
@push('css')
<link rel="stylesheet" href="{{asset('assets/css/dataTables.bootstrap4.min.css')}}">
@endpush

@push('js')

<script>
   $("#decrease").on("input", function(){
        $("#increase").val('');
        var tp = sessionStorage.getItem('tp');
        var inputted_price = $(this).val();

        if(inputted_price.length < 1){
          $("#price").val(tp);
        }else if(parseFloat(inputted_price) > parseFloat(tp)){
            alert('Discount Must Not Be Greater Than Actual Price');
            $( this ).val('');
            $("#price").val(tp);
        }else{
          var decreasepercent = (parseFloat(tp))*(parseFloat($(this).val())/100)
          var newprice = parseFloat(tp)-decreasepercent;
        // Print entered value in a div box
        $("#price").val(newprice);
        }
    });

  $("#increase").on("input", function(){
      $("#decrease").val('');
      var tp = sessionStorage.getItem('tp');
      var inputted_price = $(this).val();

        if(inputted_price.length < 1){
          $("#price").val(tp);
        }else{
          var increasepercent = (parseFloat(tp))*(parseFloat($(this).val())/100)
          var newprice = parseFloat(tp)+increasepercent;
        // Print entered value in a div box
        $("#price").val(newprice);
        }
  });

  $("#price").on("input", function(){
    $("#increase").val('');
    $("#decrease").val('');
  });


</script>







@if ($errors->any())
{{-- prevent The Modal Close If Any Error In the Form --}}
<script>
    $('#EditDataModal').modal('show');
    $('#addForm').attr('action', sessionStorage.getItem('update_url'));
</script>
@endif

<script>



var baseurl = '{{url('/')}}';
function EditProcess(edit_url, update_url){
$(document).ready(function(){
  sessionStorage.clear();
//reset form
$('#addForm').trigger("reset");
  $(".is-invalid").removeClass("is-invalid");
  $(".form-error").remove();
// Go to Edit Mode If Click Edit Button

$.get(edit_url, function (data) {
    //Change Form Action
    $('#addForm').attr('action', update_url);
    //assign data
    $('#price').val(data.tp);
    $("#product-price-information").html('<table class="table table-bordered"><tr><th>Product Name: </th><td>'+data.product_name+'</td></tr><tr><th>Image</th><td><img id="pd-img" src="'+baseurl+'/public/uploads/products/tiny/'+data.image+'" alt=""></td></tr><tr><th>Current Trade Price</th><td>'+data.tp+'</td></tr><tr><th>Last Updated</th><td>'+data.updated_at+'</td></tr></table>');
    sessionStorage.setItem('tp',data.tp);
    sessionStorage.setItem('update_url',update_url);
    $("#price-reset").attr('disabled',false);
    $('#EditDataModal').modal('show');
})
});
}
</script>

<!-- Success Alert After Product  Delete -->
@if(Session::has('success'))
<script>
Swal.fire({
  icon: 'success',
  title: '{{Session::get('success')}}',
  showConfirmButton: false,
  timer: 1500
})
</script>
@endif




<script src="{{asset('assets/js/datatables.min.js')}}"></script>
<script src="{{asset('assets/js/dataTables.bootstrap4.min.js')}}"></script>
<script>
$('#jq_datatables').DataTable();
</script>

@endpush
