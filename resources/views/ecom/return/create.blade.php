@extends('layouts.adminlayout')
@section('title','Create Returns')
@section('content')

  <div class="row">
    <div class="col-lg-4">

        <div class="p_wrapper">
          <div class="form-group">
            <div class="row">
              <div class="col-lg-4"><a href="{{route('return.index')}}" class="btn btn-sm btn-danger"><i class="fa fa-angle-left"></i> back</a></div>
              <div class="col-lg-8">
                 <strong class="float-right">ECOM RETURN INVOICE</strong>
              </div>
            </div>
          </div>

          <div class="form-group">
            <div class="card">

              <div class="card-header">

                  <span class="float-left"><b>RESET</b></span> <button type="button" onclick="reset()" id="reset" class="btn btn-success float-right"><i class="fa fa-sync-alt"></i> </button>
                </div>

              </div>
            </div>


              <div class="form-group">
                <label for="return_date">Date</label>
                @php
                    $mytime = Carbon\Carbon::now();
                @endphp
                <input type="text" class="form-control" name="return_date" id="return_date" value="{{$mytime->toDateString()}}" readonly>
                <div class="date_err"></div>
              </div>


              <div class="form-group">
                <label for="user">Customer </label>
                <select data-placeholder="-select user-" class="js-example-responsive" name="user" id="user" class="form-control">
                <option></option>

                  @foreach ($users as $user)
                <option value="{{$user->id}}">{{$user->name}}</option>
                  @endforeach

                </select>
                <div class="user_err err_form"></div>




            <div class="form-group">
              <div id="customer-details"></div>
            </div>






        </div>
          <hr>
          <div id="error">

          </div>

            <div class="row">
            <div class="col-lg-12">
              <div class="form-group">
                <label for="product">Product</label>
                <select data-placeholder="-select product-" class="js-example-responsive" name="product" id="product" class="form-control">
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




                <div class="col-lg-6">

                  <div class="form-group">
                    <label for="price">Price</label>
                    <input type="number" class="form-control" name="price" id="price">
                    <div class="price_err"></div>
                  </div>


                </div>

                <div class="col-lg-6">
                  <div class="form-group">
                    <label for="qty">Quantity</label>
                    <input type="number" class="form-control" name="qty" id="qty">
                    <div class="qty_err"></div>
                  </div>
                </div>
                <div class="col-lg-12">
                  <div style="margin-top: 31px">
                    <button type="button"  class="btn btn-danger btn-block  add-to-cart">ADD <i class="fa fa-plus"></i></button>
                  </div>

                </div>


            </div>




        </div>
    </div>

    <div class="col-lg-8">
      <div class="p_detail_wrapper table-responsive">
        <h3 class="text-center">ECOMMERCE RETURN INVOICE</h3>
        <h5 class="date"></h5> <br>
        <div class="row">
            <div class="col-lg-6">
                <div id="customer-info">

            </div>
         </div>
    </div> <br><br>
    <div class="table-responsive">
      <table class="table table-bordered table-striped">
        <thead class="table-dark">
          <tr>
            <td>Sl.</td>
            <td>Name</td>
            <td>Image</td>
            <td>Price</td>
            <td>Qty</td>
            <td>Total</td>
            <td>Action</td>
          </tr>
        </thead>

        <tbody class="show-cart">

        </tbody>

      </table>
      </div>
      <div class="row">
      <div class="col-lg-5"></div>
      <div class="col-lg-7" id="amount-info">

        <table class="table table-bordered">
          <tr>
            <td>Subtotal</td>
            <td class="total-cart"></td>
          </tr>

          <tr>
            <td>Discount (%) <input type="number" class="form-control tiny-input" id="discount_input" value="0"></td>
            <td>Discount Amount <input type="text" class="discount form-control" value=""></td>
          </tr>
          <tr>
            <td>Net Amount</td>
            <td class="net-amount"></td>
          </tr>
          <tr>
          <td>Carrying & Loading <input type="number" class="form-control tiny-input" id="carrying_and_loading" value="0"></td>
            <td class="carrying_and_loading">0</td>
          </tr>


          <tr>
            <td>Grand Total</td>
            <td class="grand-total"></td>
          </tr>

        </table>




      <button type="button" class="btn btn-danger"  id="confirm-btn" onclick="confirm_return()">Confirm</button>

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


function isNumber(n) { return !isNaN(parseFloat(n)) && !isNaN(n - 0) }

var baseuel = '{{url('/')}}';

  function reset(){
    sessionStorage.clear();
    $("#reset").html('<div class="fa-1x"><i class="fas fa-spinner fa-spin"></i></div>');
    location.reload();
  }

  $('#product').select2({
      width: '100%',
      theme: "bootstrap",
  });
  $('#user').select2({
      width: '100%',
      theme: "bootstrap",
  });
  if(sessionStorage.return_date != undefined){
     $('.date').html('Return Date: '+sessionStorage.return_date);
  }
// If Shooping Cart Session Has Value Then Product Wrapeer Show
if(sessionStorage.posreturnCart != undefined){
  if(sessionStorage.posreturnCart.length > 2){
    $(".p_detail_wrapper").show();
  }else{
    $(".p_detail_wrapper").hide();
  }
}


if(sessionStorage.user_id!= undefined || sessionStorage.user_id!= undefined){
  $("#user").val(sessionStorage.user_id).trigger('change');
  $("#return_date").val(sessionStorage.return_date);
  $("#user").prop("disabled", true);
  $("#return_date").prop("readonly", false);
  $("#return_date").prop("disabled", true);
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

function sum(input){

    if (toString.call(input) !== "[object Array]")
    return false;

    var total =  0;
    for(var i=0;i<input.length;i++)
    {
    if(isNaN(input[i])){
    continue;
    }
    total += Number(input[i]);
    }
    return total;
}

var posreturnCart = (function() {
  // =============================
  // Private methods and propeties
  // =============================
  cart = [];

  // Constructor
  function Item(name, price, count, id,o_name,image) {
    this.name = name;
    this.price = price;
    this.count = count;
    this.id    = id;
    this.o_name    = o_name;
    this.image    = image;

  }

  // Save cart
  function saveCart() {
    sessionStorage.setItem('posreturnCart', JSON.stringify(cart));
  }

    // Load cart
  function loadCart() {
    cart = JSON.parse(sessionStorage.getItem('posreturnCart'));
  }
  if (sessionStorage.getItem("posreturnCart") != null) {
    loadCart();
  }


  // =============================
  // Public methods and propeties
  // =============================
  var obj = {};

  // Add to cart
  obj.addItemToCart = function(name, price, count, id,o_name,image) {
    for(var item in cart) {
      if(cart[item].name === name) {
       Swal.fire({
          icon: 'error',
          title: 'Oops...',
          text: 'This Product Already Aded'
        })
        return;
      }
    }
    var item = new Item(name, price, count, id,o_name,image);
    cart.push(item);
    saveCart();
  }

  obj.IncrementCart = function(name, price, count, id,image) {
    for(var item in cart) {
      if(cart[item].name === name) {
        cart[item].count ++;
        saveCart();
        return;
      }
    }
    var item = new Item(name, price, count, id,image);
    cart.push(item);
    saveCart();
  }




  // Set count from item
  obj.setCountForItem = function(name, count) {
    for(var i in cart) {
      if (cart[i].name === name) {
        cart[i].count = count;
        saveCart();
        break;
      }
    }
  };
  // Remove item from cart
  obj.removeItemFromCart = function(name) {
      for(var item in cart) {
        if(cart[item].name === name) {
          cart[item].count --;
          if(cart[item].count === 0) {
            cart.splice(item, 1);
          }
          break;
        }
    }
    saveCart();
  }

  // Remove all items from cart
  obj.removeItemFromCartAll = function(name) {
    for(var item in cart) {
      if(cart[item].name === name) {
        cart.splice(item, 1);
        break;
      }
    }
    saveCart();
  }

  // Clear cart
  obj.clearCart = function() {
    cart = [];
    saveCart();
  }

  // Count cart
  obj.totalCount = function() {
    var totalCount = [];
    for(var item in cart) {
      totalCount.push(cart[item].count);
    }
    return totalCount;
  }

  // Total cart
  obj.totalCart = function() {
    var totalCart = 0;
    for(var item in cart) {
      totalCart += cart[item].price * cart[item].count;
    }
    return Number(totalCart.toFixed(2));
  }

  // List cart
  obj.listCart = function() {
    var cartCopy = [];
    for(i in cart) {
      item = cart[i];
      itemCopy = {};
      for(p in item) {
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
$('.add-to-cart').click(function(event) {
  event.preventDefault();

  var id = $("#product option:selected").val();
  var return_date = $("#return_date").val();
  var user_id = $("#user option:selected").val();
  var qnty = $("#qty").val();
  var o_name = $("#product option:selected").text();
  var nameSlulg =  o_name.replace(/\s/g, '');
  var price = $("#price").val();





  var err = [];
  if(qnty.length === 0){
    $("#qty").addClass('is-invalid');
    $(".qty_err").addClass('invalid-feedback').text('Qty Field is Required');
    err.push('qty');
  }else if(qnty < 1){
    $("#qty").addClass('is-invalid');
    $(".qty_err").addClass('invalid-feedback').text('Negative Number Not Allowed');
    err.push('qty');
  }else if(isNumber(qnty) == false){
    $("#qty").addClass('is-invalid');
    $(".qty_err").addClass('invalid-feedback').text('Field Must Be Numeric');
    err.push('qty');
  }else{
    $("#qty").removeClass('is-invalid');
  }
  if(return_date.length === 0){
    $("#return_date").addClass('is-invalid');
    $(".date_err").addClass('invalid-feedback').text('Return Date Field is Required');
    err.push('return_date');
  }else{
    $("#return_date").removeClass('is-invalid');
  }
  if(price.length === 0){
    $("#price").addClass('is-invalid');
    $(".price_err").addClass('invalid-feedback').text('Price Field is Required');
    err.push('price');
  }else if(price < 1){
    $("#price").addClass('is-invalid');
    $(".price_err").addClass('invalid-feedback').text('Negative Number Not Allowed');
    err.push('price');
  }else if(isNumber(price) == false){
    $("#price").addClass('is-invalid');
    $(".price_err").addClass('invalid-feedback').text('Field Must Be Numeric');
    err.push('price');
  }else{
    $("#price").removeClass('is-invalid');
  }
  if(user_id.length === 0){
    $("#user + span").addClass("is-invalid");
    $(".user_err").text('User Field is Required');
    err.push('user_id');
  }else{
    $("#user + span").removeClass("err_form");
    $(".user_err").text('');
  }
  if(id.length === 0){
    $("#product + span").addClass("is-invalid");
    $(".product_err").removeClass('success_form').addClass('err_form').text('Product Field is Required');
    err.push('id');
  }else{
    $("#product + span").removeClass("is-invalid");
    $(".product_err").text('');
  }
  if(id.length > 0){
  $.get(baseuel+"/api/productinfo/"+id, function(data, status){
    if(status === 'success'){
      var image = data[0].image;
    if(err.length<1){
    posreturnCart.addItemToCart(nameSlulg, price, qnty,id,o_name,image);
    $(".is-valid").removeClass('is-valid');

    //Cart session has data
    if(sessionStorage.posreturnCart.length > 2){
    $(".p_detail_wrapper").show();
    }

    //If Order Session empty
    if (sessionStorage.getItem("user_id") == null || sessionStorage.getItem("return_date") == null) {
      sessionStorage.setItem("user_id",user_id);
      sessionStorage.setItem("return_date",return_date);
    }
    displayCart();
    //Supllier Input Disabled
    $("#user").prop("disabled", true);
    $("#return_date").prop("readonly", false);
    $("#return_date").prop("disabled", true);
    $("#product").val("").trigger("change");;
    $("#product + span").removeClass("is-valid");
    $(".product_err").text('');
    $("#price").val("");
    $("#qty").val("");
    $("#selected-product-info").hide();
  }

  }
});
}
});


$( "#user" ).change(function() {
    var user_id = $("#user option:selected").val();
    $.get("{{url('/')}}/api/userinfo/"+user_id, function(data, status){
      if(status === 'success'){
  $("#customer-details").html('<p>Customer Details</p><table class="table table-bordered table-sm"><tr><th scope="col">Name</th> <td>'+data.name+'</td></tr><tr><th scope="col">Email</th><td>'+data.email+'</td></tr><tr><th scope="col">Phone</th><td>'+data.phone+'</td></tr><tr><th scope="col">Address</th><td>'+data.address+'</td></tr></table>');

      }
    });
});
$( "#product" ).change(function() {
    var product_id = $("#product option:selected").val();
    if(product_id.length > 0){
        $.get(baseuel+"/api/productinfo/"+product_id, function(data, status){
          if(status === 'success'){
              $("#selected-product-info").html('<table class="table table-sm table-hover table-dark"><tr><td> <b>'+data[0].product_name+'</b></td></tr><tr><td><img class="img-responsive img-thumbnail" src="'+baseuel+'/public/uploads/products/tiny/'+data[0].image+'" /></td></tr><tr><td> Price: '+data[0].current_price+'</td></tr><tr><td>Current Stock : '+data[1]+'</td></tr></table>');


            $("#selected-product-info").show();

            if(data[0].discount_price == null){
              $("#price").val(data[0].price).removeClass('is-invalid').addClass('is-valid');
            }else{
              $("#price").val(data[0].discount_price).removeClass('is-invalid').addClass('is-valid');
            }

            $(".price_err").removeClass('invalid-feedback').addClass('valid-feedback').text('Looks Good');
            $(".qty_err").removeClass('invalid-feedback').addClass('valid-feedback').text('Looks Good');
          }

      });

    }


});


$("#qty").change(function(){
  var qnty = $("#qty").val();
  if(qnty.length === 0){
    $("#qty").removeClass('is-valid').addClass('is-invalid');
    $(".qty_err").removeClass('valid-feedback').addClass('invalid-feedback');;
    $(".qty_err").text('Qty Field is Required');
    $(".add-to-cart").prop('disabled', true);
  }else if(isNumber(qnty) == false){
    $("#qty").removeClass('is-valid').addClass('is-invalid');
    $(".qty_err").removeClass('valid-feedback').addClass('invalid-feedback');
    $(".qty_err").text('Filed Must Be Numeric');
    $(".add-to-cart").prop('disabled', true);
  }else{
    $("#qty").removeClass('is-invalid').addClass('is-valid');
    $(".qty_err").removeClass('invalid-feedback').addClass('valid-feedback');
    $(".qty_err").text('Looks Good');
    $(".add-to-cart").prop('disabled', false);
}
});

$("#price").change(function(){
  var price = $("#price").val();
  if(price.length === 0){
    $("#price").removeClass('is-valid').addClass('is-invalid');
    $(".price_err").removeClass('valid-feedback').addClass('invalid-feedback');;
    $(".price_err").text('Qty Field is Required');
    $(".add-to-cart").prop('disabled', true);
  }else if(isNumber(price) == false){
    $("#price").removeClass('is-valid').addClass('is-invalid');
    $(".price_err").removeClass('valid-feedback').addClass('invalid-feedback');
    $(".price_err").text('Filed Must Be Numeric');
    $(".add-to-cart").prop('disabled', true);
  }else{
    $("#price").removeClass('is-invalid').addClass('is-valid');
    $(".price_err").removeClass('invalid-feedback').addClass('valid-feedback');
    $(".price_err").text('Looks Good');
    $(".add-to-cart").prop('disabled', false);
}
});



$("#return_date").change(function(){
  var od = $("#return_date").val();
  if(od.length === 0){
    $("#return_date").removeClass('is-valid').addClass('is-invalid');
    $(".date_err").removeClass('valid-feedback').addClass('invalid-feedback');;
    $(".date_err").text('Qty Field is Required');
  }else{
    $("#return_date").removeClass('is-invalid').addClass('is-valid');
    $(".date_err").removeClass('invalid-feedback').addClass('valid-feedback');
    $(".date_err").text('Looks Good');
}
});

$("#user").change(function(){
  var user = $("#user").val();
  if(user.length > 0){
    $("#user + span").removeClass('is-invalid').addClass('is-valid');
    $(".user_err").removeClass('err_form').addClass('success_form').text('Looks Good');
}
});

$("#product").change(function(){
  var product = $("#product").val();
  if(user.length > 0){
    $("#product + span").removeClass('is-invalid').addClass('is-valid');
    $(".product_err").removeClass('err_form').addClass('success_form').text('Looks Good');
}
});








// Clear items
$('.clear-cart').click(function() {
  posreturnCart.clearCart();
  displayCart();
});

var return_discount = $('#discount_input').val()/100;
var carrying_and_loading = $('#carrying_and_loading').val();

$(document).ready(function(){
  $("#discount_input").change(function(){
      var net_discount =  $('#discount_input').val();
      return_discount =  net_discount/100;
      var disc_amout = posreturnCart.totalCart()*return_discount;
      $(".discount").val(disc_amout);
      displayCart();
  });


  $(".discount").change(function(){
    var net_discount_amount =  $('.discount').val();
    $("#discount_input").val('0');
    $(".discount").val(net_discount_amount);
    displayCart();
  });
  $("#carrying_and_loading").change(function(){
      carrying_and_loading =  $('#carrying_and_loading').val();
      displayCart();
  });
});



function displayCart() {
  var discount_amount = $(".discount").val();
  var cartArray = posreturnCart.listCart();
  var baseuel = '{{url('/')}}';
  var output = "";
  var subtotal = posreturnCart.totalCart();
  var disc = subtotal*return_discount;
  var netamount = subtotal-discount_amount;
  var g_total = parseFloat(netamount)+parseFloat(carrying_and_loading);
  var j =1;
  for(var i in cartArray) {
    output += "<tr>"
      + "<td>" + j++ + "</td>"
      + "<td>" + cartArray[i].o_name + "</td>"
      + "<td><img style='width: 50px;' src='"+baseuel+"/public/uploads/products/tiny/"+cartArray[i].image+"' class='img-thumbnail' /></td>"
      + "<td>" + cartArray[i].price + " Tk.</td>"
      + "<td style='width: 150px;text-align: center;margin: 0 auto'><div class='input-group'><button class='minus-item input-group-addon btn btn-sm btn-danger' data-name=" + cartArray[i].name + ">-</button>"
      + "<input style='width: 40px' type='number' class='item-count' data-name='" + cartArray[i].name + "' value='" + cartArray[i].count + "'>"
      + "<button class='plus-item btn  btn-sm btn-danger  input-group-addon' data-name=" + cartArray[i].name + ">+</button></div></td>"
      + "<td>" + Math.round(cartArray[i].total) + " Tk</td>"
      + "<td><button class='delete-item btn btn-sm badge-danger' data-name=" + cartArray[i].name + ">X</button></td>"
      +  "</tr>";
  }
  $('.show-cart').html(output);
  $('.total-cart').html(posreturnCart.totalCart());

  $('.date').html('Return Date: '+sessionStorage.return_date);
  $.get("{{url('/')}}/api/userinfo/"+sessionStorage.user_id, function(data, status){
      if(status === 'success'){
        $("#customer-info").html("<b>Name :</b>"+data.name+"</br><b>Address :</b>  "+data.address+"<br><b>Phone :</b> "+data.phone+"<br><b>Email :</b> "+data.email);

      }
  });
  //$('#customer-info').html('<h5>Customer Name: Md Shajib Azher</h5><h5>Email : mdshajibazher@gmail.com</h5><h5>Phone :01700554455</h5><h5>Address :Dhaka</h5>');
  $('.net-amount').text(Math.round(netamount));
  $('.discount').val( Math.round(discount_amount));
  $('.carrying_and_loading').text(carrying_and_loading);
  $('.grand-total').html(Math.round(g_total));
}

// Delete item button

$('.show-cart').on("click", ".delete-item", function(event) {
  var name = $(this).data('name')
  posreturnCart.removeItemFromCartAll(name);
  displayCart();
  if(cart.length < 1){
    $(".p_detail_wrapper").hide();
  }
})


// -1
$('.show-cart').on("click", ".minus-item", function(event) {
  var name = $(this).data('name')
  posreturnCart.removeItemFromCart(name);
  displayCart();
})
// +1
$('.show-cart').on("click", ".plus-item", function(event) {
  var name = $(this).data('name')
  posreturnCart.IncrementCart(name);
  displayCart();
})

// Item count input
$('.show-cart').on("change", ".item-count", function(event) {
   var name = $(this).data('name');
   var count = Number($(this).val());
  posreturnCart.setCountForItem(name, count);
  displayCart();
});

displayCart();


// Ajax

function confirm_return(){
  $(document).ready(function () {
 var discount_amount = $(".discount").val();
   if(sessionStorage.posreturnCart.length < 3){
      alert('please select a product');
   }else{
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
          data: {
            'return_date' : sessionStorage.return_date,
            'user_id' : sessionStorage.user_id,
            'discount' : discount_amount,
            'carrying_and_loading' : carrying_and_loading,
            'product' : sessionStorage.posreturnCart,
          },
          url: "{{route('return.store')}}",
          type: "POST",
          dataType: 'json',
          success: function (data) {
            console.log(data);
              sessionStorage.clear();
              var b_url = '{{url('/')}}';
              window.location = b_url+'/admin/ecom/return/'+data

          },
          error: function (data) {
            console.log(data);
           sessionStorage.clear();
           if(data.status == 200){
              console.log(data.status);
           }else{

           var errdata = "";
           $.each(data.responseJSON.errors, function( key, value ) {
                    errdata += "<li>"+value+"</li>";
            });
            $('#error').html(errdata);
            $('#error').addClass('alert alert-danger');
           }

          }
      });
      $('#confirm-btn').attr('disabled',true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading.....' );
    }
  });

}




</script>

<script src="{{asset('assets/js/flatpicker.min.js')}}"></script>
<script>
  $("#return_date").flatpickr({dateFormat: 'Y-m-d', allowInput: true});
</script>

@endpush


