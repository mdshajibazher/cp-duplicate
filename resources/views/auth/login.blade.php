@extends('layouts.frontendlayout')
@section('title','Customer Login')
@section('content')
<div class="container py-2">
  <h4 class="text-center mt-5">CUSTOMER LOGIN</h4>
    <div class="row justify-content-center py-5">

        <div class="col-md-8 shadow p-0">

            <div class="row">

                <div class="col-md-5 p-0">

                    <div id="login-form">


                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            @if(Session::has('success'))
                            <div class="form-group row">
                            <span class="alert alert-success">{{Session::get('success')}}</span>
                            </div>
                            @endif

                            <div class="form-group row pt-2">

                                <div class="col-md-12">
                                    <input id="email" type="email"
                                        class="form-control @error('email') is-invalid @enderror" name="email"
                                        value="{{ old('email') }}" placeholder="{{__('E-Mail Address')}}" required
                                        autocomplete="email" autofocus>

                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">

                                <div class="col-md-12">
                                    <input id="password" type="password"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        required autocomplete="current-password" placeholder="{{__('Password')}}">

                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                            </div>

                            <div class="form-group row">

                                <div class="col-md-6">
                                    <div class="form-check pt-2">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                            {{ old('remember') ? 'checked' : '' }}>

                                        <label class="form-check-label" for="remember">
                                            {{ __('Remember Me') }}
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <button type="submit" class="btn btn-danger float-right">
                                        {{ __('Sign In') }}
                                    </button>

                                </div>
                            </div>

                            <div class="form-group row pt-3">


                                <div class="col-md-8">
                                    @if (Route::has('password.request'))
                                    <a class="float-right " href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                    @endif
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-md-7 p-0 login-image">

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('css')
<link href="{{ asset('assets/css/login.css') }}" rel="stylesheet">
@endpush
@push('js')

<script>

  var cartLink = '{{route('cartpage.index')}}';
    var checkoutLink = '{{route('checkoutpage.index')}}';

  function cancelOrder(id){
      const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: 'btn btn-success btn-sm',
            cancelButton: 'btn btn-danger btn-sm'
        },
        buttonsStyling: true
        })

  swalWithBootstrapButtons.fire({
  title: 'Are you sure Want to Cancel  Order ID  #'+id+'?',
  text: "Please Keep in mind You won't be able to revert this!",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Yes, Cancel it!'
  }).then((result) => {
        if (result.value) {
            event.preventDefault();
            document.getElementById('cancel-'+id).submit();
        } else if (
            /* Read more about handling dismissals below */
            result.dismiss === Swal.DismissReason.cancel
        ) {
            swalWithBootstrapButtons.fire(
            'Cancelled',
            'Your Order  is safe :)',
            'error'
            )
        }
        });
    }




      function displayCart() {
        var cartArray = shoppingCart.listCart();
        var output = "";
        for(var i in cartArray) {
          output += "<tr>"
            +"<td class='si-pic'><img src='"+cartArray[i].image +"' alt=''></td>"
            + "<td class='si-text'><div class='product-selected'><p>"+cartArray[i].price+"x " + cartArray[i].count + "="+Math.round(cartArray[i].total)+" Tk</p><h6>"+cartArray[i].o_name +"</h6>"
            +"</div></td>"
            + "<td class='si-close'><button class='delete-item btn' data-name=" + cartArray[i].name + "><i class='ti-close'></i></button></td>"
            +  "</tr>";
        }
        $('.show-cart').html(output);
        $('.cart-price').html(shoppingCart.totalCart() + 'Tk');
        $('.total-count').html(shoppingCart.totalCount());
        if(cart.length >0){
        $('.select-total').html('<span>total:</span><h5 class="total-cart">'+shoppingCart.totalCart()+'</h5>');
        $('.select-button').show();
        $('.select-button').html('<a href="'+cartLink+'" class="primary-btn view-card">VIEW CART</a><a href="'+checkoutLink+'" class="primary-btn checkout-btn">CHECK OUT</a>');
        }else{
          $('.select-button a').attr('disabled', true);
          $('.select-button').hide();
          $('.select-total').html('No Products On the Cart');

        }

      }

  </script>
  <script src="{{asset('assets/frontend/js/cart.js')}}"></script>
@endpush
