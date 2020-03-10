@extends('vendor.master')
@section('title','Customer Info')
@section('customer_management','active')
{{--@section('cancel_Order','active')--}}
@section('content')
    <div class="container-fluid">
       <div class="row">
           <div class="col-md-12  content-panel mar-top" style="overflow: auto">
                <div class="col-sm-2 ">
                    <table class="table  table-advance table-hover ">
                        <tbody>
                        <tr >
                            <td  >
                                <img src="{{ asset('assets/vendor/images/brands/') }}/{{ Auth::user()->brands->image }}"width="100%" alt="">
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-sm-5 ">

                </div>
                <div class="col-sm-5 ">
                    <table class="table  table-advance table-hover ">
                        <tbody>
                            <tr>
                                <td class="text-center" colspan="2">
                                    <span class="label label-success label-mini"><b>Customer's Information</b></span>
                                </td>
                            </tr>
                            <tr >
                                <td >
                                    <span class="label label-info label-mini"><i class="fas fa-signature"></i></span> <b>{{$customer->name}}</b><br><br>

                                    <span class="label label-info label-mini"><i class="fas fa-venus-mars"></i></span> <b>{{$customer->gender}}</b><br><br>
                                    <span class="label label-info label-mini"><i class="fas fa-phone-volume"></i></span> <b>{{$customer->phone}}</b><br><br>
                                    <span class="label label-info label-mini"><i class="fas fa-envelope"></i></span> <b>{{$customer->email}}</b>
                                </td>
                                <td class="text-center" width="60%" >
                                    @if(empty($customer->image))
                                        <img class="img-circle" src="{{ asset('assets/vendor/images/profile_picture/empty.jpg') }}"width="20%" alt="" title="Unavailable">
                                    @else
                                        <img class="img-circle" src="{{ asset('assets/vendor/images/profile_picture/') }}/{{$customer->image}}" width="20%" alt="" >
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <span class="label label-info label-mini"><i class="fas fa-home"></i></span> <b>{{$customer->address}}</b><b class="mark">{{$customer->city}}</b>
                                </td>

                            </tr>

                        </tbody>
                    </table>
                </div>
           </div>
       </div>
        <div class="row">
            <div class="col-md-12  content-panel " style="overflow: auto"><hr style="border-top: 8px solid #ccc; background: transparent;"><br>
                @if(!$temp_orders->isEmpty() )
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
                            @foreach($temp_orders as $temp_Order)
                                {{--@php
                                    $product_ids = json_decode($temp_Order->product_ids);
                                @endphp--}}
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
                                    <td><a class="label label-info" href="{{ route('temp_order_details',Crypt::encrypt($temp_Order->id)) }}"><i class="fa fa-arrow-right" aria-hidden="true"></i></a></td>
                                </tr>

                                @php $i ++ @endphp
                            @endforeach

                            </tbody>
                        </table>
                    </div>
                @endif

            </div>
            <div class="col-md-12  content-panel " style="overflow: auto"><hr style="border-top: 8px solid #ccc; background: transparent;"><br>
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
                                {{--@php
                                    $product_ids = json_decode($order->product_ids);
                                @endphp--}}
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
                                    <td><a class="label label-info" href="{{ route('order_details',Crypt::encrypt($order->id)) }}"><i class="fa fa-arrow-right" aria-hidden="true"></i></a></td>
                                </tr>

                                @php $i ++ @endphp
                            @endforeach

                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>

    </div>
@endsection
