@extends('layouts.adminlayout')
@section('title','Add New Product')


@section('modal')

    <!-- Modal -->
    <div class="modal fade" id="productModal" tabindex="-1" role="dialog" aria-labelledby="productModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="productModalLabel"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="modal-data">

                </div>

            </div>
        </div>
    </div>

@endsection


@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card">

                <div class="card-header">
                    <div class="row">
                        <div class="col-lg-4">
                            <a class="btn btn-info" href="{{route('products.index')}}">back</a>
                        </div>
                        <div class="col-lg-8">
                            <h5 class="card-title text-right">ADD NEW PRODUCTS</h5>
                        </div>
                    </div>
                </div>



                <div class="card-body table-responsive">
                    <form action="{{route('products.store')}}"  enctype="multipart/form-data"
                          id="product_form">
                        @csrf


                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="product_name">Product Name</label>
                                    <input type="text" class="form-control" name="product_name" id="product_name"
                                           placeholder="Enter Product Name">
                                    <small class="text-danger product_name_err"></small>
                                </div>


                                <div class="row">
                                    <div class="col-lg-10">
                                        <div class="form-group">
                                            <label for="size">Size</label>
                                            <select data-placeholder="Select a Size" name="size" id="size"
                                                    class="form-control">
                                                <option></option>
                                                @foreach ($sizes as $size)
                                                    <option value="{{$size->id}}">{{$size->name}}</option>
                                                @endforeach
                                            </select>
                                            <small class="text-danger size_err"></small>
                                        </div>
                                    </div>
                                    <div class="col-lg-2" style="margin-top: 28px">
                                        <button onclick="SizePopup('{{route('sizes.store')}}')" type="button"
                                                class="btn btn-info"><i class="fa fa-plus"></i></button>
                                    </div>
                                </div>
                                <div class="row d-none">
                                    <div class="col-lg-12 mb-3">
                                        <label for="show_in">Show In: </label>
                                        <select class="form-control" name="show_in" id="show_in">
                                            <option value="">-select a module-</option>
                                            <option value="ecom">E-commerce And Inventory Both</option>
                                            <option value="pos" selected>On Inventory Module</option>
                                        </select>
                                        <small class="text-danger show_in_err"></small>
                                        <p id="show_in_msg" class="alert alert-danger mt-3"></p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label for="mfg">Manufacturing Date (optional)</label>
                                            <input type="text" class="form-control" name="mfg" id="mfg"
                                                   placeholder="Select Manufacturing Date" value="{{old('mfg')}}">
                                            <small class="text-danger mfg_err"></small>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label for="exp">Expire Date (optional)</label>
                                            <input type="text" class="form-control" name="exp" id="exp"
                                                   placeholder="Select Expire Date" value="{{old('exp')}}">
                                            <small class="text-danger exp_err"></small>
                                        </div>
                                    </div>
                                </div>


                            </div>

                            <div class="col-lg-6">
                                <div class="row">
                                <div class="col-lg-10">
                                    <div class="form-group">
                                        <label for="brand">Brand</label>
                                        <select data-placeholder="Select a Brand"  name="brand" id="brand" class="js-example-responsive" name="brand">
                                            <option></option>
                                            @foreach ($brands as $brand)
                                                <option value="{{$brand->id}}">{{$brand->brand_name}}</option>
                                            @endforeach
                                        </select>
                                        <small class="text-danger brand_err"></small>
                                    </div>
                                </div>
                                <div class="col-lg-2" style="margin-top: 28px;">
                                    <button onclick="BrandPopup('{{route('brands.store')}}')" type="button" class="btn btn-primary"><i class="fa fa-plus"></i></button>
                                </div>
                            </div>



                            <div class="form-group">
                                <label for="image">Product Image</label>
                                <input type="file" class="form-control" name="image" id="product_image">

                                <small class="text-danger image_err"></small>

                            </div>
                            <div class="form-group">
                                <img style="display: none"  class="img-thumbnail rounded" src="" id="product_image_show" alt="">
                            </div>


                            <div class="form-group">
                                <strong>In Stock</strong> <br>
                                <div class="onoffswitch">
                                    <input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox" id="in-stock" tabindex="0" value="1" checked>
                                    <label class="onoffswitch-label" for="in-stock">
                                        <span class="onoffswitch-inner"></span>
                                        <span class="onoffswitch-switch"></span>
                                    </label>
                                </div>

                            </div>


                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="description">Product Description</label>
                                    <input id="description" type="hidden" name="description"
                                           value="{{old('description')}}">
                                    <trix-editor input="description" id="desc"></trix-editor>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <button type="button" onclick="productStore('{{route('products.store')}}')"
                                            id="fsubmit" class="btn btn-success">ADD
                                    </button>
                                </div>
                            </div>

                        </div>
                </form>
            </div>
        </div>
    </div>
    </div>


@endsection
@push('css')
    <link rel="stylesheet" href="{{asset('assets/css/trix.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/flatpicker.min.css')}}">
    <style>
        #show_in_msg {
            display: none;
        }

        .select2-container--bootstrap .select2-selection--multiple .select2-selection__choice__remove {
            color: #000 !important;
        }
    </style>
@endpush

@push('js')
    <script src="{{asset('assets/js/trix.js')}}"></script>
    <script src="{{asset('assets/js/axios.min.js')}}"></script>
    <script src="{{asset('assets/js/flatpicker.min.js')}}"></script>
    <script>
        let brandlisturl = '{{route('brandlist')}}';
        let sizelisturl = '{{route('sizelist')}}';
        let prouductlisturl = '{{route('products.index')}}';

        $("#show_in").change(function () {
            let s_value = $("#show_in").val();
            if (s_value === 'ecom') {
                $("#show_in_msg").text('N.B: Product Can be Accessed In both Inventory And Ecommerce Module').show();
            } else if (s_value === 'pos') {
                $("#show_in_msg").text('N.B: Product Can be Accessed Only For Inventory Module').show();
            } else {
                $("#show_in_msg").text('').hide();
            }
        });


        function BrandImageShow(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#brand_image').attr('src', e.target.result).show();
                }
                reader.readAsDataURL(input.files[0]);
            }
        }


        function productStore(url) {
            $(".text-danger").hide().text("");
            $('#fsubmit').html('<i class="fas fa-spinner fa-spin"></i> Please Wait...').attr('disabled', true);
            let frm = $("#product_form");
            let formData = new FormData(frm[0]);

            axios.post(url, formData)
                .then(res => {
                    toastr.success(res.data);
                    window.location = prouductlisturl;
                })

                .catch(err => {
                    console.log(err);
                    let errors = err.response.data.errors;
                    Object.keys(errors).forEach(function (value) {
                        toastr.error(errors[value][0])
                        $("." + value + "_err").text(errors[value][0]);
                    })
                    $('#fsubmit').text('ADD').attr('disabled', false);
                })

            $(".text-danger").show();
        }


        function SizePopup(url) {
            $("#productModalLabel").text('Add New Size');
            $("#modal-data").html(`<form id="size_form"> <div class="form-group">
        <label for="size_name">Size</label>
      <input type="text" class="form-control" name="size_name" id="size_name" placeholder="Enter Size Name" required>
      <small class="text-danger size_name_err"></small>
      </div> <button type="button" id="size_form_button" onclick="addSize('${url}')" class="btn btn-success">+ Add</button></div> </form>`);
            $('#productModal').modal('show');
        }

        function addSize(url) {
            $(".text-danger").hide().text("");
            $(".red-border").removeClass("red-border");
            $('#size_form_button').html('<i class="fas fa-spinner fa-spin"></i> Please Wait...').attr('disabled', true);
            let frm = $("#size_form");
            let formData = new FormData(frm[0]);

            axios.post(url, formData)
                .then(res => {
                    $('#size_form_button').text('+ Add').attr('disabled', false);
                    $('#productModal').modal('hide');
                    getSizeOptions();
                    toastr.success(res.data);
                })

                .catch(err => {
                    let errors = err.response.data.errors;
                    Object.keys(errors).forEach(function (value) {
                        $("#" + value + "").addClass("red-border");
                        $("." + value + "_err").text(errors[value][0]);
                    })
                    $('#size_form_button').text('+ Add').attr('disabled', false);
                })

            $(".text-danger").show();
        }


        function BrandPopup(url) {
            $("#productModalLabel").text('Add Brand');
            $("#modal-data").html(`<form id="brand_form"> <div class="form-group">
        <label for="brand_name">Brand Name</label>
      <input type="text" class="form-control" name="brand_name" id="brand_name" placeholder="Enter Brand Name" required>
      <small class="text-danger brand_name_err"></small>
      </div> <div class="form-group">
        <label for="image">Brand Image</label>
        <input onchange="BrandImageShow(this)" type="file" class="form-control" name="image" id="image" required>
        <small class="text-danger image_err"></small>
        <img  style="padding: 10px;display:none" class="img-thumbnail rounded" src="" id="brand_image" alt="">
      </div>
      <h5 class="mb-3">Show In Frontend</h5>
      <div class="onoffswitch">
                <input type="checkbox" name="frontend" class="onoffswitch-checkbox" id="frontend" value="1" >
                <label class="onoffswitch-label" for="frontend">
                    <span class="onoffswitch-inner"></span>
                    <span class="onoffswitch-switch"></span>
                </label>
            </div>  <div class="form-group"><button type="button" id="send_form" onclick="addBrand('${url}')" class="btn btn-success">+ Add</button></div> </form>`);
            $('#productModal').modal('show');
        }


        function addBrand(url) {
            $(".text-danger").hide().text("");
            $(".red-border").removeClass("red-border");
            $('#send_form').html('<i class="fas fa-spinner fa-spin"></i> Please Wait...').attr('disabled', true);
            let frm = $("#brand_form");
            let formData = new FormData(frm[0]);
            axios.post(url, formData)
                .then(res => {
                    $('#productModal').modal('hide');
                    toastr.success(res.data);
                    getBrandOptions();
                    $('#send_form').text('+ Add').attr('disabled', false);
                })

                .catch(err => {
                    let errors = err.response.data.errors;
                    Object.keys(errors).forEach(function (value) {
                        $("#" + value + "").addClass("red-border");
                        $("." + value + "_err").text(errors[value][0]);
                    })
                    $('#send_form').text('+ Add').attr('disabled', false);
                })


            $(".text-danger").show();


        }


        function sleep(milliseconds) {
            const date = Date.now();
            let currentDate = null;
            do {
                currentDate = Date.now();
            } while (currentDate - date < milliseconds);
        }

        function getBrandOptions() {
            let brandopt = "";
            axios.get(brandlisturl)
                .then(function (response) {
                    response.data.forEach(function (value) {
                        brandopt += `<option value="${value.id}">${value.brand_name}</option>`;
                    })
                    // handle success
                    $("#brand").html(brandopt);
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                })


        }


        function getSizeOptions() {
            let sizeopt = "";
            axios.get(sizelisturl)
                .then(function (response) {
                    response.data.forEach(function (value) {
                        sizeopt += `<option value="${value.id}">${value.name}</option>`;
                    })
                    // handle success
                    $("#size").html(sizeopt);
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                })

        }


        // Show Current Image On the Form Before Upload


        function ProductimageURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#product_image_show').attr('src', e.target.result).show();
                }

                reader.readAsDataURL(input.files[0]);
            }
        }


        $("#product_image").change(function () {
            ProductimageURL(this);
        });


        $("#AddImage").click(function () {
            var lsthmtl = $(".clone").html();
            $(".increment").after(lsthmtl);
        });
        $("body").on("click", "#removeImage", function () {
            $(this).parents(".hdtuto.control-group.lst").remove();
        });


        var colors = ["#eb4d4b", "#A3CB38", "#f1c40f", "#f39c12", "#2980b9", "#ff7979", "purple"];
        //For Addmodal


        $('#size').select2({
            width: '100%',
            theme: "bootstrap"
        });


        $('#product_type').select2({
            width: '100%',
            theme: "bootstrap"
        });

        $('#brand').select2({
            width: '100%',
            theme: "bootstrap",

        });

        $("#mfg").flatpickr({dateFormat: 'Y-m-d'});
        $("#exp").flatpickr({dateFormat: 'Y-m-d'});

    </script>



@endpush

