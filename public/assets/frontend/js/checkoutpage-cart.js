// Toaster
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


 // ************************************************
  // Shopping Cart API
  // ************************************************




var shoppingCart = (function() {
    // =============================
    // Private methods and propeties
    // =============================
    cart = [];
    
    // Constructor
    function Item(o_name,name, price, count, id,image,instock) {
      this.o_name    = o_name;
      this.name = name;
      this.price = price;
      this.count = count;
      this.id    = id;
      this.image    = image;
      this.instock    = instock;
      
    }
    
    // Save cart
    function saveCart() {
      localStorage.setItem('shoppingCart', JSON.stringify(cart));
    }

  function loadCart() {
    cart = JSON.parse(localStorage.getItem('shoppingCart'));
  }
  if (localStorage.getItem("shoppingCart") != null) {
    loadCart();
  }
    


    
  
    // =============================
    // Public methods and propeties
    // =============================
    var obj = {};
    
    // Add to cart
    obj.IncrementCart = function(name) {
      for(var item in cart) {
        if(cart[item].name === name) {
          cart[item].count ++;
          saveCart();
          return;
        }
      }
      var item = new Item(name);
      cart.push(item);
      saveCart();
    }
    

    obj.addItemToCart = function(o_name,name, price, count, id,image,instock) {
      for(var item in cart) {
        if(cart[item].name === name) {
          Toast.fire({
            icon: 'error',
            title: '"'+o_name+'" Already Added To cart'
          });

          return;
        }
      }


      if(instock == 1){
        $('#pd-'+id).html('<i class="icon_check"></i>').css('background','#44bd32');
          var item = new Item(o_name,name, price, count, id,image,instock);
          cart.push(item);
          saveCart();
          Toast.fire({
            icon: 'success',
            title: 'Successfully Added To cart'
          });
      }else{

        Swal.fire({
            icon: 'error',
            title: 'This Product Is Out Of Stock'
          });
            return;
      
      }







    
    }
  
  
  
  
    
    // Set count from item
    obj.setCountForItem = function(name, count) {
      for(var i in cart) {
        if (cart[i].name === name) {
          cart[i].count = count;
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
          Toast.fire({
            icon: 'success',
            title: '<strong style="color: red">'+cart[item].name+'</strong> &nbsp; Removed Successfully'
          });
          $('#pd-'+cart[item].id).html('<i class="icon_cart_alt"></i>');
          $('#pd-'+cart[item].id).css('background','#12CBC4');
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
      var totalCount = 0;
      for(var item in cart) {
          totalCount ++;
        //totalCount += cart[item].count;
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
   $('.cart-hover').show().delay(5000).fadeOut();
    var instock = $(this).data('instock');
    var o_name = $(this).data('name');
    var name = o_name.replace(/\s/g, '');
    var price = Number($(this).data('price'));
    var id = Number($(this).data('id'));
    var image = $(this).data('image');
    shoppingCart.addItemToCart(o_name,name, price, 1,id,image,instock);
    displayCart();
  });
  
  // Clear items
  $('.clear-cart').click(function() {
    shoppingCart.clearCart();
    displayCart();
  });
  
  



  
  // Delete item button
  
  $('.show-cart').on("click", ".delete-item", function(event) {
    let permission =  confirm("Are you sure you want to remove this from the cart?");
    if(permission){
    var name = $(this).data('name')
    shoppingCart.removeItemFromCartAll(name);
    displayCart();
    $("#cartdata").val(JSON.stringify(localStorage.shoppingCart));
    }
  })
  
  
  // -1
  $('.show-cart').on("click", ".minus-item", function(event) {
    var name = $(this).data('name')
    shoppingCart.removeItemFromCart(name);
    displayCart();
    $("#cartdata").val(JSON.stringify(localStorage.shoppingCart));
  })
  // +1
  $('.show-cart').on("click", ".plus-item", function(event) {
    var name = $(this).data('name')
    shoppingCart.IncrementCart(name);
    displayCart();
    $("#cartdata").val(JSON.stringify(localStorage.shoppingCart));
  })
  
  // Item count input
  $('.show-cart').on("change", ".item-count", function(event) {
     var name = $(this).data('name');
     var count = Number($(this).val());
    shoppingCart.setCountForItem(name, count);
    displayCart();
    $("#cartdata").val(JSON.stringify(localStorage.shoppingCart));
  });
  
  displayCart();