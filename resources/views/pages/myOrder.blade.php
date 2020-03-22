@extends('master')
@section('content')
    <!-- message -->
    @if(session('msg'))
        <div class="alert alert-success alert-dismissable session_message">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <p align="center" ><marquee direction="up" behavior = "slide" height="20px" width="350px"><strong >{{session('msg')}}!</strong></marquee></p>
        </div>
    @endif
    <!-- /message -->
    <div class="container">

        @if(!$orders->isEmpty())
            <h1 class="text-center" style="padding-top: 2em">Orders</h1><br>
            {{--        successfull orders --}}
            <div class="table-responsive text-nowrap">
                <table class="table table-hover">
                    <thead>
                    <tr>
{{--                        <th scope="col">#</th>--}}
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
{{--                            <td>{{ $i }}</td>--}}
                            <td>{{ $order->invoice_id }}</td>
                            {{--                        <td>{{ count($product_ids) }}</td>--}}
                            <td>
                                @if( $order->status == "Processing")
                                    Confirmed
                                @elseif( $order->status == "Failed")
                                    <span style="color: red">{{$order->status}}</span>
                                @else
                                    {{$order->status}}
                                @endif

                            </td>
                            <td>
                                @if( $order->shippings->shipping_tracking_number == null)
                                    N/A
                                @else
                                    {{ $order->shippings->shipping_tracking_number }}
                                @endif
                            </td>
                            <td>
                                @if( $order->shippings->courier_name == null)
                                    N/A
                                @else
                                    {{ $order->shippings->courier_name }}
                                @endif
                            </td>
                            <td>{{ $order->payments->amount }}</td>
                            <td>{{date('g:i a , d M Y',strtotime($order->created_at) )}}</td>
{{--                            <td>{{ $order->created_at }}</td>--}}
                            <td>
                                <a class="label label-info" href="{{ route('confirmedOrderDetails',Crypt::encrypt($order->id)) }}" title="View Details"><i class="fa fa-arrow-right" aria-hidden="true"></i></a>

                                @if( $order->status != "Failed")
                                    <a class="label label-success" target="_blank"  href="{{route('generateInvoice_customer',Crypt::encrypt($order->id))}}" title="Generate Invoice"><i class="fa fa-file-text" aria-hidden="true"></i> </a>
                                @endif
                            </td>
                        </tr>

                        @php $i ++ @endphp
                    @endforeach

                    </tbody>
                </table>
            </div>
        @endif

        <div class="row">
            <div class="col-md-12 text-center">
                {{ $orders->links() }}
            </div>
        </div>

    </div>
@endsection
