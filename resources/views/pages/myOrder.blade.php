@extends('master')
@section('content')
    <div class="container">

        @if(!$temp_Orders->isEmpty() )
            <h1 class="text-center" style="margin: 20px 0">Pending Orders</h1><br>
            <div class="table-responsive text-nowrap">
                <table class="table table-hover" style="">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Invoice Id</th>
                        <th scope="col">Order Status</th>
                        <th scope="col">Trx Id</th>
                        {{--                    <th scope="col">Total Products</th>--}}
                        <th scope="col">Total</th>
                        <th scope="col">Date</th>
                        <th scope="col">View Details</th>
                    </tr>
                    </thead>
                    <tbody>

                    @php $i = 1 @endphp
                    @foreach($temp_Orders as $temp_Order)
                        @php
                            $product_ids = json_decode($temp_Order->product_ids);
                        @endphp
                        <tr>
                            <td>{{ $i }}</td>
                            <td>{{ $temp_Order->invoice_id }}</td>
                            <td>
                                @if($temp_Order->status == "Cancel")
                                    {{ $temp_Order->status }}<br>( <span style="color: red"> {{ $temp_Order->reason }} </span> )
                                @else
                                    {{ $temp_Order->status }}
                                @endif
                            </td>
                            <td>{{ $temp_Order->trx_id }}</td>
                            {{--                        <td>{{ count($product_ids) }}</td>--}}
                            <td>{{ $temp_Order->total }}</td>
                            <td>{{ $temp_Order->created_at }}</td>
                            <td><a class="label label-info" href="{{ route('pendingOrderDetails',Crypt::encrypt($temp_Order->id)) }}"><i class="fa fa-arrow-right" aria-hidden="true"></i></a></td>
                        </tr>

                        @php $i ++ @endphp
                    @endforeach

                    </tbody>
                </table>
            </div>
        @endif
        @if(!$orders->isEmpty())
            <h1 class="text-center">Confirmed Orders</h1><br>
            {{--        successfull orders --}}
            <div class="table-responsive text-nowrap">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Invoice Id</th>
                        {{--                    <th scope="col">Total Products</th>--}}
                        <th scope="col">Order Status</th>
                        <th scope="col">Shipping Tracking Number</th>
                        <th scope="col">Courier Name</th>
                        <th scope="col">Total</th>
                        <th scope="col">Date</th>
                        <th scope="col">View Details</th>
                    </tr>
                    </thead>
                    <tbody>

                    @php $i = 1 @endphp
                    @foreach($orders as $order)
                        @php
                            $product_ids = json_decode($order->product_ids);
                        @endphp
                        <tr>
                            <td>{{ $i }}</td>
                            <td>{{ $order->invoice_id }}</td>
                            {{--                        <td>{{ count($product_ids) }}</td>--}}
                            <td>
                                @if( $order->status == "Processing")
                                    Confirmed
                                @else
                                    {{$order->status}}
                                @endif

                            </td>
                            <td>{{ $order->shippings->shipping_tracking_number }}</td>
                            <td>{{ $order->shippings->courier_name }}</td>
                            <td>{{ $order->total }}</td>
                            <td>{{ $order->created_at }}</td>
                            <td><a class="label label-info" href="{{ route('confirmedOrderDetails',Crypt::encrypt($order->id)) }}"><i class="fa fa-arrow-right" aria-hidden="true"></i></a></td>
                        </tr>

                        @php $i ++ @endphp
                    @endforeach

                    </tbody>
                </table>
            </div>
        @endif

    </div>
@endsection
