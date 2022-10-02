
    <div class="card-header bg-warning">
        <strong>Invoice Pending For Delivery</strong>
    </div>
    <div class="card-body">
        @if(count($pending_delivery) > 0)
            <table class="table table-sm table-bordered" style="font-size: 14px;">
                <thead class="thead-light">
                <tr>
                    <th class="align-middle">Sl</th>
                    <th class="align-middle">Pending List</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($pending_delivery as $key => $pending_delivery_item)
                    @php
                        $sales_amount = round($pending_delivery_item->amount);
                    @endphp
                    <tr class="delivery-{{$pending_delivery_item->id}}">
                        <td class="align-middle">
                            <strong>{{$pending_delivery->firstItem() + $key}}</strong>
                        </td>
                        <td class="align-middle">
                            <table class="table">
                                <tr>
                                    <td>Date:</td>
                                    <td>{{$pending_delivery_item->sales_at->format('d-M-Y')}}</td>
                                </tr>
                                <tr>
                                    <td>Customer:</td>
                                    <td>{{$pending_delivery_item->user->name}}</td>
                                </tr>
                                <tr>
                                    <td>Status:</td>
                                    <td>{!!FashiShippingStatus($pending_delivery_item->delivery_status)!!}</td>
                                </tr>
                            </table>
                            <button
                                onclick="DeliveryModalPopup('{{route('pendingdeliveryinfo.api',$pending_delivery_item->id)}}','{{route('sale.delivery',$pending_delivery_item->id)}}')"
                                id="delivery-{{$pending_delivery_item->id}}" type="button"
                                class="btn btn-sm btn-dark btn-block">Click Here To Mark As Deliverd
                            </button>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <p>Page: </p>    {{$pending_delivery->links()}}
        @else
            <div class="row">
                <span class="alert alert-success">No Pending Delivery Found</span>
            </div>
        @endif
        <hr>
    </div>
