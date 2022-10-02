@extends('layouts.adminlayout')
@section('title','Edit Purchase')
@section('content')

  <div class="row">
    <div class="col-lg-12">

        <div class="p_wrapper">
          <div class="row">
            <div class="col-lg-4"><a href="{{route('purchase.index')}}" class="btn btn-sm btn-primary"><i class="fa fa-angle-left"></i> back</a></div>
            <div class="col-lg-8">
            <strong class="float-right">EDIT PURCHASE INVOICE #{{$purchase->id}}</strong>
            </div>
          </div>
          <hr>
           <div class="row">

            <div class="col-lg-4">
              <div class="form-group">
                <label for="sales_date">Date <button onclick="changeDate()" class="btn btn-link">(change)</button></label>
                @php
                    $mytime = Carbon\Carbon::now();
                @endphp
                <input type="text" class="form-control" name="purchase_date" id="purchase_date" value="{{$mytime->toDateString()}}" readonly>
                <div class="date_err"></div>
              </div>


              <div class="form-group">
                <label for="supplier">Supplier </label>
                <select data-placeholder="-select supplier-" class="js-example-responsive" name="supplier" id="supplier" class="form-control">
                <option></option>

                  @foreach ($suppliers as $supplier)
                <option value="{{$supplier->id}}">{{$supplier->name}}</option>
                  @endforeach

                </select>
                <div class="supplier_err err_form"></div>

              </div>


          </div>


          <div class="col-lg-6">
            <div class="form-group">
              <div id="customer-details"></div>
            </div>
          </div>



           <div class="col-lg-2">
          <div class="card">

            <div class="card-header">

                <span class="float-left"><b>RESET</b></span> <button type="button" onclick="reset()" id="reset" class="btn btn-success float-right"><i class="fa fa-sync-alt"></i> </button>
              </div>

            </div>
          </div>
        </div>
          <hr>
          <div id="error">

          </div>

            <div class="row">
              <div class="row">
                <div class="col-md-4">
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
                <div class="col-md-3">

                  <div class="form-group">
                    <label for="price">Purchase Price</label>
                    <input type="text" class="form-control" name="price" id="price" placeholder="Enter Purchase Price">
                    <div class="price_err"></div>
                  </div>

                  <div class="form-group">
                    <label for="sales_price">Sales Price</label>
                    <input type="text" class="form-control" name="sales_price" id="sales_price" placeholder="Enter Sales Price">
                    <div class="sales_price_err"></div>
                    <small class="badge badge-danger">Put 0 if you wanna fill it later</small>
                  </div>


                </div>

                <div class="col-md-3">
                  <div class="form-group">
                    <label for="qty">Quantity</label>
                    <input type="text" class="form-control" placeholder="Enter Qty" name="qty" id="qty">
                    <div class="qty_err"></div>
                  </div>

                  <div class="form-group">
                    <label for="cost">Extra Cost</label>
                    <input type="text" placeholder="Enter Extra Costing if any Price" class="form-control" name="cost" id="cost" value="0">
                    <div class="cost_err"></div>
                  </div>
                </div>

                <div class="col-md-2">
                  <div style="margin-top: 31px">
                    <button type="button"  class="btn btn-primary  add-to-cart">ADD <i class="fa fa-plus"></i></button>
                  </div>

                </div>
                </div>


            </div>




        </div>
    </div>

    <div class="col-lg-12">
      <hr>
      <div class="p_detail_wrapper table-responsive">
      <h3 class="text-center">PURCHASE INVOICE</h3>
        <h5 class="date"></h5> <br>

    <div class="table-responsive">
      <table class="table table-bordered table-striped">
        <thead class="table-dark">
          <tr>
            <td>Sl.</td>
            <td>Name</td>
            <td>Image</td>
            <td>Sales Price</td>
            <td>Purchase Price</td>
            <td>Qty</td>
            <td>Total</td>
            <td>Extra Cost</td>
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
            <td>Suppliers Subtotal</td>
            <td class="total-cart"></td>
          </tr>

          <tr>
            <td>Discount (%) <input type="text" class="form-control tiny-input" id="discount_input" value="0"></td>
            <td>Discount Amount <input type="text" class="discount form-control" value="{{round($purchase->discount)}}"></td>
          </tr>
          <tr>
            <td>Net Amount</td>
            <td class="net-amount"></td>
          </tr>
          <tr>
          <td>Carrying & Loading <input type="text" class="form-control tiny-input" id="carrying_and_loading" value="0"></td>
            <td class="carrying_and_loading">0</td>
          </tr>


          <tr>
            <td>Suppliers Payable Amount (without costing)</td>
            <td class="suppliers-amount"></td>
          </tr>
          <tr>
            <td>Extra Costing</td>
            <td class="extra-costing"></td>
          </tr>
          <tr>
            <td>Grand Total</td>
            <td class="grand-total"></td>
          </tr>


        </table>




      <button type="button" class="btn btn-primary"  id="confirm-btn" onclick="confirm_sales()">Confirm</button>

    </div>
    </div>
  </div>
  </div>

@endsection

@push('css')
<link rel="stylesheet" href="{{asset('assets/css/flatpicker.min.css')}}">
@endpush

@push('js')
<script src="{{asset('assets/js/flatpicker.min.js')}}"></script>
<script>

$("#purchase_date").flatpickr({dateFormat: 'Y-m-d', allowInput: true});
function changeDate(){
  $("#purchase_date").attr('disabled',false);
}


$.get("{{route('purchaseinfo.api',$purchase->id)}}",function(data, status){
  if(status === 'success'){
    if(sessionStorage.purchaseId == undefined ){
    sessionStorage.setItem('purchaseCart',JSON.stringify(data.purchaseCart));
    sessionStorage.setItem('supplier_id', data.supplier_id);
    sessionStorage.setItem('purchase_date' ,data.purchase_date );
    sessionStorage.setItem('purchaseId' ,data.purchase_id );
    location.reload();
  }else if(sessionStorage.purchaseId != data.purchase_id){
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
    location.reload();
  }

  $('#product').select2({
      width: '100%',
      theme: "bootstrap",
  });
  $('#supplier').select2({
      width: '100%',
      theme: "bootstrap",
  });
  if(sessionStorage.purchase_date != undefined){
     $('.date').html('Purchase  Date: '+sessionStorage.purchase_date);
  }
// If Shooping Cart Session Has Value Then Product Wrapeer Show
if(sessionStorage.purchaseCart != undefined){
  if(sessionStorage.purchaseCart.length > 2){
    $(".p_detail_wrapper").show();
  }else{
    $(".p_detail_wrapper").hide();
  }
}


if(sessionStorage.supplier_id!= undefined || sessionStorage.supplier_id!= undefined){
  $("#supplier").val(sessionStorage.supplier_id).trigger('change');
  $("#purchase_date").val(sessionStorage.purchase_date).prop("readonly", false).prop("disabled", true);
  $("#supplier").prop("disabled", true);
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



var purchaseCart = (function() {
  // =============================
  // Private methods and propeties
  // =============================
  cart = [];

  // Constructor
  function Item(name, price, count, id,o_name,image,cost,sales_price) {
    this.name = name;
    this.price = price;
    this.count = count;
    this.id    = id;
    this.o_name    = o_name;
    this.image    = image;
    this.cost    = cost;
    this.sales_price    = sales_price;

  }

  // Save cart
  function saveCart() {
    sessionStorage.setItem('purchaseCart', JSON.stringify(cart));
  }

    // Load cart
  function loadCart() {
    cart = JSON.parse(sessionStorage.getItem('purchaseCart'));
  }
  if (sessionStorage.getItem("purchaseCart") != null) {
    loadCart();
  }


  // =============================
  // Public methods and propeties
  // =============================
  var obj = {};

  // Add to cart
  obj.addItemToCart = function(name, price, count, id,o_name,image,cost,sales_price) {
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
    var item = new Item(name, price, count, id,o_name,image,cost,sales_price);
    cart.push(item);
    saveCart();
  }

  obj.IncrementCart = function(name, price, count, id,image,cost,sales_price) {
    for(var item in cart) {
      if(cart[item].name === name) {
        cart[item].count ++;
        saveCart();
        return;
      }
    }
    var item = new Item(name, price, count, id,image,cost,sales_price);
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

  obj.ExtraCosting = function() {
    var totalCart = 0;
    for(var item in cart) {
      totalCart += parseFloat(cart[item].cost);
    }
    return Number(totalCart);
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
  var purchase_date = $("#purchase_date").val();
  var supplier_id = $("#supplier option:selected").val();
  var qnty = $("#qty").val();
  var cost = $("#cost").val();
  var o_name = $("#product option:selected").text();
  var nameSlulg =  o_name.replace(/\s/g, '');
  var price = $("#price").val();
  var sales_price = $("#sales_price").val();


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

  if(cost < 0){
    $("#cost").addClass('is-invalid');
    $(".cost_err").addClass('invalid-feedback').text('Negative Number Not Allowed');
    err.push('qty');
  }else if(isNumber(cost) == false){
    $("#cost").addClass('is-invalid');
    $(".cost_err").addClass('invalid-feedback').text('Field Must Be Numeric');
    err.push('cost');
  }else{
    $("#cost").removeClass('is-invalid');
  }




  if(purchase_date.length === 0){
    $("#purchase_date").addClass('is-invalid');
    $(".date_err").addClass('invalid-feedback').text('Purchase  Date Field is Required');
    err.push('purchase_date');
  }else{
    $("#purchase_date").removeClass('is-invalid');
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


  if(sales_price.length === 0){
    $("#sales_price").addClass('is-invalid');
    $(".sales_price_err").addClass('invalid-feedback').text('Sales Price Field is Required');
    err.push('price');
  }else if(sales_price < 1){
    $("#sales_price").addClass('is-invalid');
    $(".sales_price_err").addClass('invalid-feedback').text('Negative Number Not Allowed');
    err.push('price');
  }else if(isNumber(sales_price) == false){
    $("#sales_price").addClass('is-invalid');
    $(".sales_price_err").addClass('invalid-feedback').text('Field Must Be Numeric');
    err.push('price');
  }else{
    $("#sales_price").removeClass('is-invalid');
  }


  if(supplier_id.length === 0){
    $("#supplier + span").addClass("is-invalid");
    $(".supplier_err").text('User Field is Required');
    err.push('supplier_id');
  }else{
    $("#supplier + span").removeClass("err_form");
    $(".supplier_err").text('');
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
    purchaseCart.addItemToCart(nameSlulg, price, qnty,id,o_name,image,cost,sales_price);
    $(".is-valid").removeClass('is-valid');

    //Cart session has data
    if(sessionStorage.purchaseCart.length > 2){
    $(".p_detail_wrapper").show();
    }

    //If Order Session empty
    if (sessionStorage.getItem("supplier_id") == null || sessionStorage.getItem("purchase_date") == null) {
      sessionStorage.setItem("supplier_id",supplier_id);
      sessionStorage.setItem("purchase_date",purchase_date);
    }
    displayCart();
    //Supllier Input Disabled
    $("#supplier").prop("disabled", true);
    $("#purchase_date").prop("readonly", false);
    $("#purchase_date").prop("disabled", true);
    $("#product").val("").trigger("change");;
    $("#product + span").removeClass("is-valid");
    $(".product_err").text('');
    $("#price").val("");
    $("#qty").val("");
    $("#cost").val(0);
    $("#selected-product-info").hide();
  }

  }
});
}
});


$( "#supplier" ).change(function() {
    var supplier_id = $("#supplier option:selected").val();
    $.get("{{url('/')}}/api/supplierinfo/"+supplier_id, function(data, status){
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
            if(data.discount_price == null){
              $("#selected-product-info").html("<img class='img-responsive img-thumbnail' src='"+baseuel+"/public/uploads/products/tiny/"+data[0].image+"' /> <br><b> "+data[0].product_name+"</b><br><span>Current Price : <b> "+data[0].price+" </b>Tk. </span>");
            }else{
              $("#selected-product-info").html("<img class='img-responsive img-thumbnail' src='"+baseuel+"/public/uploads/products/tiny/"+data[0].image+"' /> <br><b> "+data[0].product_name+"</b><br><del>Current Price : <b> "+data[0].price+" </b>Tk. </del><br><span>Discounted Price : <b> "+data[0].discount_price+" </b></span> Tk.<br>");
            }

            $("#selected-product-info").show();

            if(data.discount_price == null){
              $("#price").val(Math.round(data[0].price)).removeClass('is-invalid').addClass('is-valid');
            }else{
              $("#price").val(Math.round(data[0].discount_price)).removeClass('is-invalid').addClass('is-valid');
            }

            $(".price_err").removeClass('invalid-feedback').addClass('valid-feedback').text('Looks Good');
            $("#qty").val(1).removeClass('is-invalid').addClass('is-valid');
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

$("#sales_price").change(function(){
  var price = $("#sales_price").val();
  if(price.length === 0){
    $("#sales_price").removeClass('is-valid').addClass('is-invalid');
    $(".sales_price_err").removeClass('valid-feedback').addClass('invalid-feedback');;
    $(".sales_price_err").text('Sales Price Field is Required');
    $(".add-to-cart").prop('disabled', true);
  }else if(isNumber(price) == false){
    $("#sales_price").removeClass('is-valid').addClass('is-invalid');
    $(".sales_price_err").removeClass('valid-feedback').addClass('invalid-feedback');
    $(".sales_price_err").text('Filed Must Be Numeric');
    $(".add-to-cart").prop('disabled', true);
  }else{
    $("#sales_price").removeClass('is-invalid').addClass('is-valid');
    $(".sales_price_err").removeClass('invalid-feedback').addClass('valid-feedback');
    $(".sales_price_err").text('Looks Good');
    $(".add-to-cart").prop('disabled', false);
}
});



$("#cost").change(function(){
  let cost = $("#cost").val();
 if(isNumber(cost) == false){
    $("#cost").removeClass('is-valid').addClass('is-invalid');
    $(".cost_err").removeClass('valid-feedback').addClass('invalid-feedback');
    $(".cost_err").text('Filed Must Be Numeric');
    $(".add-to-cart").prop('disabled', true);
  }else{
    $("#cost").removeClass('is-invalid').addClass('is-valid');
    $(".cost_err").removeClass('invalid-feedback').addClass('valid-feedback');
    $(".cost_err").text('Looks Good');
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



$("#purchase_date").change(function(){
  var pd = $("#purchase_date").val();
  if(pd.length === 0){
    $("#purchase_date").removeClass('is-valid').addClass('is-invalid');
    $(".date_err").removeClass('valid-feedback').addClass('invalid-feedback');;
    $(".date_err").text('Qty Field is Required');
  }else{
    $("#purchase_date").removeClass('is-invalid').addClass('is-valid');
    $(".date_err").removeClass('invalid-feedback').addClass('valid-feedback');
    $(".date_err").text('Looks Good');
    sessionStorage.setItem("purchase_date",pd);
    $("#purchase_date").attr('disabled',true);
    displayCart()
}
});

$("#supplier").change(function(){
  var supplier = $("#supplier").val();
  if(supplier.length > 0){
    $("#supplier + span").removeClass('is-invalid').addClass('is-valid');
    $(".supplier_err").removeClass('err_form').addClass('success_form').text('Looks Good');
}
});

$("#product").change(function(){
  var product = $("#product").val();
  if(supplier.length > 0){
    $("#product + span").removeClass('is-invalid').addClass('is-valid');
    $(".product_err").removeClass('err_form').addClass('success_form').text('Looks Good');
}
});


// Clear items
$('.clear-cart').click(function() {
  purchaseCart.clearCart();
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
      var disc_amout = purchaseCart.totalCart()*sales_discount;
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





function displayCart() {
  var discount_amount = $(".discount").val();
  var cartArray = purchaseCart.listCart();
  var baseuel = '{{url('/')}}';
  var output = "";
  var subtotal = purchaseCart.totalCart();
  var extracost = purchaseCart.ExtraCosting();
  var disc = subtotal*sales_discount;
  var netamount = subtotal-discount_amount;
  var suppliers_amount = parseFloat(netamount)+parseFloat(carrying_and_loading);
  var j =1;
  for(var i in cartArray) {
    output += "<tr>"
      + "<td>" + j++ + "</td>"
      + "<td>" + cartArray[i].o_name + "</td>"
      + "<td><img style='width: 50px;' src='"+baseuel+"/public/uploads/products/tiny/"+cartArray[i].image+"' class='img-thumbnail' /></td>"
      + "<td>" + Math.round(cartArray[i].sales_price) + "</td>"
      + "<td>" + Math.round(cartArray[i].price) + "</td>"
      + "<td style='width: 150px;text-align: center;margin: 0 auto'><div class='input-group'><button class='minus-item input-group-addon btn btn-sm btn-primary' data-name=" + cartArray[i].name + ">-</button>"
      + "<input style='width: 65px' type='number' class='item-count' data-name='" + cartArray[i].name + "' value='" + cartArray[i].count + "'>"
      + "<button class='plus-item btn  btn-sm btn-primary  input-group-addon' data-name=" + cartArray[i].name + ">+</button></div></td>"
      + "<td>" + Math.round(cartArray[i].total) + "</td>"
      + "<td>" + cartArray[i].cost + "</td>"
      + "<td><button class='delete-item btn btn-sm badge-danger' data-name=" + cartArray[i].name + ">X</button></td>"
      +  "</tr>";
  }
  $('.show-cart').html(output);
  $('.total-cart').html(purchaseCart.totalCart());

  $('.date').html('Purchase  Date: '+sessionStorage.purchase_date);
  $('.net-amount').text(Math.round(netamount));
  $('.discount').text( Math.round(disc));
  $('.carrying_and_loading').text(carrying_and_loading);
  $('.suppliers-amount').html(Math.round(suppliers_amount));
  $('.extra-costing').text(extracost);
  $('.grand-total').text(Math.round(suppliers_amount+extracost));
}

// Delete item button

$('.show-cart').on("click", ".delete-item", function(event) {
  var name = $(this).data('name')
  purchaseCart.removeItemFromCartAll(name);
  displayCart();
  if(cart.length < 1){
    $(".p_detail_wrapper").hide();
  }
})


// -1
$('.show-cart').on("click", ".minus-item", function(event) {
  var name = $(this).data('name')
  purchaseCart.removeItemFromCart(name);
  displayCart();
})
// +1
$('.show-cart').on("click", ".plus-item", function(event) {
  var name = $(this).data('name')
  purchaseCart.IncrementCart(name);
  displayCart();
})

// Item count input
$('.show-cart').on("change", ".item-count", function(event) {
   var name = $(this).data('name');
   var count = Number($(this).val());
  purchaseCart.setCountForItem(name, count);
  displayCart();
});

displayCart();


// Ajax

function confirm_sales(){
  $(document).ready(function () {
    var discount_amount = $(".discount").val();

   if(sessionStorage.purchaseCart.length < 3){
      alert('please select a product');
   }else{
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
          data: {
            'purchase_date' : sessionStorage.purchase_date,
            'supplier_id' : sessionStorage.supplier_id,
            'discount' : discount_amount,
            'carrying_and_loading' : carrying_and_loading,
            'product' : sessionStorage.purchaseCart,
          },
          url: "{{route('purchase.update',$purchase->id)}}",
          type: "PUT",
          dataType: 'json',
          success: function (data) {
              console.log(data);
              sessionStorage.clear();
              var b_url = '{{url('/')}}';
              window.location = b_url+'/admin/purchase/'+data;

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


@endpush


