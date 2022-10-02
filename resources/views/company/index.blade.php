@extends('layouts.adminlayout')
@section('title','Company')

@section('content')
<div class="row">
<div class="col-lg-12">
	<div class="card">
    <div class="card-header">
      <div class="row">
        <div class="col-lg-6">
          <h5 class="card-title">Company Information</h5>
        </div>
        <div class="col-lg-6 text-right">
        <a  href="{{route('company.edit',$company->id)}}" class="btn btn-info btn-sm"><i class="fa fa-edit"></i> Edit</a>
        </div>

      </div>



    </div>
    <div class="card-body table-responsive">


      <table class="table table-bordered table-striped table-hover mt-3" id="jq_datatables">
          <tr>
            <th>Company Name</th>
            <td>{{$company->company_name}}</th>
          </tr>
          <tr>
              <th>Company Tagline</th>
              <td>{{$company->tagline}}</th>
          </tr>
          <tr>
              <th>Short Description</th>
              <td>{{$company->short_description}}</th>
          </tr>
            <tr>
              <th>Email</th>
              <td>{{$company->email}}</td>
            </tr>
            <tr>
              <th>Phone</th>
              <td>{{$company->phone}}</td>
            </tr>
            <tr>
              <th>Address</th>
              <td>{{$company->address}}</td>
            </tr>

            <tr>
              <th>BIN</th>
              <td>{{$company->bin}}</td>
            </tr>
            <tr>
              <th>Logo</th>
              <td><img src="{{asset('uploads/logo/cropped/'.$company->logo)}}" alt=""></td>
            </tr>
            <tr>
              <th>Favicon</th>
              <td><img src="{{asset('uploads/favicon/cropped/'.$company->favicon)}}" alt=""></td>
            </tr>
          <tr>
              <th>Og Image (for social media site sharing preview)</th>
              <td><img src="{{asset('uploads/favicon/cropped/'.$company->og_image)}}" alt=""></td>
          </tr>

      </table>

    </div>
  </div>
</div>
</div>


@endsection

@push('css')

@endpush


@push('js')

@endpush
