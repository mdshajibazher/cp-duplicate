@extends('layouts.adminlayout')
@section('title','Inventory Previous Due')
@section('modal')
    <!--Insert Modal -->
    @component('component.common.modal')

        @slot('modal_id')
            addDataModal
        @endslot
        @slot('modal_size')
            modal-md
        @endslot


        @slot('submit_button')
            add_modal_submit
        @endslot
        @slot('modal_title')
            Cash
        @endslot

        @slot('modal_form')
            <form action="{{route('prevdue.store')}}" method="POST" id="addForm" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                @endslot



                @slot('modal_body')
                    <div class="form-group">
                        <label for="due_at">Previous Due Date</label>
                        @php
                            $mytime = Carbon\Carbon::now();
                        @endphp
                        <input type="text" class="form-control @error('due_at') is-invalid @enderror" name="due_at"
                               id="due_at" value="{{old('due_at',$mytime->toDateString())}}">
                        @error('due_at')
                        <small class="form-error">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="user">Customer</label>
                        <select data-placeholder="Select a User" name="user" id="user"
                                class="form-control @error('user') is-invalid @enderror">
                            <option></option>
                            @foreach ($users as $user)
                                <option value="{{$user->id}}"
                                        @if (old('user') == $user->id) selected @endif>{{$user->name}}</option>
                            @endforeach
                        </select>
                        @error('user')
                        <small class="form-error">{{ $message }}</small>
                        @enderror
                        <div id="user-details"></div>
                    </div>
                    <div class="form-group">
                        <label for="amount">Amount</label>
                        <input type="text" class="form-control @error('amount') is-invalid @enderror" name="amount"
                               id="amount" placeholder="Enter Amount" value="{{old('amount')}}">
                        @error('amount')
                        <small class="form-error">{{ $message }}</small>
                        @enderror
                    </div>


                    <div class="form-group">
                        <label for="reference">Reference</label>
                        <input type="text" class="form-control @error('reference') is-invalid @enderror"
                               name="reference" id="reference" placeholder="Enter Referance"
                               value="{{old('reference')}}">
                        @error('reference')
                        <small class="form-error">{{ $message }}</small>
                        @enderror
                    </div>

                @endslot
                @endcomponent
                <!--End Insert Modal -->







                @endsection
                @section('content')

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <h5 class="card-title text-left">Inventory Previous Due</h5>
                                        </div>
                                        <div class="col-lg-6">
                                            @can('previous_due.create')
                                                <button type="button" onclick="addMode('{{route('prevdue.store')}}')"
                                                        class="btn btn-info btn-sm float-right"><i
                                                        class="fas fa-plus"></i> Add New Previous Due
                                                </button>
                                            @endcan
                                        </div>

                                    </div>


                                </div>
                                <div class="card-body table-responsive">

                                    <table class="table table-bordered table-striped table-hover mt-3"
                                           id="jq_datatables">
                                        <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Date</th>
                                            <th scope="col">User</th>
                                            <th scope="col">Amount</th>
                                            <th scope="col">Reference</th>
                                            <th scope="col">Posted By</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @php
                                            $i =1;
                                        @endphp
                                        @foreach ($prevdues as $pd)
                                            <tr>
                                                <td>{{$i++}}</td>
                                                <td>{{$pd->due_at->format('d-m-Y g:i a')}}</td>
                                                <td>{{$pd->user->name}}</td>
                                                <td>{{$pd->amount}}</td>
                                                <td>{{$pd->reference}}</td>
                                                <td>{{$pd->admin->name}}</td>
                                                <td>
                                                    @can('previous_due.create')
                                                        <button class="btn btn-primary btn-sm" id="open_modal"
                                                                onclick="EditProcess('{{route('prevdue.edit',$pd->id)}}','{{route('prevdue.update',$pd->id)}}')"
                                                                data-baseurl="{{asset('')}}"><i class="fas fa-edit"></i>
                                                        </button>
                                                    @endcan

                                                </td>
                                            </tr>
                                        @endforeach


                                        </tbody>
                                    </table>

                                </div>
                            </div>
                        </div>

                    </div>

                @endsection

                @push('css')
                    <link rel="stylesheet" href="{{asset('assets/css/flatpicker.min.css')}}">
                    <link rel="stylesheet" href="{{asset('assets/css/dataTables.bootstrap4.min.css')}}">
                @endpush

                @push('js')
                    @if ($errors->any())
                        {{-- prevent The Modal Close If Any Error In the Form --}}
                        <script>

                            if (sessionStorage.getItem("editMode") === 'true') {
                                $('#addDataModal').modal('show');
                                $('#addForm').attr('action', sessionStorage.getItem("update_url"));

                            } else {
                                $('#addDataModal').modal('show');
                                $('#addForm').attr('action', sessionStorage.getItem("store_url"));
                                putremove = $('input[value="PUT"]').detach();

                            }

                        </script>
                    @endif



                    <script>
                        $("#user").change(function () {
                            var user_id = $("#user option:selected").val();
                            $.get("{{url('/')}}/api/userinfo/" + user_id, function (data, status) {
                                if (status === 'success') {
                                    $('#user-details').show();
                                    $("#user-details").html("<div class='user-deatils'><h4 class='text-center'> " + data.name + "</h4><br><b>Address :</b> " + data.address + "<br><b>Phone :</b> " + data.phone + "<br><b>Email :</b>" + data.inventory_email + "</div>");

                                }
                            });
                        });


                        var putremove;

                        // Exit The Edit Mode

                        function addMode(store_url) {
                            $('#addDataModal').modal('show');
                            $('.modal-title').text('Add Previous Due');
                            if (typeof (Storage) !== "undefined") {
                                // Store
                                sessionStorage.setItem("editMode", false);
                                sessionStorage.setItem("store_url", store_url);
                            }
                            $('#addForm').attr('action', store_url);
                            $('#addForm').trigger("reset");
                            $(".is-invalid").removeClass("is-invalid");
                            $(".form-error").remove();
                            $('#user').val('').trigger('change');
                            $('#user-details').hide();
                            if (putremove == undefined) {
                                putremove = $('input[value="PUT"]').detach();
                            }

                        }

                        // Show Current Image On the Form Before Upload

                        function addProductreadURL(input) {
                            if (input.files && input.files[0]) {
                                var reader = new FileReader();

                                reader.onload = function (e) {
                                    $('#pd_image2').attr('src', e.target.result);
                                }

                                reader.readAsDataURL(input.files[0]); // convert to base64 string
                            }
                        }


                        //Select 2

                        $('#user').select2({
                            width: '100%',
                            theme: "bootstrap"
                        });


                        function EditProcess(edit_url, update_url) {
                            $(document).ready(function () {
                                $('#user-details').show();
//reset form
                                $('#addForm').trigger("reset");
                                $(".is-invalid").removeClass("is-invalid");
                                $(".form-error").remove();
// Go to Edit Mode If Click Edit Button
                                if (typeof (Storage) !== "undefined") {
                                    sessionStorage.setItem("editMode", true);
                                    sessionStorage.setItem("update_url", update_url);
                                }
                                $.get(edit_url, function (data) {
                                    //Change Form Action
                                    $('#addForm').attr('action', update_url);
                                    $('.modal-title').text('Edit Previous Due');
                                    //assign data
                                    $('#due_at').val(data.due_at.substring(0, 10)).trigger('change');
                                    $('#amount').val(data.amount);
                                    $('#user').val(data.user_id).trigger('change');
                                    $('#reference').val(data.reference);
                                    if (putremove != undefined) {
                                        $("#addForm").prepend(putremove);
                                        putremove = undefined;
                                    }
                                    $('#addDataModal').modal('show');
                                })
                            });
                        }
                    </script>



                    <script src="{{asset('assets/js/flatpicker.min.js')}}"></script>
                    <script src="{{asset('assets/js/datatables.min.js')}}"></script>
                    <script src="{{asset('assets/js/dataTables.bootstrap4.min.js')}}"></script>
                    <script>

                        $("#due_at").flatpickr({dateFormat: 'Y-m-d'});


                        $('#jq_datatables').DataTable();

                    </script>
            @endpush
