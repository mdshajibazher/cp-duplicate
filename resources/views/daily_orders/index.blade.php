@extends('layouts.adminlayout')
@section('title','Daily Order')
@section('modal')
@section('modal')
    <!-- Modal -->
    <div class="modal fade" id="dailyOrderModal" tabindex="-1" role="dialog" aria-labelledby="dailyOrderModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="dailyOrderModalLabel"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="order-body">

                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
@endsection
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <div>
                            <a href="{{route('daily_orders.create')}}" class="btn btn-info btn-sm"><i class="fas fa-plus"></i> Add New Entry</a>
                        </div>

                        <h5 class="card-title text-left">Daily Orders</h5>
                    </div>

                </div>
                <div class="card-body table-responsive">


                    <table class="table table-bordered  table-hover mt-3" id="jq_datatables">
                        <thead>
                        <tr>
                            <th>sl</th>
                            <th>ID</th>
                            <th>Date</th>
                            <th>Customer</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>

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
    <script src="{{asset('assets/js/axios.min.js')}}"></script>
    <script src="{{asset('assets/js/datatables.min.js')}}"></script>
    <script src="{{asset('assets/js/dataTables.bootstrap4.min.js')}}"></script>
    <script>
        let approval_permission = false;
        let order_approve_url = '{{route('daily_orders.approve')}}';
        @can('Approve Daily Order')
            approval_permission = true;
        @endcan
        //Toater Alert
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            onOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        })
        let baseUrl = '{{url('/')}}';
        let approveUrl = '{{route('daily_orders.approve')}}';



            var ajaxDatatable =  $('#jq_datatables').DataTable({
                "order": [[0, 'desc']],
                searchDelay: 1200,
                processing: true,
                serverSide: true,
                searching: true,
                ajax: '{!! route('daily_orders.index') !!}',
                columns: [
                    {data:'DT_RowIndex',name:'DT_RowIndex',orderable: false, searchable: false},
                    {data: 'id', name: 'id'},
                    {data: 'date', name: 'date'},
                    {data: 'customer', name: 'customer'},
                    {data: 'amount', name: 'amount'},
                    {data: 'status', name: 'status'},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ]
            });




        function showOrderData (id){
            axios.get(baseUrl+'/admin/daily_orders/'+id)
            .then( res => {
                let order_body = "";
                let product_details = "";
                let orderData = res.data;
                let productObject = orderData.product;
                let s_total = 0;
                if (productObject.length > 0) {
                    productObject.forEach(ele => {
                        let qty = parseFloat(ele.pivot.qty);
                        let price = parseFloat(ele.pivot.price);
                        let total = qty * price;
                        s_total += total;
                        product_details += `<tr> <td>${ele.product_name}</td>  <td>${qty}</td>  <td> ${price}</td>  <td>${total} </td> </tr>`;
                    })
                }
                let bottom_portion = "";

                pdf_form =  `<form action="{{route('daily_orders.pdf')}}" method="post" class="mt-3">
          @csrf
                <input type="hidden" name="daily_order_id" value="${orderData.id}"/>
        <button type="submit" class="btn btn-sm btn-dark">Generate PDF</button>
</form>`;

                if(orderData.status != 1){
                    if(approval_permission){
                        bottom_portion = `<button onclick="approveOrder(${orderData.id})" type="button" id="approve-button" class="btn btn-success"><i class="fas fa-check-circle-o"></i> Approve</button>`
                    }
                }else{
                    bottom_portion = pdf_form;
                }

                order_body += `<table class="table p-3 table-sm table-borderless">
                                        <tr>
                                            <td>Date:</td>
                                            <td> ${new Date(orderData.date).toLocaleString("en-IN", {dateStyle: "long"})}</td>
                                        </tr>
                                        <tr>
                                            <td>Referance:</td>
                                            <td> <small>${orderData.references}</small></td>
                                        </tr>
                                       <tr>
                                            <td>Customer:</td>
                                            <td> ${orderData.user.name}</td>
                                        </tr>
                                        <tr>
                                            <td>Address:</td>
                                            <td> <small>${orderData.user.address}</small></td>
                                        </tr>
                                        <tr>
                                            <td>Phone:</td>
                                            <td> <small>${orderData.user.phone}</small></td>
                                        </tr>
                                    </table>

<hr>

                            <h5 class="text-center">Product Information</h5>
	<table class="table table-sm">
	 <tr style="background: #ddd">
		<td>Product:</td>
		<td>Qty</td>
		<td>Price</td>
		<td>Total</td>
	</tr>
	${product_details}
	</table>
	<table class="table table-sm">
		<tr>
			<th>Subtotal: </th>
			<th>${s_total}</th>
		</tr>
		<tr>
			<th>Discount: </th>
			<th>${Math.round(orderData.discount)}</th>
		</tr>
		<tr>
			<th>Carrying: </th>
			<th>${Math.round(orderData.shipping)}</th>
		</tr>


		<tr>
			<th>Total: </th>
			<th>${Math.round(orderData.amount)}</th>
		</tr>
	</table>
     <div class="d-flex justify-content-between">
    <div class="single">
    <p>Service Provided By :</p>
	<hr>
	<b>${orderData.admin.name}</b> <br>
	<small>at ${new Date(orderData.created_at).toLocaleString()}</small>
     </div>
    <div class="single">
           ${bottom_portion}
</div>
    </div>
`;
                $(".modal-title").text(orderData.user.name);
                $("#order-body").html(order_body);
                $("#dailyOrderModal").modal('show');
            })
            .catch(e => {
                Toast.fire({
                    icon: 'error',
                    title: e.response.data.message
                })
            })
        }

        function approveOrder(id){
            $('#approve-button').html('<i class="fas fa-spinner fa-spin"></i> Please Wait...').attr('disabled', true);
            axios.post(order_approve_url,{id})
                .then(function (response) {
                    let feedback = JSON.parse(response.request.response);
                    toastr.success(feedback.message, 'Notifications')
                    $("#dailyOrderModal").modal('hide');

                })
                .catch(function (error) {
                    toastr.error(error.response.data.message, error.response.status)
                    console.log(error);
                })
                .finally(() => {
                    $('#approve-button').html('Approve').attr('disabled', false);
                    //$('#jq_datatables').data.reload();
                    $('#jq_datatables').DataTable().ajax.reload();
                })
        }


    </script>

@endpush
