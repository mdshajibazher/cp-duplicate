@extends('layouts.adminlayout')
@section('title','Inventory expense')
@section('modal')
    <!-- Modal -->
    <div class="modal fade" id="expenseModal" tabindex="-1" role="dialog" aria-labelledby="expenseModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="expenseModalLabel"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="expense-form">

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
                        <div class="col-lg-4">
                            <h5 class="card-title">Expenses</h5>
                        </div>
                        <div class="col-lg-8">
                            @can('expense.create')
                                <button type="button" onclick="AdExpense('{{route('expense.store')}}')"
                                        class="btn btn-info btn-sm float-right"><i class="fa fa-plus"></i> New
                                </button>
                            @endcan
                        </div>
                    </div>

                </div>
                <div class="card-body">
                    <form action="{{route('expense.datewise')}}" method="POST">
                        @csrf
                        <div class="row mb-3 justify-content-center">
                            <div class="col-lg-1">
                                <div class="form-group">
                                    <strong>FROM : </strong>
                                </div>
                            </div>
                            <div class="col-lg-3">

                                <div class="form-group">
                                    <input type="text" class="form-control @error('start') is-invalid @enderror"
                                           name="start" id="start" placeholder="Select Start Date"
                                           value="{{Carbon\Carbon::now()->toDateString()}}">
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
                                    <input type="text" class="form-control @error('end') is-invalid @enderror"
                                           name="end" id="end" placeholder="Select End Date"
                                           value="{{Carbon\Carbon::now()->toDateString()}}">
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

                    <div class="row">
                        <div class="col-lg-12">
                            <h3 class="mt-3 mb-5 text-uppercase text-center">FROM {{$request['start']}}
                                TO {{$request['end']}}</h3>
                            <table class="table table-bordered">
                                <thead class="thead-light">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Amount</th>
                                    <th scope="col">Reasons</th>
                                    <th scope="col">Posted By</th>
                                    <th scope="col">Type</th>
                                    <th scope="col">Action</th>
                                </tr>
                                </thead>
                                <tbody id="datewise_expenses">
                                @foreach($expenses as $key => $item)
                                    <tr>
                                        <td>{{$key+1}}</td>
                                        <td>{{$item->expense_date->format('d-m-Y')}}</td>
                                        <td>{{$item->amount}}</td>
                                        <td>{{$item->reasons}}</td>
                                        <td>{{$item->admin->name}}
                                            <br><small>At {{$item->created_at->format('d-m-Y g:i a')}}</small></td>
                                        <td><span
                                                style="background: @isset($colors[$item->expensecategory->id]) {{$colors[$item->expensecategory->id] }} @else #000000  @endisset ;color: #fff"
                                                class="badge">{{$item->expensecategory->name}} </span></td>
                                        <td><a class="btn btn-warning btn-sm" onclick="EditExpense({{$item->id}})"
                                               href="javascript:void(0)"><i class="fas fa-edit"></i></a></td>
                                    </tr>
                                @endforeach


                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>

@endsection

@push('css')
    <link rel="stylesheet" href="{{asset('assets/css/flatpicker.min.css')}}">
@endpush

@push('js')

    <script src="{{asset('assets/js/axios.min.js')}}"></script>
    <script src="{{asset('assets/js/flatpicker.min.js')}}"></script>
    <script>
        let edit_permission = false;
        @can('expense.edit')
            edit_permission = true;
        @endcan
        var url = '{{url('/')}}';
        var start = '{{$request['start']}}';
        var end = '{{$request['end']}}';

        @can('All Expense List')
        var datewise_expense_url = `${url}/admin/expense/datewise/${start}/${end}`;
        @else
        var datewise_expense_url = `${url}/admin/expense/datewise/${start}/${end}?admin_id={{Auth::user()->id}}`;
        @endcan


        $("#start").flatpickr({dateFormat: 'Y-m-d'});
        $("#end").flatpickr({dateFormat: 'Y-m-d'});

        let colors = ["#34495e", "#badc58", "#16a085", "#30336b", "#EA2027", "#6F1E51", "#B53471", "#C4E538", "#2ecc71", "#eb4d4b", "#f1c40f", "#EE5A24"];

        var expensecategoriesurl = '{{route('expensecatlist')}}';
        sessionStorage.clear();
        $('#user').select2({
            width: '100%',
            theme: "bootstrap"
        });


        function AdExpense(storeurl) {
            axios.get(expensecategoriesurl)
                .then(res => {
                    let expensecategorydata = res.data;
                    let expensecatdataoption = "";
                    expensecategorydata.forEach(function (data, key) {
                        expensecatdataoption += '<option value="' + data.id + '">' + data.name + '</option>';
                    });
                    $("#expenseModalLabel").text('Add New Expense');
                    $("#expense-form").html(`  <form id="expense_form">
      <div class="form-group">
        <label for="expense_date">Date</label>
        <input type="text" class="form-control" placeholder="Select Date" name="expense_date" id="expense_date">
        <small class="text-danger expense_date_err"></small>
    </div>

    <div class="form-group">
        <label for="amont">Amount</label>
        <input type="number" class="form-control" placeholder="Enter Amount" name="amount" id="amount">
        <small class="text-danger amount_err"></small>
    </div>
    <div class="form-group">
        <label for="expensecategory_id">Expense Type</label>
        <select placeholder="Enter Expense Category" name="expensecategory_id" id="expensecategory_id" class="form-control">
          <option>-Select Expense Type-</option>
          ${expensecatdataoption}
        </select>
        <small class="text-danger expensecategory_id_err"></small>
    </div>

    <div class="form-group">
      <label for="reason">Reasons ( <small>Max 30 Charecters Allowed</small>)</label>
      <textarea class="form-control" name="reason" id="reason" placeholder="Enter Expesne Reasons"></textarea>

      <small class="text-danger reason_err"></small>
  </div>
  <div class="form-group">
      <button type="button" id="send_form" onclick="StoreExpense('${storeurl}')" class="btn btn-danger">Submit</button>
  </div>
</form>`);
                    $("#expense_date").flatpickr({dateFormat: 'Y-m-d'});
                    $("#expenseModal").modal('show');


                });
        }


        function EditExpense(id) {
            $("#expenseModalLabel").text('Edit Expense');

            function getExpenseInfo() {
                return axios.get(url + '/admin/expense/' + id + '/edit');
            }

            function getExpenseCategory() {
                return axios.get(expensecategoriesurl);
            }

            axios.all([getExpenseInfo(), getExpenseCategory()])
                .then(res => {
                    let expdata = res[0].data;
                    let ex_cat_data = res[1].data;

                    let expensecatdataoption = "";
                    ex_cat_data.forEach(function (data, key) {
                        if (data.id == expdata.expensecategory_id) {
                            expensecatdataoption += '<option value="' + data.id + '" selected>' + data.name + '</option>';
                        } else {
                            expensecatdataoption += '<option value="' + data.id + '">' + data.name + '</option>';
                        }

                    });


                    $("#expense-form").html(`<form id="expense_form">

<div class="form-group">
  <label for="expense_date">Date</label>
  <input type="text" class="form-control" placeholder="Select Date" name="expense_date" value="${expdata.expense_date}" id="expense_date">
  <small class="text-danger expense_date_err"></small>
</div>

<div class="form-group">
  <label for="amont">Amount</label>
  <input type="number" class="form-control" placeholder="Enter Amount" name="amount" id="amount" value="${expdata.amount}">
  <small class="text-danger amount_err"></small>
</div>

<div class="form-group">
        <label for="expensecategory_id">Expense Type</label>
        <select placeholder="Enter Expense Category" name="expensecategory_id" id="expensecategory_id" class="form-control">
          <option>-Select Expense Type-</option>
          ${expensecatdataoption}
        </select>
        <small class="text-danger expensecategory_id_err"></small>
    </div>

<div class="form-group">
<label for="reason">Reasons ( <small>Max 30 Charecters Allowed</small>)</label>
<textarea class="form-control" name="reason" id="reason" placeholder="Enter Expesne Reasons">${expdata.reasons}</textarea>

<small class="text-danger reason_err"></small>
</div>
<div class="form-group">
<button type="button" id="send_form" onclick="UpdateExpense(${id})" class="btn btn-danger">Update</button>
</div>
</form>`);
                    $("#expense_date").flatpickr({dateFormat: 'Y-m-d'});
                    $("#expenseModal").modal('show');
                })

                .catch(err => {
                    toastr.error(err.response.data.message);
                });


        }


        function datewiseExpense() {
            axios.get(datewise_expense_url)
                .then(res => {
                    let editBtn = "";
                    let data = res.data.data;
                    let expensedata = "";
                    var expense_category_color = "#000000";

                    if (typeof colors[data.expensecat_details.id] != 'undefined') {
                        expense_category_color = colors[data.expensecat_details.id];
                    }


                    data.forEach(function (data, key) {
                        if (edit_permission) {
                            editBtn = `<a class="btn btn-warning btn-sm" onclick="EditExpense(${data.id})" href="javascript:void(0)"><i class="fas fa-edit"></i></a>`
                        }
                        expensedata += `<tr>
                      <td>${key + 1}</td>
                      <td>${data.expense_date}</td>
                      <td>${data.amount}</td>
                      <td>${data.reasons}</td>
                      <td>${data.posted_by} <br><small>At ${data.created_at}</small></td>
                      <td><span style="background: ${expense_category_color};color: #fff" class="badge">${data.expensecategory}</span></td>
                      <td>${editBtn}</td>
                    </tr>`;
                    })
                    $("#datewise_expenses").html(expensedata);
                })

                .catch(err => {
                    console.log(err);
                })

        }


        function StoreExpense(storeurl) {
            $(".text-danger").hide().text("");
            $(".red-border").removeClass("red-border");
            $('#send_form').html('<i class="fas fa-spinner fa-spin"></i> Please Wait...').attr('disabled', true);
            let data = $("#expense_form").serialize();
            axios.post(storeurl, data)
                .then(res => {
                    $('#expenseModal').modal('hide');
                    toastr.success(res.data);
                    window.location = url + '/admin/expense';

                })

                .catch(err => {
                    let errors = err.response.data.errors;
                    console.log(errors);
                    Object.keys(errors).forEach(function (value) {
                        $("#" + value + "").addClass("red-border");
                        $("." + value + "_err").text(errors[value][0]);
                    });

                    $('#send_form').html('submit').attr('disabled', false);
                    $(".text-danger").show();


                });

        }

        function UpdateExpense(id) {
            $(".text-danger").hide().text("");
            $(".red-border").removeClass("red-border");
            $('#send_form').html('<i class="fas fa-spinner fa-spin"></i> Please Wait...').attr('disabled', true);
            let data = $("#expense_form").serialize();
            axios.put(url + '/admin/expense/' + id, data)
                .then(res => {
                    $('#expenseModal').modal('hide');
                    datewiseExpense();
                    toastr.success(res.data);
                })

                .catch(err => {
                    let errors = err.response.data.errors;
                    console.log(errors);
                    Object.keys(errors).forEach(function (value) {
                        $("#" + value + "").addClass("red-border");
                        $("." + value + "_err").text(errors[value][0]);
                    });

                    $('#send_form').html('update').attr('disabled', false);
                    $(".text-danger").show();


                });

        }

    </script>

@endpush


