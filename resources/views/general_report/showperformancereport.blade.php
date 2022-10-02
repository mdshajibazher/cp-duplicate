@extends('layouts.adminlayout')
@section('title','Inventory User Statements')
@section('content')

  <div class="row justify-content-center">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                 Employeewise Performance Report
            </div>
            <div class="card-body">
              
              <h5>Employee Information</h5>
              <table class="table">
                <tr>
                  <td>Name</td>
                  <td>{{$employeeinfo->name}}</td>
                </tr>
               
                <tr>
                  <td>Phone</td>
                  <td>{{$employeeinfo->phone}}</td>
                </tr>
                <tr>
                  <td>Address</td>
                  <td>{{$employeeinfo->address}}</td>
                </tr>
                <tr>
                  <td>Assigned Customer/Distributor</td>
                  <td>@foreach ($customer_list as $item)
                       <span class="badge badge-warning">{{$item->name}}</span>
                  @endforeach</td>
                </tr>
            
              </table>
              <div class="mb-3">
              <h5 class="text-center mb-3"><strong>Sales Performance from {{$from->format('d-m-Y')}} to {{$to->format('d-m-Y')}} </strong></h5>
              @if(count($sales) > 0)
              <table class="table">
                <tr>
                  <td>sl</td>
                  <td>Date</td>
                  <td>customer</td>
                  <td>Amount</td>
                </tr>

                @php
                $total_sales = 0;
                @endphp
                @foreach ($sales as $key => $item)
                @php
                $total_sales = $total_sales+$item->amount;
                @endphp


                    <tr>
                      <td>{{$key+1}}</td>
                      <td>{{$item->sales_at->format('d-m-Y')}}</td>
                      <td>{{$item->user->name}}</td>
                      <td>{{$item->amount}}</td>
                    </tr>
                @endforeach
              </table>
              <h5 class="text-center">Total Sales : {{$total_sales}}</h5>
              @else

              <p class="alert alert-danger">No Sales Found !!!</p>

              @endif
            </div>

            <div class="mb-3">
                <h5 class="text-center mb-3"> <strong> Cashes from {{$from->format('d-m-Y')}} to {{$to->format('d-m-Y')}} </strong> </h5>
                @if(count($cashes) > 0)
                <table class="table">
                  <tr>
                    <td>sl</td>
                    <td>Date</td>
                    <td>customer</td>
                    <td>Amount</td>
                  </tr>
                  
                  @php
                  $total_cashes = 0;
                  @endphp
                  @foreach ($cashes as $key => $item)
                  @php
                  $total_cashes = $total_cashes+$item->amount;
                  @endphp
                      <tr>
                        <td>{{$key+1}}</td>
                        <td>{{$item->received_at->format('d-m-Y')}}</td>
                        <td>{{$item->user->name}}</td>
                        <td>{{$item->amount}}</td>
                      </tr>

                  @endforeach
                </table>
                <h5 class="text-center">Total Cashes : {{$total_cashes}}</h5>
                @else
                <p class="alert alert-danger">No Cashes Found !!!</p>
                @endif
              </div>

              <div class="mb-3">
                <h5 class="text-center mb-3"><strong> Product Returns from {{$from->format('d-m-Y')}} to {{$to->format('d-m-Y')}} </strong> </h5>
                @if(count($product_returns) > 0)
                <table class="table">
                  <tr>
                    <td>sl</td>
                    <td>Date</td>
                    <td>customer</td>
                    <td>Amount</td>
                  </tr>
                  
                  
                  @php
                  $total_returns = 0;
                  @endphp
                  @foreach ($product_returns as $key => $item)
                   
                  @php
                  $total_returns = $total_returns+$item->amount;
                  @endphp
                      <tr>
                        <td>{{$key+1}}</td>
                        <td>{{$item->returned_at->format('d-m-Y')}}</td>
                        <td>{{$item->user->name}}</td>
                        <td>{{$item->amount}}</td>
                      </tr>
                  @endforeach
                </table>

                <h5 class="text-center">Total Cashes : {{$total_returns}}</h5>
                @else
                <p class="alert alert-danger">No Returns Found !!!</p>
                @endif
              </div>

              <div class="form-group">
                  
                  <form action="{{route('report.pdfemployeewiseperformance')}}" method="POST">
                    @csrf
                    <input type="hidden" name="employee" value="{{$request->employee}}">
                    <input type="hidden" name="date_range" value="{{$request->date_range}}">
                    <button type="submit" class="btn btn-success">Generate PDF</button>
                  </form>
                  
              </div>
            </div>
        </div>

    
    </div>
  </div>

@endsection



