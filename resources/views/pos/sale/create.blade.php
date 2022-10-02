@extends('layouts.adminlayout')
@section('title','Create Sales Invoice')
@section('content')

  <div class="row">
    <div class="col-lg-12">

        <div class="p_wrapper">
          <div class="row">
            <div class="col-lg-4"><a href="{{route('sale.index')}}" class="btn btn-sm btn-warning"><i class="fa fa-angle-left"></i> back</a></div>
            <div class="col-lg-8">
               <strong class="float-right">CREATE SALES INVOICE</strong>
            </div>
          </div>
          <hr>
           <div class="row">

            <div class="col-lg-4">
              <div class="form-group">
                <label for="sales_date">Date</label>
                @php
                    $mytime = Carbon\Carbon::now();
                @endphp
                <input type="text" class="form-control" name="sales_date" id="sales_date" value="{{$mytime->toDateString()}}" readonly>
                <div class="date_err"></div>
              </div>


                <div class="form-group">
                <label for="user">Customer </label>
                <select  class="js-example-responsive" name="user" id="user" class="form-control">
                  @foreach ($users as $user)
                <option value="{{$user->id}}">{{$user->name}}</option>
                  @endforeach
                </select>
                <div class="user_err err_form"></div>
              </div>


          </div>


          <div class="col-lg-5">
              <div class="form-group">
                  <label for="user">Warehouse </label>
                  <select  class="form-control" name="warehouse_id" id="warehouse_id" class="form-control">
                      @foreach ($warehouses as $warehouse)
                          <option value="{{$warehouse->id}}" @if($g_opt_value['warehouse_id'] == $warehouse->id) selected @else disabled @endif >{{$warehouse->name}}</option>
                      @endforeach
                  </select>
              </div>
            <div class="form-group">
              <div id="customer-details"></div>
            </div>
          </div>



           <div class="col-lg-3">
          <div class="card">

            <div class="card-header">

                <span class="float-left"><b>RESET FIELDS</b></span> <button type="button" onclick="reset()" id="reset" class="btn btn-success float-right"><i class="fa fa-sync-alt"></i> </button>
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


            <div class="col-lg-2">
              <div class="form-group">
                <label for="qty">Quantity</label>
                <input type="number" class="form-control" name="qty" id="qty" placeholder="Enter Qty">
                <div class="qty_err"></div>
              </div>
            </div>

                <div class="col-lg-2 col-md-2">

                  <div class="form-group">
                    <label for="price">Price</label>
                    <input type="number" class="form-control" name="price" id="price" placeholder="Enter Price" >
                    <div class="price_err"></div>
                  </div>


                </div>



                <div class="col-lg-2">
                  <div class="form-group">
                    <label for="qty">Free (optional)</label>
                    <input type="number" class="form-control" name="free" id="free" placeholder="Enter Free" value="0">
                    <div class="free_err"></div>
                  </div>
                </div>
                <div class="col-lg-2">
                  <div style="margin-top: 31px">
                    <button type="button"  class="btn btn-warning  add-to-cart">ADD <i class="fa fa-plus"></i></button>
                  </div>

                </div>


            </div>




        </div>
    </div>

    <div class="col-lg-12">
      <hr>
      <div class="p_detail_wrapper table-responsive">
        <h3 class="text-center">SALES INVOICE</h3>
        <h5 class="date"></h5> <br>
      <br><br>
    <div class="table-responsive">
      <table class="table table-bordered table-striped">
        <thead class="table-dark">
          <tr>
            <td>Sl.</td>
            <td>Name</td>
            <td>Image</td>
            <td>Qty</td>
            <td>Price</td>
            <td>Size</td>
            <td>Free</td>
            <td>Total</td>
            <td>Action</td>
          </tr>
        </thead>

        <tbody class="show-cart">

        </tbody>

      </table>
      </div>
      <div class="row">
      <div class="col-lg-7 mt-3">
        <div style="border: 1px solid #ddd;padding: 30px;border-radius: 10px">
          <h5>Is Condition Booking</h5>
          <div class="onoffswitch">
            <input type="checkbox"  class="onoffswitch-checkbox" id="is_condition" value="1">
            <label class="onoffswitch-label" for="is_condition">
                <span class="onoffswitch-inner"></span>
                <span class="onoffswitch-switch"></span>
            </label>
        </div>

          <input type="text" class="form-control mt-3" id="condition_amount" placeholder="Enter Condition Booking Amount">
      </div>

      <div class="form-group">
        <h5 class="mt-3 mb-3">References</h5>
        <textarea class="form-control" name="reference" id="reference" cols="30" rows="5" placeholder="Enter Reference"></textarea>
      </div>

      </div>
      <div class="col-lg-5" id="amount-info">

        <table class="table table-bordered">
          <tr>
            <td>Subtotal</td>
            <td class="total-cart"></td>
          </tr>

          <tr>
            <td>Discount (%) <input type="number" class="form-control tiny-input" id="discount_input" value="0"></td>
            <td>Discount Amount <input type="text" class="discount form-control" value="0"></td>
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




      <button type="button" class="btn btn-warning"  id="confirm-btn" onclick="confirm_sales()">Confirm</button>

    </div>
    </div>
  </div>
  </div>

@endsection

@push('css')
<link rel="stylesheet" href="{{asset('assets/css/flatpicker.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/css/animate.css')}}">
<style>
  #condition_amount{
    display: none;
  }
</style>
@endpush

@push('js')
<script src="{{asset('assets/js/axios.min.js')}}"></script>


<script>
var baseurl = '{{url('/')}}';


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

if($('#is_condition').prop("checked") == true){
      $("#condition_amount").show();
    }
    else if($(this).prop("checked") == false){
      $("#condition_amount").val('').hide();
}

$("#is_condition").change(function(){
  if($(this).prop("checked") == true){
      $("#condition_amount").show();
    }
    else if($(this).prop("checked") == false){
      $("#condition_amount").val('').hide();
    }

  })



function isNumber(n) { return !isNaN(parseFloat(n)) && !isNaN(n - 0) }
var salestoreurl = '{{route('sale.store')}}';
function displayCart() {
  var discount_amount = $(".discount").val();
  var cartArray = salesCart.listCart();
  var output = "";
  var subtotal = salesCart.totalCart();
  var disc = subtotal*sales_discount;
  var netamount = subtotal-discount_amount;
  var g_total = parseFloat(netamount)+parseFloat(carrying_and_loading);
  var j =1;
  for(var i in cartArray) {
    output += "<tr>"
      + "<td>" + j++ + "</td>"
      + "<td>" + cartArray[i].o_name + "</td>"
      + "<td><img style='width: 50px;' src='"+baseurl+"/public/uploads/products/tiny/"+cartArray[i].image+"' class='img-thumbnail' /></td>"
      + "<td>"+ cartArray[i].count +"</td>"
      + "<td>" + cartArray[i].price + "</td>"
      + "<td>" + cartArray[i].product_size + "</td>"
      + "<td>"+ cartArray[i].free +"</td>"
      + "<td>" + Math.round(cartArray[i].total) + "</td>"
      + "<td><button class='delete-item btn btn-sm badge-danger' data-name=" + cartArray[i].name + ">X</button></td>"
      +  "</tr>";
  }
  $('.show-cart').html(output);
  $('.total-cart').html(salesCart.totalCart());

  $('.date').html('Sales Date: '+sessionStorage.sales_date);
  $('.net-amount').text(Math.round(netamount));
  $('.discount').text( Math.round(disc));
  $('.carrying_and_loading').text(carrying_and_loading);
  $('.grand-total').html(Math.round(g_total));
}






  function reset(){
    var conf = confirm('Are you sure you want to Reset All the Field?');
    if(conf == true){
      sessionStorage.clear();
      $("#reset").html('<div class="fa-1x"><i class="fas fa-spinner fa-spin"></i></div>');
      location.reload(true);
    }

  }

  $('#product').select2({
      width: '100%',
      theme: "bootstrap",
  });
  $('#user').select2({
      width: '100%',
      theme: "bootstrap",
  });
  if(sessionStorage.sales_date != undefined){
     $('.date').html('Sales Date: '+sessionStorage.sales_date);
  }
// If Shooping Cart Session Has Value Then Product Wrapeer Show
if(sessionStorage.salesCart != undefined){
  if(sessionStorage.salesCart.length > 2){
    $(".p_detail_wrapper").show();
  }else{
    $(".p_detail_wrapper").hide();
  }
}


if(sessionStorage.user_id!= undefined || sessionStorage.user_id!= undefined){
  $("#user").val(sessionStorage.user_id).trigger('change');
  $("#sales_date").val(sessionStorage.sales_date);
  $("#user").prop("disabled", true);
  $("#sales_date").prop("readonly", false);
  $("#sales_date").prop("disabled", true);
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

var salesCart = (function() {
  // =============================
  // Private methods and propeties
  // =============================
  cart = [];

  // Constructor
  function Item(name, price, count, id,o_name,image,product_size,free) {
    this.name = name;
    this.price = price;
    this.count = count;
    this.id    = id;
    this.o_name    = o_name;
    this.image    = image;
    this.product_size = product_size;
    this.free = free;

  }

  // Save cart
  function saveCart() {
    sessionStorage.setItem('salesCart', JSON.stringify(cart));
  }

    // Load cart
  function loadCart() {
    cart = JSON.parse(sessionStorage.getItem('salesCart'));
  }
  if (sessionStorage.getItem("salesCart") != null) {
    loadCart();
  }


  // =============================
  // Public methods and propeties
  // =============================
  var obj = {};

  // Add to cart
  obj.addItemToCart = function(name, price, count, id,o_name,image,product_size,free) {
    for(var item in cart) {
      if(cart[item].name === name) {
       Toast.fire({
          icon: 'error',
          title: 'Oops... This Product Already Added',
        })
        return;
      }
    }
    var item = new Item(name, price, count, id,o_name,image,product_size,free);
    cart.push(item);
    saveCart();
  }

  obj.IncrementCart = function(name, price, count, id,image,product_size,free) {
    for(var item in cart) {
      if(cart[item].name === name) {
        cart[item].count ++;
        saveCart();
        return;
      }
    }
    var item = new Item(name, price, count, id,image,product_size,free);
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
  var sales_date = $("#sales_date").val();
  var user_id = $("#user option:selected").val();
  var qnty = $("#qty").val();
  var free = $("#free").val();
  var o_name = $("#product option:selected").text();
  var nameSlulg =  o_name.replace(/\s/g, '');
  var price = $("#price").val();

  var err = [];

  if(free.length === 0){
    $("#free").addClass('is-invalid');
    $(".free_err").addClass('invalid-feedback').text('free Field is Required');
    err.push('free');
  }else if(free < 0){
    $("#free").addClass('is-invalid');
    $(".free_err").addClass('invalid-feedback').text('Negative Number Not Allowed');
    err.push('free');
  }else if(isNumber(free) == false){
    $("#free").addClass('is-invalid');
    $(".free_err").addClass('invalid-feedback').text('Field Must Be Numeric');
    err.push('free');
  }else{
    $("#free").removeClass('is-invalid');
  }

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


  if(sales_date.length === 0){
    $("#sales_date").addClass('is-invalid');
    $(".date_err").addClass('invalid-feedback').text('Sales Date Field is Required');
    err.push('sales_date');
  }else{
    $("#sales_date").removeClass('is-invalid');
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
    $("#user + span").removeClass("is-invalid");
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
  $.get(baseurl+"/api/productinfo/"+id, function(data, status){
    if(status === 'success'){
      var image = data[0].image;
      var current_stock = data[1];
      var product_size = data[0].size.name;
    if(err.length<1){
      if(current_stock < 1){
        alert('Warning! This Product Is Out Of Stock');
        //salesCart.addItemToCart(nameSlulg, price, qnty,id,o_name,image,product_size,free);
        return;
      }else if(current_stock < qnty){

          alert('Warning! This Product Is Out Of Stock');
        //salesCart.addItemToCart(nameSlulg, price, qnty,id,o_name,image,product_size,free);
            return;

      }else{
    salesCart.addItemToCart(nameSlulg, price, qnty,id,o_name,image,product_size,free);

    }

    //Cart session has data
    if(sessionStorage.salesCart.length > 2){
    $(".p_detail_wrapper").show();
    }

    //If Order Session empty
    if (sessionStorage.getItem("user_id") == null || sessionStorage.getItem("sales_date") == null) {
      sessionStorage.setItem("user_id",user_id);
      sessionStorage.setItem("sales_date",sales_date);
    }
    displayCart();
    //Supllier Input Disabled
    $("#user").prop("disabled", true);
    $("#sales_date").prop("readonly", false);
    $("#sales_date").prop("disabled", true);
    $("#product").val("").trigger("change");;
    $(".product_err").text('');
    $("#price").val("");
    $("#qty").val("");
    $("#free").val(0);
    $("#selected-product-info").hide();
  }

  }
});
}
});


$( "#user" ).change(function() {
  $("#user + span").removeClass("is-invalid");
  $(".user_err").text('');
    var user_id = $("#user option:selected").val();
    $.get("{{url('/')}}/api/userinfo/"+user_id, function(data, status){
      if(status === 'success'){
  $("#customer-details").html('<p>Customer Details</p><table class="table table-bordered table-sm"><tr><th scope="col">Name</th> <td>'+data.name+'</td></tr><tr><th scope="col">Email</th><td>'+data.inventory_email+'</td></tr><tr><th scope="col">Phone</th><td>'+data.phone+'</td></tr><tr><th scope="col">Address</th><td>'+data.address+'</td></tr></table>');

      }
    });

});




$( "#product").change(function() {
  var rate = 0;
  let product_id = $("#product option:selected").val();
  $("#product + span").removeClass("is-invalid");
  $(".product_err").text('');

  //if id found
  if(product_id.length > 0){
  let current_user_id = $("#user option:selected").val();
  function getProductInfo() {
    return axios.get(baseurl+"/api/productinfo/"+product_id);
  }
  function getUserInfo() {
    return axios.get(baseurl+"/api/userinfo/"+current_user_id);
  }


  axios.all([getProductInfo(),getUserInfo()])

  .then(function (response) {

  let productresponse =  JSON.parse(response[0].request.response);
  let userresponse = JSON.parse(response[1].request.response);

  $("#selected-product-info").html('<table class="table table-sm table-dark table-hover"><tr><td> <b>'+productresponse[0].product_name+'</b></td></tr><tr><td><img class="img-responsive img-thumbnail" src="'+baseurl+'/public/uploads/products/tiny/'+productresponse[0].image+'" /></td></tr><tr><td> Size: '+productresponse[0].size.name+'</td></tr><tr><td>Trade Price: '+productresponse[0].tp+'</td></tr><td>Current Stock : '+productresponse[1]+'</td></tr></table>');
  $("#selected-product-info").show();
  $("#qty").val('').removeClass('is-invalid');




  if(userresponse.pricedata){

  let custompriceinit = JSON.parse(userresponse.pricedata);
  let pricedata = JSON.parse(custompriceinit);

  pricedata.forEach(function(item, index,arr){
      if(product_id == item.id){
        Swal.fire('Special Rate '+item.price+' tk Found','For:  '+userresponse.name+' Product: '+ item.o_name+' Rate : '+item.price,'info');


        rate = Math.round(item.price);
      }

  })
  if(rate > 0){
    $("#price").val(Math.round(rate));
  }else{
    $("#price").val(Math.round(productresponse[0].tp));
  }


  }else{
    $("#price").val(Math.round(productresponse[0].tp));
  }

  })


    .catch(function (error) {
    // handle error
    console.log(error);
    })



    }
    //end product id found


});


$("#qty").change(function(){
  var qnty = $("#qty").val();
  if(qnty.length === 0){
    $("#qty").addClass('is-invalid');
    $(".qty_err").addClass('invalid-feedback');
    $(".qty_err").text('Qty Field is Required');
    $(".add-to-cart").prop('disabled', true);
  }else if(isNumber(qnty) == false){
    $("#qty").addClass('is-invalid');
    $(".qty_err").addClass('invalid-feedback');
    $(".qty_err").text('Filed Must Be Numeric');
    $(".add-to-cart").prop('disabled', true);
  }else{
    $("#qty").removeClass('is-invalid');
    $(".qty_err").removeClass('invalid-feedback');
    $(".qty_err").text('');
    $(".add-to-cart").prop('disabled', false);
}
});

$("#free").on("input",function(){

  let free = $("#free").val();
  if(free.length === 0){
    $("#free").addClass('is-invalid');
    $(".free_err").addClass('invalid-feedback').text('free Field is Required');
    $(".add-to-cart").prop('disabled', true);
  }else if(isNumber(free) == false){
    $("#free").addClass('is-invalid');
    $(".free_err").addClass('invalid-feedback').text('Filed Must Be Numeric');
    $(".add-to-cart").prop('disabled', true);
  }else{
    $("#free").removeClass('is-invalid');
    $(".free_err").removeClass('invalid-feedback').text('');
    $(".add-to-cart").prop('disabled', false);
}
});

$("#price").change(function(){
  var price = $("#price").val();
  if(price.length === 0){
    $("#price").addClass('is-invalid');
    $(".price_err").addClass('invalid-feedback');;
    $(".price_err").text('Price Field is Required');
    $(".add-to-cart").prop('disabled', true);
  }else if(isNumber(price) == false){
    $("#price").addClass('is-invalid');
    $(".price_err").addClass('invalid-feedback');
    $(".price_err").text('Filed Must Be Numeric');
    $(".add-to-cart").prop('disabled', true);
  }else{
    $("#price").removeClass('is-invalid');
    $(".price_err").removeClass('invalid-feedback');
    $(".price_err").text('');
    $(".add-to-cart").prop('disabled', false);
}
});



$("#sales_date").change(function(){
  var od = $("#sales_date").val();
  if(od.length === 0){
    $("#sales_date").addClass('is-invalid');
    $(".date_err").addClass('invalid-feedback');
    $(".date_err").text('Date Field is Required');
  }else{
    $("#sales_date").removeClass('is-invalid');
    $(".date_err").removeClass('invalid-feedback');
    $(".date_err").text('');
}
});






// Clear items
$('.clear-cart').click(function() {
  salesCart.clearCart();
  displayCart();
});

var sales_discount = $('#discount_input').val()/100;
var carrying_and_loading = $('#carrying_and_loading').val();


  $("#discount_input").on("input",function(){
    var net_discount =  $('#discount_input').val();
    if(net_discount > 99){
      alert("Discount Amount Must Not Greater Than 100");
      $("#discount_input").val(0);
      $(".discount").val(0);
      displayCart();
    }else if(net_discount < 0){
      alert("Discount Amount Must Not Negative");
      $("#discount_input").val(0);
      $(".discount").val(0);
      displayCart();
    }else{
    sales_discount =  net_discount/100;
      var disc_amout = salesCart.totalCart()*sales_discount;
      $(".discount").val(Math.round(disc_amout));
      displayCart();
    }
  });

  $(".discount").on("input",function(){
    var net_discount_amount =  $('.discount').val();
    $("#discount_input").val('0');
    $(".discount").val(net_discount_amount);
    displayCart();
  });



  $("#carrying_and_loading").on("input",function(){
      if($('#carrying_and_loading').val() < 1){
        carrying_and_loading =  0;
        $('#carrying_and_loading').val(0);
      }else if($('#carrying_and_loading').val() < 0){
        alert('Must Not Be Negative');
        carrying_and_loading =  0;
        $('#carrying_and_loading').val(0);

      }else{
        carrying_and_loading =  $('#carrying_and_loading').val();
      }

      displayCart();
  });





// Delete item button

$('.show-cart').on("click", ".delete-item", function(event) {
  var name = $(this).data('name')
  salesCart.removeItemFromCartAll(name);
  displayCart();
  if(cart.length < 1){
    $(".p_detail_wrapper").hide();
  }
})


// -1
$('.show-cart').on("click", ".minus-item", function(event) {
  var name = $(this).data('name')
  salesCart.removeItemFromCart(name);
  displayCart();
})
// +1
$('.show-cart').on("click", ".plus-item", function(event) {
  var name = $(this).data('name')
  salesCart.IncrementCart(name);
  displayCart();
})

// Item count input
$('.show-cart').on("change", ".item-count", function(event) {
   var name = $(this).data('name');
   var count = Number($(this).val());
  salesCart.setCountForItem(name, count);
  displayCart();
});


if (sessionStorage.getItem("salesCart") != null) {
    displayCart()
}



function SendSalesDataAxios(discount_amount,carrying_and_loading,is_condition,condition_amount){
    let  warehouse_id = $("#warehouse_id").val();
  axios.post(salestoreurl, {
        'sales_date' : sessionStorage.sales_date,
        'user_id' : sessionStorage.user_id,
        'discount' : discount_amount,
        'carrying_and_loading' : carrying_and_loading,
        'is_condition' : is_condition,
        'condition_amount' : condition_amount,
        'product' : sessionStorage.salesCart,
        'warehouse_id':  warehouse_id,
  })
  .then(function (response) {
    sessionStorage.clear();
   window.location = baseurl+'/admin/pos/sale/'+response.request.response
    console.log(response);
  })
  .catch(function (error) {
    console.log(error);
  });
}


// Ajax

function confirm_sales(){

   if(sessionStorage.salesCart.length < 3){
      alert('please select a product');
   }else{

    let discount_amount = $(".discount").val();
    let condition_amount = $("#condition_amount").val();
    let is_condition = 0;
    let conf = false;
    if($("#is_condition").prop("checked") == true){
      is_condition = 1;
      if(condition_amount === ""){
          Swal.fire({
                    icon: 'error',
            title: 'Oops... Condition Booking Amount Must Not be Empty',
            showClass: {
              popup: 'animate__animated animate__fadeInDown'
            },
            hideClass: {
              popup: 'animate__animated animate__fadeOutUp'
            }
          })
        return;
      }else if(isNaN(condition_amount) == true )

              Swal.fire({
                icon: 'error',
                title: 'Condition Booking Amount Must be a Integer Number',
                showClass: {
                  popup: 'animate__animated animate__fadeInDown'
                },
                hideClass: {
                  popup: 'animate__animated animate__fadeOutUp'
                }
              })

      else{
        Swal.fire({
  title: 'Are you sure? this invoice is courier conditioned and condition booking amount is  '+condition_amount,
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#44bd32',
  cancelButtonColor: '#EA2027',
  confirmButtonText: 'Yes, Confirm!'
}).then((result) => {
    if(!result.dismiss){
        SendSalesDataAxios(discount_amount,carrying_and_loading,is_condition,condition_amount);
        $('#confirm-btn').attr('disabled',true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading.....' );
    }
  if (result.isConfirmed) {
    Swal.fire(
      'Deleted!',
      'Your file has been deleted.',
      'success'
    )
  }
});
      }

    }else{
      SendSalesDataAxios(discount_amount,carrying_and_loading,is_condition,condition_amount);
      $('#confirm-btn').attr('disabled',true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading.....' );
    }

    }



}




</script>

<script src="{{asset('assets/js/flatpicker.min.js')}}"></script>
<script>
  $("#sales_date").flatpickr({dateFormat: 'Y-m-d', allowInput: true});
</script>

@endpush


