
@extends('layouts.adminlayout')
@section('title','Growth Charts')
@section('content')
  <div class="row justify-content-center">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                  <h5 class="card-title">Compnay Growth Charts</h5>
            </div>
            <div class="card-body">

                <h4 class="text-center"> {{$request->start}} to {{$request->end}}</h4>

                <div class="row">
                  <div class="col-lg-6 col-md-6">
                    <canvas id="sales-chart"></canvas>
                  </div>
                  <div class="col-lg-6 col-md-6">
                    <canvas id="cashes-chart"></canvas>
                  </div>

                  <div class="col-lg-6 col-md-6">
                    <canvas id="return-products-chart"></canvas>
                  </div>
                  <div class="col-lg-6 col-md-6">
                    <canvas id="expenses-chart"></canvas>
                  </div>
                  <div class="col-lg-6 col-md-6">
                    <canvas id="orders-chart"></canvas>
                  </div>
                </div>


            </div>
        </div>
    </div>
  </div>

@endsection

@push('js')
<script src="{{asset('assets/js/axios.min.js')}}"></script>
<script src="{{asset('assets/js/chartjs.js')}}"></script>
<script>
let baseurl = '{{url('/')}}';
let from = '{{$request->start}}';
let to = '{{$request->end}}';
let type = '{{$request->type}}';
var sales_data = [];
var return_products_data = [];
var expense_data = [];
var cashes_data = [];


axios.post(baseurl+'/admin/growth_charts',{
    start: from,
    end: to,
  })
  .then(function (response) {
      console.log(response);
    var data = {};
    var config = {};

    // For sales data
    sales_data = response.data.sales_data;
    const sales_chart_labels = sales_data.sales_month_label;
         data = {
        labels: sales_chart_labels,
        datasets: [{
            label: 'Sales Chart',
            backgroundColor: '#2ecc71',
            borderColor: '#27ae60',
            data: sales_data.sales_amount,
        }]
        };
        config = {
        type: type,
        data,
        options: {}
        };
        new Chart(
            document.getElementById('sales-chart'),
            config
        );

    //For Cashes
    cashes_data = response.data.cashes_data;
    const cashes_chart_labels = cashes_data.cashes_month_label;
        data = {
        labels: cashes_chart_labels,
        datasets: [{
            label: 'Cashes Chart',
            backgroundColor: '#e67e22',
            borderColor: '#d35400',
            data: cashes_data.cash_amount,
        }]
        };

       config = {
        type: type,
        data,
        options: {}
        };

        new Chart(
            document.getElementById('cashes-chart'),
            config
        );

      //Product Returns
    return_products_data = response.data.return_products_data;
    const return_products_labels = return_products_data.return_products_month_label;
        data = {
        labels: return_products_labels,
        datasets: [{
            label: 'Product Returns Chart',
            backgroundColor: '#34495e',
            borderColor: '#34495e',
            data: return_products_data.pd_return_amount,
        }]
        };

       config = {
        type: type,
        data,
        options: {}
        };

        new Chart(
            document.getElementById('return-products-chart'),
            config
        );

    //Expenses Data
    expense_data = response.data.expenses_data;
    console.log(expense_data)
    const expense_month_label = expense_data.expense_month_label;
        data = {
        labels: expense_month_label,
        datasets: [{
            label: 'Expenses Data',
            backgroundColor: '#e74c3c',
            borderColor: '#c0392b',
            data: expense_data.expense_amount,
        }]
        };

       config = {
        type: type,
        data,
        options: {}
        };

        new Chart(
            document.getElementById('expenses-chart'),
            config
        );


            //Expenses Data
    orders_data = response.data.orders_data;

    const order_month_label = orders_data.order_month_label;
        data = {
        labels: order_month_label,
        datasets: [{
            label: 'Order Data',
            backgroundColor: '#fd9644',
            borderColor: '#fa8231',
            data: orders_data.pd_order_amount,
        }]
        };

       config = {
        type: type,
        data,
        options: {}
        };

        new Chart(
            document.getElementById('orders-chart'),
            config
        );



  })
  .catch(function (error) {
    // handle error
    console.log(error);
})


</script>
@endpush
