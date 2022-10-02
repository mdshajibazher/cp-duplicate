@extends('layouts.adminlayout')
@section('title','Add New Damage Entry')
@section('content')

    <div class="row">
        <div class="col-lg-12">

            <div class="p_wrapper">
                <div class="row">
                    <div class="col-lg-4"><a href="{{route('damages.index')}}" class="btn btn-sm btn-warning"><i
                                class="fa fa-angle-left"></i> back</a></div>
                    <div class="col-lg-8">
                        <strong class="float-right">CREATE DAMAGE'S</strong>
                    </div>
                </div>
                <hr>
                <div class="row">

                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="damage_date">Date</label>
                            @php
                                $mytime = Carbon\Carbon::now();
                            @endphp
                            <input type="text" class="form-control" name="damage_date" id="damage_date"
                                   value="{{$mytime->toDateString()}}" readonly>
                            <div class="date_err"></div>
                        </div>


                    </div>


                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="user">Warehouse </label>
                            <select class="form-control" name="warehouse_id" id="warehouse_id" class="form-control">
                                @foreach ($warehouses as $warehouse)
                                    <option value="{{$warehouse->id}}"
                                            @if($g_opt_value['warehouse_id'] == $warehouse->id) selected
                                            @else disabled @endif >{{$warehouse->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <div id="customer-details"></div>
                        </div>
                    </div>


                    <div class="col-lg-2">
                        <div class="card">

                            <div class="card-header">

                                <span class="float-left"><b>RESET</b></span>
                                <button type="button" onclick="reset()" id="reset" class="btn btn-success float-right">
                                    <i class="fa fa-sync-alt"></i></button>
                            </div>

                        </div>
                    </div>
                </div>
                <hr>
                <div id="error">

                </div>

                <div class="row">
                    <div class="col-lg-4 col-md-3">
                        <div class="form-group">
                            <label for="product">Product</label>
                            <select data-placeholder="-select product-" class="js-example-responsive" name="product"
                                    id="product" class="form-control">
                                <option></option>

                                @foreach ($products as $product)
                                    <option value="{{$product->id}}">{{$product->product_name}}</option>
                                @endforeach

                            </select>
                            <div class="product_err err_form"></div>

                        </div>
                        <div class="form-group">
                            <span class="text-center" id="selected-product-info"></span>
                        </div>

                    </div>


                    <div class="col-lg-2 col-md-2">
                        <div class="form-group">
                            <label for="qty">Quantity</label>
                            <input type="number" class="form-control" name="qty" id="qty">
                            <div class="qty_err"></div>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div style="margin-top: 31px">
                            <button type="button" class="btn btn-warning  add-to-cart">ADD <i class="fa fa-plus"></i>
                            </button>
                        </div>

                    </div>


                </div>


            </div>
        </div>

        <div class="col-lg-12">
            <hr>
            <div class="p_detail_wrapper table-responsive">
                <h3 class="text-center">DAMAGE INVOICE</h3>
                <h5 class="date"></h5> <br>
                <div class="row">
                    <div class="col-lg-6">
                        <div id="customer-info">

                        </div>
                    </div>
                </div>
                <br><br>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead class="table-dark">
                        <tr>
                            <td>Sl.</td>
                            <td>Name</td>
                            <td>Image</td>
                            <td>Size</td>
                            <td>Qty</td>
                            <td>Action</td>
                        </tr>
                        </thead>

                        <tbody class="show-cart">

                        </tbody>

                    </table>
                </div>
                <div class="row">
                    <div class="col-lg-4">
                        <label for="reason">Reasons</label>
                        <textarea class="form-control" name="reason" id="reason" cols="30" rows="5"></textarea>
                    </div>
                    <div class="col-lg-6">

                    </div>
                    <div class="col-lg-2" id="amount-info">

                        <button type="button" class="btn btn-warning btn-block" id="confirm-btn"
                                onclick="confirm_sales()">Confirm
                        </button>

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

                var reason = '';

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

                function isNumber(n) {
                    return !isNaN(parseFloat(n)) && !isNaN(n - 0)
                }

                var baseuel = '{{url('/')}}';

                function reset() {
                    sessionStorage.clear();
                    $("#reset").html('<div class="fa-1x"><i class="fas fa-spinner fa-spin"></i></div>');
                    location.reload();
                }

                $('#product').select2({
                    width: '100%',
                    theme: "bootstrap",
                });

                if (sessionStorage.damage_date != undefined) {
                    $('.date').html('Sales Date: ' + sessionStorage.damage_date);
                }
                // If Shooping Cart Session Has Value Then Product Wrapeer Show
                if (sessionStorage.damageCart != undefined) {
                    if (sessionStorage.damageCart.length > 2) {
                        $(".p_detail_wrapper").show();
                    } else {
                        $(".p_detail_wrapper").hide();
                    }
                }


                // ************************************************
                // Shopping Cart API
                // ************************************************

                function strip(number) {
                    return (parseFloat(number).toPrecision(4));
                }

                //Precise Number
                function precise(x) {
                    return Number.parseFloat(x).toPrecision(3);
                }


                //Sum Any Arrray

                function sum(input) {

                    if (toString.call(input) !== "[object Array]")
                        return false;

                    var total = 0;
                    for (var i = 0; i < input.length; i++) {
                        if (isNaN(input[i])) {
                            continue;
                        }
                        total += Number(input[i]);
                    }
                    return total;
                }

                var damageCart = (function () {
                    // =============================
                    // Private methods and propeties
                    // =============================
                    cart = [];

                    // Constructor
                    function Item(name, count, id, o_name, image, product_size) {
                        this.name = name;
                        this.count = count;
                        this.id = id;
                        this.o_name = o_name;
                        this.image = image;
                        this.product_size = product_size;

                    }

                    // Save cart
                    function saveCart() {
                        sessionStorage.setItem('damageCart', JSON.stringify(cart));
                    }

                    // Load cart
                    function loadCart() {
                        cart = JSON.parse(sessionStorage.getItem('damageCart'));
                    }

                    if (sessionStorage.getItem("damageCart") != null) {
                        loadCart();
                    }


                    // =============================
                    // Public methods and propeties
                    // =============================
                    var obj = {};

                    // Add to cart
                    obj.addItemToCart = function (name, count, id, o_name, image, product_size) {
                        for (var item in cart) {
                            if (cart[item].name === name) {
                                alert('Oops... This Product Already Added');
                                return;
                            }
                        }
                        var item = new Item(name, count, id, o_name, image, product_size);
                        cart.push(item);
                        saveCart();
                    }

                    obj.IncrementCart = function (name, count, id, image, product_size) {
                        for (var item in cart) {
                            if (cart[item].name === name) {
                                cart[item].count++;
                                saveCart();
                                return;
                            }
                        }
                        var item = new Item(name, count, id, image, product_size);
                        cart.push(item);
                        saveCart();
                    }


                    // Set count from item
                    obj.setCountForItem = function (name, count) {
                        for (var i in cart) {
                            if (cart[i].name === name) {
                                cart[i].count = count;
                                saveCart();
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
                        var totalCount = [];
                        for (var item in cart) {
                            totalCount.push(cart[item].count);
                        }
                        return totalCount;
                    }

                    // Total cart
                    obj.totalCart = function () {
                        var totalCart = 0;
                        for (var item in cart) {
                            totalCart += cart[item].price * cart[item].count;
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
                            itemCopy.total = Number(item.price * item.count).toFixed(2);
                            cartCopy.push(itemCopy)
                        }
                        return cartCopy;
                    }


                    return obj;
                })();


                // *****************************************
                // Triggers / Events
                // *****************************************


                // Add item
                $('.add-to-cart').click(function (event) {
                    event.preventDefault();

                    var id = $("#product option:selected").val();
                    var damage_date = $("#damage_date").val();
                    var qnty = $("#qty").val();
                    var o_name = $("#product option:selected").text();
                    var nameSlulg = o_name.replace(/\s/g, '');


                    var err = [];
                    if (qnty.length === 0) {
                        $("#qty").addClass('is-invalid');
                        $(".qty_err").addClass('invalid-feedback').text('Qty Field is Required');
                        err.push('qty');
                    } else if (qnty < 1) {
                        $("#qty").addClass('is-invalid');
                        $(".qty_err").addClass('invalid-feedback').text('Negative Number Not Allowed');
                        err.push('qty');
                    } else if (isNumber(qnty) == false) {
                        $("#qty").addClass('is-invalid');
                        $(".qty_err").addClass('invalid-feedback').text('Field Must Be Numeric');
                        err.push('qty');
                    } else {
                        $("#qty").removeClass('is-invalid');
                    }
                    if (damage_date.length === 0) {
                        $("#damage_date").addClass('is-invalid');
                        $(".date_err").addClass('invalid-feedback').text('Sales Date Field is Required');
                        err.push('damage_date');
                    } else {
                        $("#damage_date").removeClass('is-invalid');
                    }


                    if (id.length === 0) {
                        $("#product + span").addClass("is-invalid");
                        $(".product_err").removeClass('success_form').addClass('err_form').text('Product Field is Required');
                        err.push('id');
                    } else {
                        $("#product + span").removeClass("is-invalid");
                        $(".product_err").text('');
                    }
                    if (id.length > 0) {
                        $.get(baseuel + "/api/productinfo/" + id, function (data, status) {
                            if (status === 'success') {
                                var image = data[0].image;
                                var current_stock = data[1];
                                var product_size = data[0].size.name;
                                if (err.length < 1) {

                                    damageCart.addItemToCart(nameSlulg, qnty, id, o_name, image, product_size);
                                    $(".is-valid").removeClass('is-valid');

                                    //Cart session has data
                                    if (sessionStorage.damageCart.length > 2) {
                                        $(".p_detail_wrapper").show();
                                    }

                                    //If Order Session empty
                                    if (sessionStorage.getItem("damage_date") == null) {
                                        sessionStorage.setItem("damage_date", damage_date);
                                    }
                                    displayCart();
                                    //Supllier Input Disabled
                                    $("#damage_date").prop("readonly", false);
                                    $("#damage_date").prop("disabled", true);
                                    $("#product").val("").trigger("change");
                                    ;
                                    $("#product + span").removeClass("is-valid");
                                    $(".product_err").text('');
                                    $("#qty").val("");
                                    $("#selected-product-info").hide();

                                }

                            }
                        });
                    }
                });


                $("#product").change(function () {
                    var product_id = $("#product option:selected").val();

                    if (product_id.length > 0) {

                        $.get(baseuel + "/api/productinfo/" + product_id, function (data, status) {
                            if (status === 'success') {
                                $("#selected-product-info").html('<table class="table table-sm table-hover table-dark"><tr><td> <b>' + data[0].product_name + '</b></td></tr><tr><td><img class="img-responsive img-thumbnail" src="' + baseuel + '/public/uploads/products/tiny/' + data[0].image + '" /></td></tr><tr><td>Current Stock : ' + data[1] + '</td></tr></table>');

                                $("#selected-product-info").show();

                                $("#qty").val(1).removeClass('is-invalid').addClass('is-valid');
                                $(".qty_err").removeClass('invalid-feedback').addClass('valid-feedback').text('Looks Good');
                            }

                        });

                        $("#product + span").removeClass('is-invalid').addClass('is-valid');
                        $(".product_err").removeClass('err_form').addClass('success_form').text('Looks Good');

                    }


                });


                $("#qty").change(function () {
                    var qnty = $("#qty").val();
                    if (qnty.length === 0) {
                        $("#qty").removeClass('is-valid').addClass('is-invalid');
                        $(".qty_err").removeClass('valid-feedback').addClass('invalid-feedback');
                        ;
                        $(".qty_err").text('Qty Field is Required');
                        $(".add-to-cart").prop('disabled', true);
                    } else if (isNumber(qnty) == false) {
                        $("#qty").removeClass('is-valid').addClass('is-invalid');
                        $(".qty_err").removeClass('valid-feedback').addClass('invalid-feedback');
                        $(".qty_err").text('Filed Must Be Numeric');
                        $(".add-to-cart").prop('disabled', true);
                    } else {
                        $("#qty").removeClass('is-invalid').addClass('is-valid');
                        $(".qty_err").removeClass('invalid-feedback').addClass('valid-feedback');
                        $(".qty_err").text('Looks Good');
                        $(".add-to-cart").prop('disabled', false);
                    }
                });


                $("#damage_date").change(function () {
                    var od = $("#damage_date").val();
                    if (od.length === 0) {
                        $("#damage_date").removeClass('is-valid').addClass('is-invalid');
                        $(".date_err").removeClass('valid-feedback').addClass('invalid-feedback');
                        ;
                        $(".date_err").text('Qty Field is Required');
                    } else {
                        $("#damage_date").removeClass('is-invalid').addClass('is-valid');
                        $(".date_err").removeClass('invalid-feedback').addClass('valid-feedback');
                        $(".date_err").text('Looks Good');
                    }
                });


                // Clear items
                $('.clear-cart').click(function () {
                    damageCart.clearCart();
                    displayCart();
                });


                function displayCart() {

                    var cartArray = damageCart.listCart();
                    var baseuel = '{{url('/')}}';
                    var output = "";


                    var j = 1;
                    for (var i in cartArray) {
                        output += "<tr>"
                            + "<td>" + j++ + "</td>"
                            + "<td>" + cartArray[i].o_name + "</td>"
                            + "<td><img style='width: 50px;' src='" + baseuel + "/public/uploads/products/tiny/" + cartArray[i].image + "' class='img-thumbnail' /></td>"
                            + "<td>" + cartArray[i].product_size + "</td>"
                            + "<td>" + cartArray[i].count + "</td>"
                            + "<td><button class='delete-item btn btn-sm badge-danger' data-name=" + cartArray[i].name + ">X</button></td>"
                            + "</tr>";
                    }
                    $('.show-cart').html(output);
                    $('.total-cart').html(damageCart.totalCart());

                    $('.date').html('Sales Date: ' + sessionStorage.damage_date);
                    $.get("{{url('/')}}/api/userinfo/" + sessionStorage.user_id, function (data, status) {
                        if (status === 'success') {
                            $("#customer-info").html("<b>Name :</b>" + data.name + "</br><b>Address :</b>  " + data.address + "<br><b>Phone :</b> " + data.phone + "<br><b>Email :</b> " + data.email);

                        }
                    });

                }

                // Delete item button

                $('.show-cart').on("click", ".delete-item", function (event) {
                    var name = $(this).data('name')
                    damageCart.removeItemFromCartAll(name);
                    displayCart();
                    if (cart.length < 1) {
                        $(".p_detail_wrapper").hide();
                    }
                })


                // -1
                $('.show-cart').on("click", ".minus-item", function (event) {
                    var name = $(this).data('name')
                    damageCart.removeItemFromCart(name);
                    displayCart();
                })
                // +1
                $('.show-cart').on("click", ".plus-item", function (event) {
                    var name = $(this).data('name')
                    damageCart.IncrementCart(name);
                    displayCart();
                })

                // Item count input
                $('.show-cart').on("change", ".item-count", function (event) {
                    var name = $(this).data('name');
                    var count = Number($(this).val());
                    damageCart.setCountForItem(name, count);
                    displayCart();
                });

                displayCart();


                // Ajax

                function confirm_sales() {
                    $(document).ready(function () {
                        reason = $("#reason").val();
                        var b_url = '{{url('/')}}';
                        if (sessionStorage.damageCart.length < 3) {
                            alert('please select a product');
                        } else {
                            $.ajaxSetup({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                }
                            });
                            let warehouse_id = $("#warehouse_id").val();
                            $.ajax({
                                data: {
                                    'damage_date': sessionStorage.damage_date,
                                    'reason': reason,
                                    'product': sessionStorage.damageCart,
                                    'warehouse_id': warehouse_id
                                },
                                url: "{{route('damages.store')}}",
                                type: "POST",
                                dataType: 'json',
                                success: function (data) {
                                    console.log(data);
                                    sessionStorage.clear();

                                    window.location = b_url + '/admin/damages'

                                },
                                error: function (data) {
                                    console.log(data);
                                    sessionStorage.clear();
                                    if (data.status == 200) {
                                        console.log(data.status);
                                        window.location = b_url + '/admin/damages'
                                    } else {

                                        var errdata = "";
                                        $.each(data.responseJSON.errors, function (key, value) {
                                            errdata += "<li>" + value + "</li>";
                                        });
                                        $('#error').html(errdata);
                                        $('#error').addClass('alert alert-danger');
                                    }
                                }
                            });
                            $('#confirm-btn').attr('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading.....');
                        }
                    });

                }


            </script>

            <script src="{{asset('assets/js/flatpicker.min.js')}}"></script>
            <script>
                $("#damage_date").flatpickr({dateFormat: 'Y-m-d', allowInput: true});
            </script>

    @endpush


