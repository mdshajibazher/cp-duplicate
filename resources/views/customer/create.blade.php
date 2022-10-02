@extends('layouts.adminlayout')
@section('title','Create Inventory Customer')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-lg-4">
                            <a class="btn btn-info btn-sm" href="{{route('customers.index')}}"><i
                                    class="fa fa-angle-left"></i> back</a>
                        </div>
                        <div class="col-lg-8">
                            <h5 class="card-title float-right">Add New Customer</h5>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row justify-content-center">
                        <div class="col-lg-8">
                            <h3 class="w-100 text-center">{{Request::is('admin/pos/customers*') ? 'MPO' : 'Pharmacy'}} Customers</h3>
                            <form  id="customer-form" action="{{Request::is('admin/pos/customers/create') ? route('customers.store') : route('pharmacy_customers.store')}}" method="POST"
                                  style="border: 1px solid #ddd;padding: 20px;border-radius: 5px;@if(Request::is('admin/pos/pharmacy_customers/create')) background: #f7f1e3 @endif">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-6">

                                        <div class="form-group">
                                            <label for="name">Customer Name <span class="text-danger">*</span></label>
                                            <input type="text" id="name" placeholder="Enter Your Name"
                                                   class="form-control @error('name') is-invalid @enderror" name="name"
                                                   value="{{old('name')}}" required>

                                            @error('name')
                                            <small class="form-error">{{ $message }}</small>
                                            @enderror
                                        </div>


                                        <div class="form-group">
                                            <label for="inventory_email">Email <small
                                                    class="text-info">(optional)</small></label>
                                            <input type="text" id="inventory_email" placeholder="Enter Your Email"
                                                   class="form-control @error('inventory_email') is-invalid @enderror"
                                                   name="inventory_email" value="{{old('inventory_email')}}">
                                            @error('inventory_email')
                                            <small class="form-error">{{ $message }}</small>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="phone">Phone <span class="text-danger">*</span></label>
                                            <input type="text" id="phone" placeholder="Enter Your phone"
                                                   class="form-control @error('phone') is-invalid @enderror"
                                                   name="phone" value="{{old('phone')}}">
                                            @error('phone')
                                            <small class="form-error">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="company">Company <small
                                                    class="text-info">(optional)</small></label>
                                            <input type="text" id="company" placeholder="Enter Your Company Name"
                                                   class="form-control @error('company') is-invalid @enderror"
                                                   name="company" value="{{old('company')}}">
                                            @error('company')
                                            <small class="form-error">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <input type="hidden" name="section" value="2">
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="address">Address <span class="text-danger">*</span></label>
                                            <textarea name="address"
                                                      class="form-control @error('address') is-invalid @enderror"
                                                      id="address" rows="4" placeholder="Enter Your Addres"
                                                      required>{{old('address')}}</textarea>

                                            @error('address')
                                            <small class="form-error">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="division">Division <span class="text-danger">*</span></label>
                                            <select name="division" id="division"
                                                    class="form-control @error('division') is-invalid @enderror"
                                                    required>
                                                <option value="">Select Division</option>
                                                @foreach ($divisions as $item)
                                                    <option
                                                        value="{{$item->id}}" {{ (old("division") == $item->id ? "selected": "") }}>{{$item->name}}</option>
                                                @endforeach

                                            </select>
                                            @error('division')
                                            <small class="form-error">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="sms_alert">Is enabled SMS Alert</label>
                                            <div>
                                                <label class="switch">
                                                    <input type="checkbox" name="sms_alert"
                                                           id="sms_alert" value="1" checked>
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>

                                        </div>

                                        <input type="hidden" name="sub_customer" value="{{Request::is('admin/pos/customers/create') ? 1 : 0}}">
                                        @if(Request::is('admin/pos/customers/create'))
                                        <div class="form-group sub_customer_json_wrapper">
                                            <label for="sub_customer_json">Select Some Pharmacy Customer</label>
                                            <select class="form-control @error('sub_customer_json') is-invalid @enderror" id="sub_customer_json" name="sub_customer_json[]" multiple></select>
                                        </div>
                                        @endif
                                    </div>
                                    <div class="col-lg-8">
                                        <div class="form-group">
                                            <button id="submit-button" type="submit" class="btn btn-success">Create</button>
                                        </div>
                                    </div>
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
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $('#division').select2({
            width: '100%',
            theme: "bootstrap",
            placeholder: "Select a Division",
        });

        $('#sub_customer_json').select2({
            ajax: {
                url: "{{route('get_customers')}}",
                type: "post",
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        _token: CSRF_TOKEN,
                        search: params.term,
                        pharmacy_customer: true,
                    };
                },
                processResults: function (response) {
                    return {
                        results: response
                    };
                },
                cache: true
            },
            width: '100%',
            theme: "bootstrap",
            placeholder: "Select some pharmacy customer",
        });

        $('#customer-form').submit(function(){
            $("#submit-button").html('<i class="fas fa-spinner fa-spin"></i> Please Wait........').addClass("disabled");
        });


    </script>
@endpush
