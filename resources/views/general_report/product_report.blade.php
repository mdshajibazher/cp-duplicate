@extends('layouts.adminlayout')
@section('title','Date Wise Product Report')
@section('content')

    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    Date Wise Product Report
                </div>
                <div class="card-body">
                    <form action="{{route('report.show_date_wise_product')}}" method="POST">
                        @csrf
                        <div class="row">

                            <div class="col-lg-12">
                                <div class="form-group">
                                    <span>Start Date : </span>
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control @error('start') is-invalid @enderror" name="start" id="start" placeholder="Select Start Date" value="{{old('start')}}">
                                    @error('start')
                                    <small class="form-error">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="form-group">
                                    <span>End Date : </span>
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control @error('end') is-invalid @enderror" name="end" id="end" placeholder="Select End Date" value="{{old('end')}}">
                                    @error('end')
                                    <small class="form-error">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="form-group">
                                    <span> Group By : </span>
                                </div>
                                <div class="form-group">
                                    <select class="form-control @error('group_by') is-invalid @enderror" name="group_by" id="group_by">
                                        <option value="day">Daily</option>
                                        <option value="week">Weekly</option>
                                        <option value="month">Monthly</option>
                                    </select>
                                    @error('group_by')
                                    <small class="form-error">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="form-group">
                                    <span>Product</span>
                                </div>
                                <div class="form-group">

                                    <select id="product_id"  class="form-control @error('filter') is-invalid @enderror" name="product_id" placeholder="Select a Product">
                                        @foreach ($products as $item)
                                            <option value="{{$item->id}}">{{$item->product_name}}</option>
                                        @endforeach
                                    </select>
                                    @error('filter')
                                    <small class="form-error">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-12">
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
        $('#product_id').select2({
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


