@extends('layouts.adminlayout')
@section('title','Order Form')

@section('content')

    <div class="card">
        <div class="card-header">
            <a class="btn btn-info btn-sm" href="{{route('daily_orders.index')}}"><i
                    class="fa fa-angle-left"></i> back</a>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-lg-7">
                    <div class="card">
                        <div class="card-header">
                            Order Form
                        </div>
                        <div>

                            <form onsubmit="submitProcess(event)" id="daily_order_form"
                                  style="border: 1px solid #ddd;padding: 20px;border-radius: 5px"
                                  onkeydown="removeError()">
                                <div class="form-errros"></div>
                                <div class="form-group">
                                    <label for="sales_date">Date</label>
                                    @php
                                        $date = Carbon\Carbon::now();
                                    @endphp
                                    <input type="text" class="form-control" name="date" id="date"
                                           value="{{ isset($dailyOrder) ? old('date',$dailyOrder->date) :  old('date',$date) }}"
                                           readonly>
                                    <small class="date_err text-danger err_form"></small>
                                </div>

                                <div class="form-group">
                                    <label for="customers">Customer </label>
                                    <select class="js-example-responsive" name="user_id" id="user_id"
                                            class="form-control">
                                    </select>
                                    <p class="user_id_err err_form text-danger"></p>
                                </div>

                                <div class="form-group">
                                    <h5>Order Details</h5>
                                    <br>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="product">Product</label>
                                                <select data-placeholder="select a product"
                                                        class="js-example-responsive"
                                                        name="product" id="product" class="form-control">
                                                </select>
                                                <div class="product_err err_form"></div>
                                            </div>
                                            <div class="form-group">
                                                <span class="text-center" id="selected-product-info"></span>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">

                                            <div class="form-group">
                                                <label for="qty">qty</label>
                                                <input type="text" class="form-control" name="qty" id="qty"
                                                       placeholder="qty">
                                                <div class="qty_err"></div>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="qty">price</label>
                                                <input type="text" class="form-control" name="price" id="price"
                                                       placeholder="Price">
                                                <div class="price_err"></div>
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="my-3">
                                                <button type="button" class="btn btn-warning btn-block  add-to-cart">ADD
                                                    <i
                                                        class="fa fa-plus"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-striped" id="qty-details-table"
                                                   style="display: none">
                                                <thead>
                                                <tr>
                                                    <td>Sl.</td>
                                                    <td>Name</td>
                                                    <td>qty</td>
                                                    <td>price</td>
                                                    <td>Total</td>
                                                    <td>Action</td>
                                                </tr>
                                                </thead>

                                                <tbody class="show-cart">

                                                </tbody>

                                            </table>
                                            <div class="no-product-notice"><p class="alert alert-danger">No Product
                                                    Added</p></div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <span>Discount: </span>
                                            <p><input type="number" oninput="assignDiscount(event)" class="form-control"
                                                      name="discount" id="discount"></p>
                                        </div>
                                        <div class="col-lg-6">
                                            <span>Shipping: </span>
                                            <p><input class="form-control" oninput="assignShipping(event)" type="number"
                                                      name="shipping" id="shipping"></p>
                                        </div>
                                    </div>
                                    <div class="row" id="amount-info"></div>
                                </div>


                                <div class="form-group">
                                    <label for="references">References / Notes</label>
                                    <textarea class="form-control " name="references" id="references"
                                              rows="7">{{ isset($dailyOrder) ? $dailyOrder->references :  "" }}</textarea>
                                    <p class="references_err err_form text-danger"></p>
                                </div>

                                <div class="form-group">
                                    <button id="submit_button" type="submit" class="btn btn-success">@isset($dailyOrder)
                                            Update @else Create @endisset</button>
                                </div>


                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="card">
                        <div class="card-header">
                            Last 20 Order of {{Auth::user()->name}}
                        </div>
                        <div>
                            <div class="last-few-order">
                                <table class="table table-sm table-borderless p-2 d-block"
                                       id="order-body">

                                </table>
                            </div>
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
        $('#user_id').select2({
            ajax: {
                url: "{{route('get_customers')}}",
                type: "post",
                dataType: 'json',
                delay: 500,
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
            placeholder: "Select a  customer",
        });

        $('#product').select2({
            ajax: {
                url: "{{route('get_products')}}",
                type: "post",
                dataType: 'json',
                delay: 500,
                data: function (params) {
                    return {
                        _token: CSRF_TOKEN,
                        search: params.term // search term
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
        }).on('select2:select', function (event) {
            var selected_data = event.params.data;
            $("#price").val(Math.round(selected_data.price));
        });

        $('input[type=number]').on('wheel', function (e) {
            return false;
        });
        var discount_amount = 0;
        var shipping_amount = 0;
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        let submissionUrl = "";
        let editMode = {{isset($dailyOrder) ? 1 : 0}};
        @if(isset($dailyOrder))
            submissionUrl = '{{route('daily_orders.update',$dailyOrder->id)}}';
        let userId = {{$dailyOrder->user->id }};
        let userName = '{{ $dailyOrder->user->name }}';
        let productObject = {!!$dailyOrder->product!!};
        let user_select = $("#user_id");
        discount_amount = {{round($dailyOrder->discount)}};
        shipping_amount = {{round($dailyOrder->shipping)}};
        $("#discount").val(discount_amount);
        $("#shipping").val(shipping_amount);
        user_option = new Option(userName, userId, true, true);
        user_select.append(user_option).trigger('change');
        @else
            submissionUrl = '{{route('daily_orders.store')}}';
        @endif

        @isset($productJSON)
        let PDJSON = {!! $productJSON !!};
        sessionStorage.setItem('qtyCart', JSON.stringify(PDJSON));
        @endisset

        function removeError() {
            $(".is-invalid").removeClass('is-invalid');
            $(".red-border").removeClass('red-border');
            $(".text-danger").text('');
            $(".err_form").text('');
        }

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
        getLastFewOrder();

        function getLastFewOrder() {
            $("#order-body").html('<i class="fas fa-spinner fa-spin"></i> Please Wait while loading ...');
            axios.get('{{route('daily_orders_by.admin')}}')
                .then(res => {
                    let order_body = "";
                    let product_details = "";
                    res.data.forEach((ele, index) => {
                        let productObject = ele.product;
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

                        order_body += `<tr style="background: #f7f1e3;display: block;border-radius: 10px" class="my-3 py-3">
                                <td><h1 class="badge.badge.danger">${index + 1}</h1></td>
                                <td>

    <table class="table table-sm">
    <tr>
	  <td>Invoice ID</td>
	  <td>#${ele.id}</td>
	</tr>
	<tr>
	  <td>Date</td>
	  <td>${new Date(ele.date).toLocaleString("en-IN", {dateStyle: "long"})}</td>
	</tr>
	<tr>
      <td>Customer</td>
	  <td>${ele.user.name}</td>
	</tr>
	<tr>
      <td>Phone</td>
	  <td>${ele.user.phone}</td>
	</tr>
	<tr>
      <td>Address</td>
	  <td>${ele.user.address}</td>
	</tr>
	<tr>
      <td>Approval Status</td>
	  <td>-</td>
	</tr>

</table>
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
			<th>${Math.round(ele.discount)}</th>
		</tr>
		<tr>
			<th>Carrying: </th>
			<th>${Math.round(ele.shipping)}</th>
		</tr>


		<tr>
			<th>Total: </th>
			<th>${Math.round(ele.amount)}</th>
		</tr>
	</table>

    <p>Service Provided By :</p>
	<hr>
	<b>${ele.admin.name}</b> <br>
	<small>at ${new Date(ele.created_at).toLocaleString()}</small>
</td>
   </tr>`;
                        product_details = "";
                    });
                    $("#order-body").html(order_body);
                })
                .catch(e => {
                    Toast.fire({
                        icon: 'error',
                        title: e.response.data.message
                    })
                })

        }


        function submitProcess(event) {
            event.preventDefault();
            $(".red-border").removeClass("red-border");
            $(".err_form").text('');
            $(".form-errros").text('');
            $('#submit_button').html('<i class="fas fa-spinner fa-spin"></i> Please Wait...').attr('disabled', true);
            let date = $("#date").val();
            let user_id = $("#user_id").val();
            let product_details = sessionStorage.getItem('qtyCart');
            let references = $("#references").val();
            let RequestMethod = editMode ? 'put' : 'post';
            let discount = !!discount_amount ? discount_amount : 0;
            let shipping = !!shipping_amount ? shipping_amount : 0;
            axios[RequestMethod](submissionUrl, {date, user_id, product_details, discount, shipping, references})
                .then(res => {
                    Toast.fire({
                        icon: 'success',
                        title: res.data.message
                    })
                    if(RequestMethod.toUpperCase() !== 'PUT') {
                        sessionStorage.removeItem('qtyCart');
                        qtyCart.clearCart();
                        $("#references").val('');
                        $("#date").val('');
                        $("#discount").val('');
                        $("#shipping").val('');
                        $("#user_id").val('').trigger("change");
                        discount_amount = 0;
                        shipping_amount = 0;
                        ;
                    }
                    displayCart();
                    getLastFewOrder();
                })
                .catch(e => {
                    Toast.fire({
                        icon: 'error',
                        title: e.response.data.message
                    })

                    let errors = e.response.data.errors;
                    let formErrors = `<ul class="alert alert-danger">`;
                    Object.keys(errors).forEach(function (value) {
                        formErrors += `<li>${errors[value][0]}</li>`;
                        $("#" + value + "").addClass("red-border");
                        $("." + value + "_err").text(errors[value][0]);
                    });
                    formErrors += `</ul>`;

                    $(".form-errros").html(formErrors);
                })
                .finally(() => {
                    let buttontext = editMode ? 'Update' : 'Create';
                    $('#submit_button').text(buttontext).attr('disabled', false);
                    ;
                })
        }


        $("#date").flatpickr({dateFormat: 'Y-m-d', allowInput: true});


        function assignDiscount(e) {
            let temp_amount = e.target.value;
            discount_amount = !!temp_amount ? temp_amount : 0;
            displayAmount();
        }

        function assignShipping(e) {
            let temp_amount = e.target.value;
            shipping_amount = !!temp_amount ? temp_amount : 0;
            displayAmount();
        }

        function displayAmount() {
            amount_info = `<div class="col-lg-12">
<div class="d-flex justify-content-between">
    <h5>Subtotal</h5>
    <h5>${qtyCart.totalCart()}</h5>
</div>
<div class="d-flex justify-content-between">
    <h5>Discount</h5>
    <h5>${discount_amount}</h5>
</div>
<div class="d-flex justify-content-between">
    <h5>Shipping</h5>
    <h5>${shipping_amount}</h5>
</div>
<div class="d-flex justify-content-between">
    <h5>Grand Total</h5>
    <h5>${(parseFloat(qtyCart.totalCart()) - parseFloat(discount_amount)) + parseFloat(shipping_amount)}</h5>
</div>
</div>
                    `;
            $("#amount-info").html(amount_info);
        }


        function displayCart() {
            pd_output = '';
            var subtotal = qtyCart.totalCart();
            var cartArray = qtyCart.listCart();
            var j = 1;
            for (var i in cartArray) {
                pd_output += `<tr>
                    <td>${j++}</td>
                    <td> ${cartArray[i].o_name} </td>
                    <td>${cartArray[i].qty}</td>
                    <td>${cartArray[i].price}</td>
                    <td>${parseFloat(cartArray[i].qty) * parseFloat(cartArray[i].price)}</td>
                    <td><button class="delete-item btn btn-sm badge-danger" data-name="${cartArray[i].name}">X</button></td>
                    </tr>`;
            }

            $('.show-cart').html(pd_output);
            displayAmount();
            if (sessionStorage.qtyCart && sessionStorage.qtyCart.length > 2) {
                $("#qty-details-table").show();
                $(".no-product-notice").hide();
            } else {
                $("#qty-details-table").hide();
                $(".no-product-notice").show();
            }

        }

        function isNumber(n) {
            return !isNaN(parseFloat(n)) && !isNaN(n - 0)
        }


        // ************************************************
        // Shopping Cart API
        // ************************************************


        var qtyCart = (function () {
            // =============================
            // Private methods and propeties
            // =============================
            cart = [];

            // Constructor
            function Item(o_name, name, qty, price, id) {
                this.o_name = o_name;
                this.name = name;
                this.qty = qty;
                this.price = price;
                this.id = id;

            }

            // Save cart
            function saveCart() {
                sessionStorage.setItem('qtyCart', JSON.stringify(cart));
            }

            function loadCart() {
                cart = JSON.parse(sessionStorage.getItem('qtyCart'));
            }

            if (sessionStorage.getItem("qtyCart") != null) {
                loadCart();
            }


            // =============================
            // Public methods and propeties
            // =============================
            var obj = {};

            // Add to cart
            obj.IncrementCart = function (name) {
                for (var item in cart) {
                    if (cart[item].name === name) {
                        cart[item].count++;
                        saveCart();
                        return;
                    }
                }
                var item = new Item(name);
                cart.push(item);
                saveCart();
            }


            obj.addItemToCart = function (o_name, name, qty, price, id) {
                for (var item in cart) {
                    if (cart[item].id === id) {
                        Toast.fire({
                            icon: 'error',
                            title: '"' + o_name + '" Already Added'
                        });

                        return;
                    }
                }


                var item = new Item(o_name, name, qty, price, id);
                cart.push(item);
                saveCart();
                Toast.fire({
                    icon: 'success',
                    title: 'Successfully Added'
                });

            }


            // Set count from item
            obj.setCountForItem = function (name, count) {
                for (var i in cart) {
                    if (cart[i].name === name) {
                        cart[i].count = count;
                        break;
                    }
                }
            };
            // Remove item from cart
            obj.removeItemFromCart = function (name) {
                for (var item in cart) {
                    if (cart[item].name === name) {
                        cart[item].count--;
                        if (cart[item].count === 0) {
                            cart.splice(item, 1);
                        }
                        break;
                    }
                }
                saveCart();
            }

            // Remove all items from cart
            obj.removeItemFromCartAll = function (name) {
                for (var item in cart) {
                    if (cart[item].name === name) {
                        Toast.fire({
                            icon: 'success',
                            title: '<strong style="color: red">' + cart[item].name + '</strong> &nbsp; Removed Successfully'
                        });
                        cart.splice(item, 1);

                        break;
                    }
                }
                saveCart();
            }

            // Clear cart
            obj.clearCart = function () {
                cart = [];
                saveCart();
            }

            // Count cart
            obj.totalCount = function () {
                var totalCount = 0;
                for (var item in cart) {
                    totalCount++;
                    //totalCount += cart[item].count;
                }
                return totalCount;
            }

            // Total cart
            obj.totalCart = function () {
                var totalCart = 0;
                for (var item in cart) {
                    totalCart += cart[item].qty * cart[item].price;
                }
                return Number(totalCart.toFixed(2));
            }

            // List cart
            obj.listCart = function () {
                var cartCopy = [];
                for (i in cart) {
                    item = cart[i];
                    itemCopy = {};
                    for (p in item) {
                        itemCopy[p] = item[p];

                    }
                    itemCopy.total = Number(item.qty * item.count).toFixed(2);
                    cartCopy.push(itemCopy)
                }
                return cartCopy;
            }


            return obj;
        })();


        function checkError(error_element, err) {
            let dom_element_value = $("#" + error_element).val();
            if (dom_element_value.length === 0) {
                $("#" + error_element).addClass('is-invalid');
                $("." + error_element + "_err").addClass('invalid-feedback').text(error_element + ' Field is Required');
                err.push('qty');
            } else if (dom_element_value < 1) {
                $("#" + error_element).addClass('is-invalid');
                $("." + error_element + "_err").addClass('invalid-feedback').text(error_element + ' Negative Number Not Allowed');
                err.push('qty');
            } else if (isNumber(dom_element_value) == false) {
                $("#" + error_element).addClass('is-invalid');
                $("." + error_element + "_err").addClass('invalid-feedback').text(error_element + ' Field Must Be Numeric')
                err.push('qty');
            } else {
                $("#" + error_element).removeClass('is-invalid');
            }
        }


        // *****************************************
        // Triggers / Events
        // *****************************************

        // Add item
        $('.add-to-cart').click(function (event) {
            event.preventDefault();
            $('.cart-hover').show().delay(5000).fadeOut();
            var product_id = $("#product").val();
            var o_name = $("#product option:selected").text();
            var name = o_name.replace(/\s/g, '');
            var qty = $("#qty").val();
            var price = $("#price").val();

            var err = [];

            checkError('qty', err);
            checkError('price', err);
            if (!product_id) {
                $("#product + span").addClass("is-invalid");
                $(".product_err").addClass('err_form').text('Product Field is Required');
                err.push('id');
            } else {
                $("#product + span").removeClass("is-invalid");
                $(".product_err").text('');
            }
            if (err.length < 1) {
                qtyCart.addItemToCart(o_name, name, qty, price, product_id);
                $("#product").val("").trigger("change");
                ;
                $("#price").val("");
                $("#qty").val("");
                $("#qtydata").val(JSON.stringify(sessionStorage.qtyCart));

                displayCart();
            }
        });

        // Clear items
        $('.clear-cart').click(function () {
            qtyCart.clearCart();
            displayCart();
        });


        // Delete item button

        $('.show-cart').on("click", ".delete-item", function (event) {
            var name = $(this).data('name')
            qtyCart.removeItemFromCartAll(name);
            $("#qtydata").val(JSON.stringify(sessionStorage.qtyCart));
            displayCart();
        })


        displayCart();


    </script>
@endpush
