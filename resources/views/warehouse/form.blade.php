@extends('layouts.adminlayout')
@section('title','Create Warehouse')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-lg-12">
                            <a class="btn btn-info btn-sm" href="{{route('warehouse.index')}}"><i
                                    class="fa fa-angle-left"></i> back</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row justify-content-center">
                        <div class="col-lg-6">
                            <h3 class="w-100 text-center">Add New Warehouse</h3>
                            <form id="customer-form"
                                  action="{{isset($warehouse) ?  route('warehouse.update',$warehouse->id) : route('warehouse.store')}}"
                                  method="POST"
                                  style="border: 1px solid #ddd;padding: 20px;border-radius: 5px;">
                                @csrf
                                @isset($warehouse)
                                    @method('PUT')
                                @endisset

                                <div class="form-group">
                                    <label for="name">Warehouse Name <span class="text-danger">*</span></label>
                                    <input type="text" id="name" placeholder="Enter Your Name"
                                           class="form-control @error('name') is-invalid @enderror" name="name"
                                           value="{{ isset($warehouse) ?  old('name',$warehouse->name) : old('name')}}">

                                    @error('name')
                                    <small class="form-error">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="in_charge">In charge <span class="text-danger">*</span></label>
                                    <input type="text" id="in_charge" placeholder="Enter Your Email"
                                           class="form-control @error('in_charge') is-invalid @enderror"
                                           name="in_charge"
                                           value="{{ isset($warehouse) ?  old('in_charge',$warehouse->in_charge) : old('in_charge')}}">
                                    @error('in_charge')
                                    <small class="form-error">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="address">Address <span class="text-danger">*</span></label>
                                    <textarea name="address"
                                              class="form-control @error('address') is-invalid @enderror"
                                              id="address" rows="4" placeholder="Enter Your Addres"
                                    >{{ isset($warehouse) ?  old('address',$warehouse->address) : old('address')}}</textarea>

                                    @error('address')
                                    <small class="form-error">{{ $message }}</small>
                                    @enderror
                                </div>


                                <div class="form-group">
                                    <button id="submit-button" type="submit"
                                            class="btn btn-success">{{isset($warehouse) ?  'Update' : 'Create'}}</button>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection

@push('css')

@endpush


@push('js')
    <script>

        $('#customer-form').submit(function () {
            $("#submit-button").html('<i class="fas fa-spinner fa-spin"></i> Please Wait........').addClass("disabled");
        });


    </script>
@endpush
