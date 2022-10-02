@extends('layouts.adminlayout')
@section('title','Edit Orders')

@section('content')

  <div class="row">
    <div class="col-lg-4">

        <div class="p_wrapper">
          <div class="row">
            <div class="col-lg-4"><a href="{{route('order.index')}}" class="btn btn-sm btn-success"><i class="fa fa-angle-left"></i> back</a></div>
            <div class="col-lg-8">
            <strong class="float-right">EDIT ORDER #{{$order->id}}</strong>
            </div>
          </div>
           <br><br>
          <div class="card">

            <div class="card-header">

              <span class="float-left">Reset All</span> <button type="button" onclick="reset()" id="reset" class="btn btn-warning float-right"><i class="fa fa-sync-alt"></i> </button>
            </div>
          </div>
          <hr>
          <div id="error">

          </div>
          <form id="left-form">
            <div class="form-group">
              <label for="order_date">Date</label>
              <input type="text" class="form-control" name="order_date" id="order_date"  readonly>
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

          </div>
          <div class="form-group">
            <div id="customer-details"></div>
          </div>



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

              <div class="row">


                <div class="col-lg-6">
                  <div class="form-group">
                    <label for="qty">Quantity</label>
                    <input type="number" class="form-control" name="qty" id="qty">
                    <div class="qty_err"></div>
                  </div>
                </div>

                <div class="col-lg-6">

                  <div class="form-group">
                    <label for="price">Price</label>
                    <input type="text" class="form-control" name="price" id="price">
                    <div class="price_err"></div>
                  </div>


                </div>


              </div>
              <button type="button"  class="btn btn-success btn-block add-to-cart">ADD <i class="fa fa-plus"></i></button>

            </form>



        </div>
    </div>
    <div class="col-lg-8">
      <div class="p_detail_wrapper table-responsive">
        <h5 class="date"></h5> <br>
        <div class="row">
            <div class="col-lg-6">
                <div id="customer-info">

            </div>
         </div>
    </div> <br><br>
      <table class="table table-bordered">
        <thead class="table-dark">
          <tr>
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
      <div class="row">
      <div class="col-lg-5" id="amount-info">

        <table class="table table-bordered">
          <tr>
            <td>Subtotal</td>
            <td class="total-cart"></td>
          </tr>

          <tr>
            <td>Discount <input type="number" class="form-control tiny-input" id="discount_input" value="{{$order->discount}}"></td>
            <td class="discount"></td>
          </tr>
          <tr>
            <td>Net Amount</td>
            <td class="net-amount"></td>
          </tr>
          <tr>
          <td>Shipping <input type="number" class="form-control tiny-input" id="shipping" value="{{$order->shipping}}"></td>
            <td class="shipping">0</td>
          </tr>
          <tr>
            <td>VAT & TAX ({{$order->vat+$order->tax}}) %</td>
            <td class="vat">0</td>
          </tr>

          <tr>
            <td>Grand Total</td>
            <td class="grand-total"></td>
          </tr>

        </table>




      <button type="button" class="btn btn-success"  id="confirm-btn" onclick="confirm_order()">Confirm</button>

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






$.get("{{route('orderinfo.api',$order->id)}}",function(data, status){
  if(status === 'success'){
    if(sessionStorage.orderId == undefined ){
    sessionStorage.setItem('orderCart',JSON.stringify(data.orderCart));
    sessionStorage.setItem('user_id', data.user_id);
    sessionStorage.setItem('order_date' ,data.order_date );
    sessionStorage.setItem('orderId' ,data.order_id );
    location.reload();
  }else if(sessionStorage.orderId != data.order_id){
      sessionStorage.clear();
      location.reload();
  }
  }
});


function isNumber(n) { return !isNaN(parseFloat(n)) && !isNaN(n - 0) }

var baseuel = '{{url('/')}}';

  function reset(){
    sessionStorage.clear();
    $("#reset").html('<div class="fa-1x"><i class="fas fa-spinner fa-spin"></i></div>');
    location.reload(true);
  }

  $('#product').select2({
      width: '100%',
      theme: "bootstrap",
  });
  $('#user').select2({
      width: '100%',
      theme: "bootstrap",
  });
  if(sessionStorage.order_date != undefined){
     $('.date').html('Order Date: '+sessionStorage.order_date);
  }
// If Shooping Cart Session Has Value Then Product Wrapeer Show
if(sessionStorage.orderCart != undefined){
  if(sessionStorage.orderCart.length > 2){
    $(".p_detail_wrapper").show();
  }else{
    $(".p_detail_wrapper").hide();
  }
}


if(sessionStorage.user_id!= undefined || sessionStorage.user_id!= undefined){
  $("#user").val(sessionStorage.user_id).trigger('change');
  $("#order_date").val(sessionStorage.order_date);
  $("#user").prop("disabled", true);
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

var orderCart = (function() {
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
    sessionStorage.setItem('orderCart', JSON.stringify(cart));
  }

    // Load cart
  function loadCart() {
    cart = JSON.parse(sessionStorage.getItem('orderCart'));
  }
  if (sessionStorage.getItem("orderCart") != null) {
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
        alert('Oops... This Product Already Added');
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
  var order_date = $("#order_date").val();
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
  }else if(isNumber(qnty) == false){
    $("#qty").addClass('is-invalid');
    $(".qty_err").addClass('invalid-feedback').text('Field Must Be Numeric');
    err.push('qty');
  }else{
    $("#qty").removeClass('is-invalid');
  }
  if(order_date.length === 0){
    $("#order_date").addClass('is-invalid');
    $(".date_err").addClass('invalid-feedback').text('Order Date Field is Required');
    err.push('order_date');
  }else{
    $("#order_date").removeClass('is-invalid');
  }
  if(price.length === 0){
    $("#price").addClass('is-invalid');
    $(".price_err").addClass('invalid-feedback').text('Price Field is Required');
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
    err.push('return');
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

      var current_stock = data[1];
    if(err.length<1){
      if(current_stock < 1){
        alert('Out Of Stock');
      }else if(current_stock < qnty){
        alert('Out Of Stock');
      }else{

    orderCart.addItemToCart(nameSlulg, price, qnty,id,o_name,image);
    $(".is-valid").removeClass('is-valid');

    //Cart session has data
    if(sessionStorage.orderCart.length > 2){
    $(".p_detail_wrapper").show();
    }

    //If Order Session empty
    if (sessionStorage.getItem("user_id") == null || sessionStorage.getItem("order_date") == null) {
      sessionStorage.setItem("user_id",user_id);
      sessionStorage.setItem("order_date",order_date);
    }
    displayCart();
    //Supllier Input Disabled
    $("#user").prop("disabled", true);
    $("#order_date").prop("readonly", false);
    $("#order_date").prop("disabled", true);
    $("#product").val("").trigger("change");;
    $("#product + span").removeClass("is-valid");
    $(".product_err").text('');
    $("#price").val("");
    $("#qty").val("");
    $("#selected-product-info").hide();

      }
  }

  }
});
}
});


$( "#user" ).change(function() {
    var user_id = $("#user option:selected").val();
    $.get("{{url('/')}}/api/userinfo/"+user_id, function(data, status){
      if(status === 'success'){
        $("#customer-details").html("<b>Address :</b> <br> "+data.address+"<br><b>Phone :</b> "+data.phone+"<br><b>Email :</b> "+data.email);

      }
    });
});
$( "#product" ).change(function() {
    var product_id = $("#product option:selected").val();

    if(product_id.length > 0){

        $.get(baseuel+"/api/productinfo/"+product_id, function(data, status){
          if(status === 'success'){
              $("#selected-product-info").html('<table class="table table-sm table-hover table-light"><tr><td> <b>'+data[0].product_name+'</b></td></tr><tr><td><img class="img-responsive img-thumbnail" src="'+baseuel+'/public/uploads/products/tiny/'+data[0].image+'" /></td></tr><tr><td> Price: '+data[0].current_price+'</td></tr><tr><td>Current Stock : '+data[1]+'</td></tr></table>');


            $("#selected-product-info").show();

            if(data[0].discount_price == null){
              $("#price").val(data[0].price).removeClass('is-invalid').addClass('is-valid');
            }else{
              $("#price").val(data[0].discount_price).removeClass('is-invalid').addClass('is-valid');
            }

            $(".price_err").removeClass('invalid-feedback').addClass('valid-feedback').text('Looks Good');
            // $("#qty").val(1).removeClass('is-invalid').addClass('is-valid');
            $(".qty_err").removeClass('invalid-feedback').addClass('valid-feedback').text('Looks Good');
          }

      });

      $("#product + span").removeClass('is-invalid').addClass('is-valid');
        $(".product_err").removeClass('err_form').addClass('success_form').text('Looks Good');

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



$("#order_date").change(function(){
  var od = $("#order_date").val();
  if(od.length === 0){
    $("#order_date").removeClass('is-valid').addClass('is-invalid');
    $(".date_err").removeClass('valid-feedback').addClass('invalid-feedback');;
    $(".date_err").text('Qty Field is Required');
  }else{
    $("#order_date").removeClass('is-invalid').addClass('is-valid');
    $(".date_err").removeClass('invalid-feedback').addClass('valid-feedback');
    $(".date_err").text('Looks Good');
    sessionStorage.setItem('order_date' ,od);
     $("#order_date").prop("readonly", false);
     $("#order_date").prop("disabled", true);
     displayCart();
}
});

$("#user").change(function(){
  var user = $("#user").val();
  if(user.length > 0){
    $("#user + span").removeClass('is-invalid').addClass('is-valid');
    $(".user_err").removeClass('err_form').addClass('success_form').text('Looks Good');
}
});










// Clear items
$('.clear-cart').click(function() {
  orderCart.clearCart();
  displayCart();
});

var order_discount = $('#discount_input').val()/100;
var shipping = $('#shipping').val();



$("#discount_input").on("input",function(){
      var net_discount =  $('#discount_input').val();
      if(net_discount > 99){
      alert("Discount Amount Must Not Greater Than 100");
      $("#discount_input").val(0);
      order_discount = 0;
      displayCart();
    }else if(net_discount < 0){
      alert("Discount Amount Must Not Negative");
      $("#discount_input").val(0);
      order_discount = 0;
      displayCart();
    }else{
      order_discount =  net_discount/100;
      displayCart();
    }
  });

  $("#shipping").on("input",function(){
      shipping =  $('#shipping').val();
      displayCart();
  });

var VAT_PERCENTAGE = '{{$order->vat+$order->tax}}';


function displayCart() {
  var cartArray = orderCart.listCart();
  var baseuel = '{{url('/')}}';
  var output = "";
  var subtotal = strip(orderCart.totalCart());
  var disc = strip(subtotal*order_discount);
  var netamount = strip(subtotal-disc);
  var vat = strip(parseFloat(netamount)*(VAT_PERCENTAGE/100));
  var g_total = strip(parseFloat(netamount)+parseFloat(shipping)+parseFloat(vat));

  for(var i in cartArray) {
    output += "<tr>"
      + "<td>" + cartArray[i].o_name + "</td>"
      + "<td><img style='width: 50px;' src='"+baseuel+"/public/uploads/products/tiny/"+cartArray[i].image+"' class='img-thumbnail' /></td>"
      + "<td>" + cartArray[i].price + " Tk.</td>"
      + "<td>"+ cartArray[i].count +"</td>"
      + "<td>" + Math.round(cartArray[i].total) + " Tk</td>"
      + "<td><button class='delete-item btn btn-sm badge-danger' data-name=" + cartArray[i].name + ">X</button></td>"
      +  "</tr>";
  }
  $('.show-cart').html(output);
  $('.total-cart').html(orderCart.totalCart());

  $('.date').html('Order Date: '+sessionStorage.order_date);
  $.get("{{url('/')}}/api/userinfo/"+sessionStorage.user_id, function(data, status){
      if(status === 'success'){
        $("#customer-info").html("<b>Name :</b>"+data.name+"</br><b>Address :</b>  "+data.address+"<br><b>Phone :</b> "+data.phone+"<br><b>Email :</b> "+data.email);

      }
  });

  $('.net-amount').text(netamount);

  $('.discount').text(Math.round(disc));
  $('.shipping').text(shipping);
  $('.vat').text(Math.round(vat));
  $('.grand-total').html(Math.round(g_total));
}

// Delete item button

$('.show-cart').on("click", ".delete-item", function(event) {
  var name = $(this).data('name')
  orderCart.removeItemFromCartAll(name);
  displayCart();
  if(cart.length < 1){
    $(".p_detail_wrapper").hide();
  }
})


// -1
$('.show-cart').on("click", ".minus-item", function(event) {
  var name = $(this).data('name')
  orderCart.removeItemFromCart(name);
  displayCart();
})
// +1
$('.show-cart').on("click", ".plus-item", function(event) {
  var name = $(this).data('name')
  orderCart.IncrementCart(name);
  displayCart();
})

// Item count input
$('.show-cart').on("change", ".item-count", function(event) {
   var name = $(this).data('name');
   var count = Number($(this).val());
  orderCart.setCountForItem(name, count);
  displayCart();
});

displayCart();


// Ajax

function confirm_order(){
  $(document).ready(function () {
    if(sessionStorage.orderCart.length < 3){
      alert('please select a product');
   }else{
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
          data: {
            'order_date' : sessionStorage.order_date,
            'user_id' : sessionStorage.user_id,
            'amount' : orderCart.totalCart(),
            'discount_percent' : order_discount*100,
            'shipping' : shipping,
            'item' : sum(orderCart.totalCount()),
            'product' : sessionStorage.orderCart,
          },
          url: "{{route('order.update', $order->id)}}",
          type: "PUT",
          dataType: 'json',
          success: function (data) {
              sessionStorage.clear();
              var b_url = '{{url('/')}}';
              var location = b_url+'/admin/ecom/order/'+data;
              window.location = location;

          },
          error: function (data) {
           sessionStorage.clear();
           if(data.status == 200){
              console.log(data.status);
           }else{
              console.log(data);
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
  $("#order_date").flatpickr({dateFormat: 'Y-m-d', allowInput: true});
</script>

@endpush


