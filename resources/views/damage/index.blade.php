@extends('layouts.adminlayout')
@section('title','Damages')
@section('content')

  <div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-lg-4">
                        <h5 class="card-title">Product Damages</h5>
                    </div>
                    <div class="col-lg-8">
                        <a href="{{route('damages.create')}}" class="btn btn-info btn-sm float-right"><i class="fa fa-plus"></i> New Damages</a>
                    </div>
                </div>

            </div>
            <div class="card-body">
              @php
                $sum = 0;
              @endphp

              @foreach ($damages as $item)

            <p>Id : #{{$item->id}}  Date: {{$item->damaged_at->format('d-M-Y g:i a')}} Damaged By: {{$item->damaged_by}}
               <form action="{{route('damages.destroy',$item->id)}}" method="POST">
              @csrf
              @method('delete')
               <button onclick="return confirm('Are You Sure you want to cancel This Damage')" type="submit" class="btn btn-sm btn-danger">Cancel This Record ID#{{$item->id}}</button>
            </form></p>
              <table class="table table-sm">
                <tr>
                  <th>sl</th>
                  <th>Product Name</th>
                  <th>Qty</th>
                </tr>
                @foreach($item->product as $key =>  $single_product)
                @php $sum = $sum+$single_product->pivot->qty; @endphp
                <tr>
                <td>{{$key+1}}</td>
                <td>{{$single_product->product_name}}</td>
                <td>{{$single_product->pivot->qty}} pc</td>
                </tr>
                @endforeach

              </table>
              <small>Dmage Note: {{$item->reason}}</small>
              <hr>
              <div class="mb-5"></div>

              @endforeach



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


