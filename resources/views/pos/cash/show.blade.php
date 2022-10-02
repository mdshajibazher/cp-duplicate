@extends('layouts.adminlayout')
@section('title','Inventory Cash')

@section('content')

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-lg-6">
                            @if(Route::current()->getName() == 'invdashboard.cashdetails')
                                <a class="btn btn-info btn-sm" href="{{route('admin.inventorydashboard')}}">back to
                                    dashboard</a>
                            @else

                                <a class="btn btn-info btn-sm" href="{{route('cash.index')}}">back</a>

                            @endif
                        </div>
                        <div class="col-lg-6">

                            <h5 class="card-title text-left">Cash Information</h5>
                        </div>

                    </div>

                </div>
                <div class="card-body">
                    <div class="row justify-content-center">
                        <div class="col-lg-6">
                            <table class="table">
                                <tr>
                                    <td>Name:</td>
                                    <td>{{$cash->user->name}}</td>
                                </tr>
                                <tr>
                                    <td>Amount:</td>
                                    <td>{{$cash->amount}}</td>
                                </tr>
                                <tr>
                                    <td>Status:</td>
                                    <td id="cash-{{$cash->id}}">{!!InvCashStatus($cash->status)!!}</td>
                                </tr>
                                <tr>
                                    <td>Cash Received Date:</td>
                                    <td><strong>{{$cash->received_at->format('d F Y')}}</strong></td>
                                </tr>

                                <tr>
                                    <td>Posted By:</td>
                                    <td>{{$cash->posted_by}} <br>
                                        <small>at {{$cash->created_at->format('d M Y g : i a')}}</small></td>
                                </tr>
                                @can('Inventory Approval Cashes')
                                    @if($cash->status == 0)
                                        <tr>
                                            <td>Action</td>
                                            <td>

                                                <button
                                                    onclick="Confirmation('{{route('cash.approve',$cash->id)}}','{{$cash->user->name}}','{{$cash->amount}}')"
                                                    type="button" class="btn btn-sm btn-success"><i
                                                        class="fas fa-check"></i> Approve
                                                </button>
                                                |
                                                <form action="{{route('cash.cancel',$cash->id)}}" method="POST"
                                                      style="display: inline-block">
                                                    @csrf
                                                    <button type="submit"
                                                            onclick="return confirm('Are you sure you want to cancel this cash')"
                                                            class="btn btn-sm btn-danger"><i class="fas fa-trash"></i>
                                                        Cancel
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endif
                                @endcan
                                @if($cash->status == 1)
                                    <tr>
                                        <td>Approved By</td>
                                        <td>{{$admin->name}} <br>
                                            <small>at {{$cash->updated_at->format('d M Y g:i a')}}</small>
                                            <img style="width: 200px"
                                                 src="{{asset('uploads/admin/signature/'.$admin->signature)}}"
                                                 alt="">
                                        </td>
                                    </tr>
                                @elseif($cash->status == 2)
                                    <tr>
                                        <td>Canceled By</td>
                                        <td>{{$admin->name}} <br>
                                            <small>at {{$cash->updated_at->format('d M Y g:i a')}}</small>
                                            <img style="width: 200px"
                                                 src="{{asset('uploads/admin/signature/'.$admin->signature)}}"
                                                 alt="">
                                        </td>
                                    </tr>
                                @endif
                                @if($cash->status == 1)
                                <tr>
                                    <td>Action</td>
                                    <td>
                                        <form action="{{route('cash.money_receipt',$cash->id)}}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-arrow-circle-down"></i> Download Money Recipt</button>
                                        </form>
                                    </td>
                                </tr>
                                @endif
                            </table>
                        </div>
                    </div>

                </div>
            </div>


        </div>
    </div>

@endsection


@push('js')
    <script src="{{asset('assets/js/axios.min.js')}}"></script>
    <script>

        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-success',
                cancelButton: 'btn btn-warning  mr-3'
            },
            buttonsStyling: false
        });


        function CashApprove(cash_aprove_url) {
            axios.post(cash_aprove_url)
                .then(function (response) {

                    $("#cash-" + response.request.response).html('<span class="badge badge-success">Approved</span>');
                    location.reload();

                })
                .catch(function (error) {
                    console.log(error);
                });

        }


        function Confirmation(cash_aprove_url, customer, amount) {
            swalWithBootstrapButtons.fire({
                title: 'Are you sure? ' + customer + ' Amount: ' + amount + ' tk',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, approve it!',
                cancelButtonText: 'Later',
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    CashApprove(cash_aprove_url)
                    swalWithBootstrapButtons.fire(
                        'Approved Successfully!',
                        'Your Data Has Been Stored',
                        'success'
                    )
                } else if (
                    /* Read more about handling dismissals below */
                    result.dismiss === Swal.DismissReason.cancel
                ) {
                    swalWithBootstrapButtons.fire(
                        'Denied',
                        'No More Changes On Database :)',
                        'error'
                    )
                }
            });
        }


    </script>

@endpush




