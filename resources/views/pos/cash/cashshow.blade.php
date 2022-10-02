@extends('layouts.adminlayout')
@section('title','Cash')
@section('modal')
    <!-- Modal -->
    <div class="modal fade" id="cashSubmissionModal" tabindex="-1" role="dialog"
         aria-labelledby="cashSubmissionModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="cashSubmissionModalLabel"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="cash-form">

                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection


                @section('content')

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <h5 class="card-title text-left">Inventory Cashes</h5>
                                        </div>
                                        <div class="col-lg-6">
                                            <button type="button" onclick="cashModalInitiate()"
                                                    class="btn btn-info btn-sm float-right"><i class="fas fa-plus"></i>
                                                 New
                                            </button>

                                        </div>

                                    </div>


                                </div>
                                <div class="card-body table-responsive">
                                    <form action="{{route('cash.result')}}" method="GET">
                                        @csrf
                                        <div class="row mb-3 justify-content-center">
                                            <div class="col-lg-1">
                                                <div class="form-group">
                                                    <strong>FROM : </strong>
                                                </div>
                                            </div>
                                            <div class="col-lg-3">

                                                <div class="form-group">
                                                    <input type="text" class="form-control @error('start') is-invalid @enderror" name="start" id="start" placeholder="Select Start Date" value="{{Carbon\Carbon::now()->toDateString()}}">
                                                    @error('start')
                                                    <small class="form-error">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-lg-1">
                                                <div class="form-group">
                                                    <strong>To : </strong>
                                                </div>
                                            </div>

                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <input type="text" class="form-control @error('end') is-invalid @enderror" name="end" id="end" placeholder="Select End Date" value="{{Carbon\Carbon::now()->toDateString()}}">
                                                    @error('end')
                                                    <small class="form-error">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                            </div>


                                            <div class="col-lg-2">
                                                <div class="form-group">
                                                    <button type="submit" class="btn btn-info">filter</button>
                                                </div>

                                            </div>
                                        </div>
                                    </form>
                                    <table class="table table-bordered table-striped table-hover mt-3"
                                           id="jq_datatables">
                                        <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Date</th>
                                            <th scope="col">Customer</th>
                                            <th scope="col">Amount</th>
                                            <th scope="col">Discount</th>
                                            <th scope="col">Status</th>
                                            <th scope="col">Reference</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @php
                                            $i =1;
                                        @endphp
                                        @foreach ($cashes as $cash)
                                            <tr>
                                                <td>{{$i++}}</td>
                                                <td>{{$cash->received_at->format('d-m-Y')}}</td>
                                                <td>{{$cash->user->name}}</td>
                                                <td>{{$cash->amount}}</td>
                                                <td>{{round($cash->discount)}}</td>
                                                <td>{!!InvCashStatus($cash->status)!!}</td>
                                                <td>{{$cash->reference}}</td>
                                                <td>
                                                    <button class="btn btn-primary btn-sm" id="open_modal"
                                                            onclick="editCashModalInitiate({{$cash->id}})"><i class="fas fa-edit"></i>
                                                    </button>
                                                    | <a class="btn btn-sm btn-info"
                                                         href="{{route('cash.show',$cash->id)}}"><i
                                                            class="fas fa-eye"></i></a>


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
                    <link rel="stylesheet" href="{{asset('assets/css/flatpicker.min.css')}}">
                    <link rel="stylesheet" href="{{asset('assets/css/dataTables.bootstrap4.min.css')}}">
                @endpush

                @push('js')
                    <script src="{{asset('assets/js/flatpicker.min.js')}}"></script>
                    <script src="{{asset('assets/js/datatables.min.js')}}"></script>
                    <script src="{{asset('assets/js/dataTables.bootstrap4.min.js')}}"></script>
                    <script src="{{asset('assets/js/axios.min.js')}}"></script>
                    <script>
                        $("#start").flatpickr({dateFormat: 'Y-m-d'});
                        $("#end").flatpickr({dateFormat: 'Y-m-d'});
                        $('#jq_datatables').DataTable();

                        $('form').on('focus', 'input[type=number]', function (e) {
                            $(this).on('wheel.disableScroll', function (e) {
                                e.preventDefault()
                            })
                        })
                        $('form').on('blur', 'input[type=number]', function (e) {
                            $(this).off('wheel.disableScroll')
                        })

                        let baseUrl = '{{url('/')}}';
                        cash_store_url = '{{route('cash.store')}}';

                        var last10cashurl = '{{route('cash.last10')}}';
                        var url = '{{url('/')}}';

                        function getUserDetailsAndDueInfo() {
                            var user_id = $("#user option:selected").val();

                            function getUserInfo() {
                                return axios.get(baseUrl + "/api/userinfo/" + user_id);
                            }

                            function getDueInfo() {
                                return axios.get(baseUrl + "/api/invdueinfo/" + user_id);
                            }

                            axios.all([getUserInfo(), getDueInfo()])
                                .then(function (results) {
                                    const USERINFO = JSON.parse(results[0].request.response);
                                    $('#user-details').show();
                                    $("#user-details").html("<div class='user-deatils'><h4 class='text-center'> " + USERINFO.name + "</h4><br><b>Address :</b> " + USERINFO.address + "<br><b>Phone :</b> " + USERINFO.phone + "<br><b>Email :</b>" + USERINFO.inventory_email + "</div>");
                                    const DUEINFO = results[1].request.response;
                                    $("#due").html('Current Due: <span>' + DUEINFO + '</span>/-');
                                });

                        };



                        function calcaulateAmount(event) {
                            let current_amount = document.getElementById("amount").value;
                            if (!!current_amount == false) {
                                toastr.info('Attention', 'Please Type amount first before adjust discount');
                                document.getElementById("discount").value = 0;
                                return;
                            }
                            let discount_amount = event.target.value;
                            if (current_amount != "" && discount_amount != "") {
                                let new_amount = parseFloat(current_amount) - parseFloat(discount_amount);
                                if (parseFloat(discount_amount) > parseFloat(current_amount)) {
                                    toastr.info('Attention', 'Discount amount cant be greater than amount');
                                    new_amount = 0;
                                    document.getElementById("discount").value = 0;
                                } else if (new_amount < 0) {
                                    toastr.info('Attention', 'Actual amount must not be negative');
                                    new_amount = 0;
                                    document.getElementById("discount").value = 0;
                                }
                                document.getElementById("amount-alert").innerText = new_amount;
                                if (!!discount_amount && new_amount > 0) {
                                    $(".amount-alert-wrapper").show();
                                } else {
                                    $(".amount-alert-wrapper").hide();
                                }
                            }
                        }

                        function resetDiscount(event) {
                            document.getElementById("discount").value = 0;
                        }


                    //     function last10CashRelatedActivity() {
                    //         axios.get(last10cashurl)
                    //             .then(res => {
                    //                 let data = res.data;
                    //                 let cashdata = "";
                    //                 var cash_category_color = "#000000";
                    //                 data.forEach(function (data, key) {
                    //                     cashdata += `<tr>
                    //   <td class="align-middle">${key + 1}</td>
                    //   <td class="align-middle">${new Date(data.received_at).toLocaleDateString()}</td>
                    //   <td class="align-middle">${data.user.name}</td>
                    //   <td class="align-middle"><small>${data.paymentmethod.name}</small></td>
                    //   <td class="align-middle">${data.amount}</td>
                    //   <td class="align-middle">${data.posted_by} <br><small>At ${new Date(data.created_at)}</small></td>
                    //   <td class="align-middle">${PaymentStatus(data.status)}</td>
                    //   <td class="align-middle"><a class="btn btn-warning btn-sm"  onclick="editCashModalInitiate(${data.id})"  href="javascript:void(0)"><i class="fas fa-edit"></i></a></td>
                    // </tr>`;
                    //                 });
                    //                 $("#last_ten_cashes").html(cashdata);
                    //             })
                    //
                    //             .catch(err => {
                    //                 console.log(err);
                    //             });
                    //
                    //     }


                        function cashModalInitiate() {

                            let cashSubmissionFormData = `   <form  id="store_cash_form">
            <div class="form-group">
           <h5 id="due" style="color: red;text-align: right"></h5>
        </div>
          <div class="form-group">
            <label for="received_at">Cash Receive Date</label>
            <input type="text" class="form-control" name="received_at" id="received_at" value="{{Carbon\Carbon::now()->toDateString()}}">

            <small class="form-error received_at_err"></small>

            </div>
            <div class="form-group">
              <label for="user">Customer</label>
              <select data-placeholder="Select a Customer" name="user" id="user" onchange="getUserDetailsAndDueInfo()" class="form-control" required>
              <option></option>
              @foreach ($users as $user)
                            <option value="{{$user->id}}">{{$user->name}}</option>
              @endforeach
                            </select>

                            <small class="form-error user_err"></small>

                            <div id="user-details"></div>
                          </div>
                          <div class="d-flex justify-content-between">
                              <div class="form-group">
                                <label for="amount">Amount</label>
                              <input oninput="resetDiscount()" type="number" class="form-control" name="amount" id="amount" placeholder="Enter Amount" required>

                                <small class="form-error amount_err"></small>

                                </div>
                                 <div class="form-group">
                                     <label for="amount">Discount</label>
                                     <input oninput="calcaulateAmount(event)" type="number" class="form-control" name="discount" id="discount" placeholder="Enter Discount Amount"  value="0" required>

                                <small class="form-error discount_err"></small>
                                </div>
                            </div>
                            <div class="form-group amount-alert-wrapper"  style="display: none">
                                <p class="alert alert-info">Actual paid amount  <b id="amount-alert">0</b></p>
                            </div>


                           <div class="form-group">
                             <label for="payment_method">Payment Method</label>
                             <select data-placeholder="Select Payment Method" name="payment_method" id="payment_method" class="form-control" required>
                              <option></option>
@foreach ($payment_methods as $pmd)
                            <option value="{{$pmd->id}}">{{$pmd->name}}</option>
              @endforeach
                            </select>

                            <small class="form-error payment_method_err"></small>

                            </div>

                            <div class="form-group">
                              <label for="reference">Reference</label>
                            <input type="text" class="form-control" name="reference" id="reference" placeholder="Enter Referance" >
                            <small class="form-error reference_err"></small>

                            </div> <div class="form-group">
                                    <button type="button" id="send_form_button" onclick="cashStoreProcess()" class="btn btn-dark btn-sm">Submit</button>
                            </div></form>`

                            $("#cashSubmissionModalLabel").html('Submit New Cash Entry');
                            $("#cash-form").html(cashSubmissionFormData);
                            $("#received_at").flatpickr({dateFormat: 'Y-m-d'});
                            $('#user').select2({
                                width: '100%',
                                theme: "bootstrap"
                            });
                            $("#cashSubmissionModal").modal('show');


                        }


                        function cashStoreProcess() {
                            $(".form-error").hide().text("");
                            $(".red-border").removeClass("red-border");
                            $('#send_form_button').html('<i class="fas fa-spinner fa-spin"></i> Please Wait...').attr('disabled', true);
                            let data = $("#store_cash_form").serialize();
                            axios.post(cash_store_url, data)
                                .then(res => {
                                    $('#cashSubmissionModal').modal('hide');
                                    toastr.success(res.data.message);
                                    location.reload();
                                })

                                .catch(err => {
                                    let errors = err.response.data.errors;
                                    console.log(errors);
                                    Object.keys(errors).forEach(function (value) {
                                        $("#" + value + "").addClass("red-border");
                                        $("." + value + "_err").text(errors[value][0]);
                                    });
                                    $('#send_form_button').html('Submit').attr('disabled', false);
                                    $(".form-error").show();
                                });

                        }

                        function PaymentStatus(argument) {
                            status = "";
                            if (argument == 0) {
                                status = `<span class="badge badge-warning">pending for approval</span>`;
                            } else if (argument == 1) {
                                status = `<span class="badge badge-success">paid</span>`;
                            } else if (argument == 2) {
                                status = `<span class="badge badge-danger">cancelled</span>`;
                            }
                            return status;
                        }


                        function editCashModalInitiate(id) {
                            axios.get(baseUrl + '/admin/pos/cash/' + id + '/edit')
                                .then(res => {
                                    let cash_info = res.data
                                    let cashSubmissionFormData = ` <form id="update_cash_form">
            <div class="form-group">
           <h5 id="due" style="color: red;text-align: right"></h5>
        </div>
          <div class="form-group">
            <label for="received_at">Cash Receive Date</label>
            <input type="text" class="form-control" name="received_at" id="received_at" value="${cash_info.received_at}">

            <small class="form-error received_at_err"></small>

            </div>
            <div class="form-group">
              <label for="user">Customer</label>
              <select data-placeholder="Select a Customer" name="user" id="user" onchange="getUserDetailsAndDueInfo()" class="form-control" required>
              <option></option>
              @foreach ($users as $user)
                                    <option value="{{$user->id}}">{{$user->name}}</option>
              @endforeach
                                    </select>

                                    <small class="form-error user_err"></small>

                                    <div id="user-details"></div>
                                  </div>

                                            <div class="d-flex justify-content-between">
                              <div class="form-group">
                                <label for="amount">Amount</label>
                              <input oninput="resetDiscount()" type="number" class="form-control" name="amount" id="amount" placeholder="Enter Amount" value="${Math.round(cash_info.amount)}" required>

                <small class="form-error amount_err"></small>

                </div>
                 <div class="form-group">
                     <label for="amount">Discount</label>
                     <input oninput="calcaulateAmount(event)" type="number" class="form-control" name="discount" id="discount" placeholder="Enter Discount Amount"  value="${Math.round(cash_info.discount)}" required>

                <small class="form-error discount_err"></small>
                </div>
            </div>
            <div class="form-group amount-alert-wrapper"  style="display: none">
                <p class="alert alert-info">Actual paid amount  <b id="amount-alert">0</b></p>
            </div>

           <div class="form-group">
             <label for="payment_method">Payment Method</label>
             <select data-placeholder="Select Payment Method" name="payment_method" id="payment_method" class="form-control" required>
              <option></option>
              @foreach ($payment_methods as $pmd)
                                    <option value="{{$pmd->id}}">{{$pmd->name}}</option>
              @endforeach
                                    </select>

                                    <small class="form-error payment_method_err"></small>

                                    </div>

                                    <div class="form-group">
                                      <label for="reference">Reference</label>
                                    <input type="text" class="form-control" name="reference" id="reference" placeholder="Enter Referance" value="${cash_info.reference}">
            <small class="form-error reference_err"></small>

            </div> <div class="form-group">
                    <button type="button" id="update_form_button" onclick="cashUpdateProcess(${cash_info.id})" class="btn btn-dark btn-sm">Update</button>
            </div></form>`

                                    $("#cashSubmissionModalLabel").html('Submit New Cash Entry');
                                    $("#cash-form").html(cashSubmissionFormData);
                                    $("#received_at").flatpickr({dateFormat: 'Y-m-d'});
                                    $('#user').select2({
                                        width: '100%',
                                        theme: "bootstrap",
                                    });
                                    $("#payment_method").val(cash_info.paymentmethod_id);
                                    $("#user").val(cash_info.user_id).trigger('change');
                                    $("#cashSubmissionModal").modal('show');
                                })
                                .catch(e => {
                                    console.log(e);
                                    toastr.error(e.response.data.message);
                                })

                        }


                        function cashUpdateProcess(col_id) {
                            $(".form-error").hide().text("");
                            $(".red-border").removeClass("red-border");
                            $('#update_form_button').html('<i class="fas fa-spinner fa-spin"></i> Please Wait...').attr('disabled', true);
                            let data = $("#update_cash_form").serialize();
                            axios.put(`${baseUrl}/admin/pos/cash/${col_id}`, data)
                                .then(res => {
                                    $('#cashSubmissionModal').modal('hide');
                                    toastr.success(res.data.message);
                                    location.reload();

                                })

                                .catch(err => {
                                    let errors = err.response.data.errors;
                                    console.log(errors);
                                    Object.keys(errors).forEach(function (value) {
                                        $("#" + value + "").addClass("red-border");
                                        $("." + value + "_err").text(errors[value][0]);
                                    });
                                    $('#update_form_button').html('Update').attr('disabled', false);
                                    $(".form-error").show();
                                });

                        }

                    </script>




                    </script>
            @endpush
