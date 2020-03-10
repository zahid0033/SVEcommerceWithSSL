@extends('master')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12  content-panel mar-top" style="overflow: auto">
                <div class="col-sm-2 ">
                    <table class="table  table-advance table-hover ">
                        <tbody>
                        <tr >
                            <td  >
{{--                                <img src="{{ asset('assets/vendor/images/brands/') }}/{{ Auth::user()->brands->image }}"width="100%" alt="">--}}
                            </td>
                        </tr>
                        <tr >
                            <td >
                                <span class="label label-info label-mini">Invoice Id</span> <b> {{$order->invoice_id}}</b>
                            </td>
                        </tr>
                        <tr >
                            <td >
                                @php
                                    $time = date('g:i a,d M,Y',strtotime($order->created_at) + 6 * 3600);
                                @endphp
                                <span class="label label-info label-mini">Time</span> <b> {{$time}}</b>
                            </td>
                        </tr>
                        <tr >

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
                                <span class="label label-info label-mini">Name</span> <b>{{$order->customers->name}}</b><br><br>

                                <span class="label label-info label-mini">Gender</span> <b>{{$order->customers->gender}}</b><br><br>
                                <span class="label label-info label-mini">Phone</span> <b>{{$order->customers->phone}}</b><br><br>
                                <span class="label label-info label-mini">Email</span> <b>{{$order->customers->email}}</b>
                            </td>
                            <td class="text-center" width="60%" >
                                @if(empty($order->customers->image))
                                    <img class="img-circle" src="{{ asset('assets/vendor/images/profile_picture/empty.jpg') }}"width="20%" alt="" title="Unavailable">
                                @else
                                    <img class="img-circle" src="{{ asset('assets/vendor/images/profile_picture/') }}/{{$order->customers->image}}" width="20%" alt="" >
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <span class="label label-info label-mini">Address</span> <b>{{$order->customers->address}}</b><b class="mark">{{$order->customers->city}}</b>
                            </td>

                        </tr>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12  content-panel " style="overflow: auto"><hr style="border-top: 8px solid #ccc; background: transparent;"><br>
                <table class="table  table-advance table-hover ">
                    <thead class="thead-dark">
                    <tr>
                        <th scope="col" class="text-center"> # </th>
                        <th scope="col" class="text-center">  </th>
                        <th scope="col" class="text-center"> <i class="fa fa-gift"></i> Product</th>
                        <th scope="col" class="text-center"> <i class="fa fa-compress"></i> Offer </th>
                        <th scope="col" class="text-center"> <i class="fa fa-money"></i> Selling price</th>
                        <th scope="col" class="text-center"> <i class="fa fa-sort-numeric-asc"></i> Quantity</th>
                        <th scope="col" class="text-center"> <i class="fa fa-hourglass"></i> Amount</th>
                    </tr>
                    </thead>
                    <tbody>
                    @php $j=1 @endphp
                    @foreach($selling_price as $i => $s)
                        <tr >
                            <td class="text-center">{{$j}}</td>
                            <td class="text-center" >
                                @php
                                    $imgarray = json_decode($products[$i]->image);
                                @endphp
                                <img src="{{ asset('assets/vendor/images/products/') }}/{{$imgarray[0]->image}}" width="70px" {{--class="imgs"--}} alt="">
                            </td>
                            <td class="text-center" ><b> <a href="" title="Click To Edit Product"> {{$products[$i]->name}}</a></b></td>
                            <td class="text-center" >

                                <b>
                                    @if($offer_type[$i] === 'Discount')
                                        Actual Price : ৳ {{number_format($products[$i]->price)}} <br>
                                        Discount : {{$offer_percentage[$i]}} %
                                    @elseif($offer_type[$i] === 'Buy one get one')
                                        @if(!empty($free_products[$i]->image))
                                            @php
                                                $imgarray2 = json_decode($free_products[$i]->image);
                                            @endphp
                                            {{-- <img src="{{ asset('assets/vendor/images/products/') }}/{{$imgarray2[0]->image}}" width="70px" --}}{{--class="imgs"--}}{{-- alt="">--}}
                                        @endif
                                        <b>  Free: <a   href="{{route('productManagementEdit',Crypt::encrypt($free_products[0]->id))}}" title="Click To Edit Product">{{$free_products[0]->name}}</a> </b>
                                    @else
                                        No offer
                                    @endif

                                </b>

                                <br>
                            </td>
                            <td class="text-center" ><b>৳ {{number_format($selling_price[$i])}}</b></td>
                            <td class="text-center" ><b> {{$quantity[$i]}}</b></td>
                            <td class="text-center" ><b>৳ {{number_format($selling_price[$i] * $quantity[$i])}}</b></td>
                        </tr>
                        @php $j++ @endphp
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12  content-panel" style="overflow: auto">
                <div class="col-sm-3  "><br>
                    @if($order->status != "Due")
                        <hr style="border: 1px solid transparent;"><br>
                        <table class="table table-hover ">
                            <tbody>
                            <tr>
                                <td >
                                    <span class="label label-success label-mini"><b>Delivery Information</b></span>
                                </td>
                            </tr>
                            <tr >
                                <td >
                                    <span class="label label-warning label-mini">Name</span> <b>{{$order->shippings->name}}</b>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <span class="label label-warning label-mini">Mobile</span> <b>{{$order->shippings->phone}}</b>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <span class="label label-warning label-mini">Email</span> <b>{{$order->shippings->email}}</b>
                                </td>
                            </tr>
                            <tr>
                                <td >
                                    <span class="label label-warning label-mini">Address</span> <b>{{$order->shippings->address}}</b><b class="mark">{{$order->customers->city}}</b>
                                </td>
                            </tr>

                            <tr>
                                <td >
                                    <span class="label label-warning label-mini">C/N</span> <b>{{$order->shippings->shipping_tracking_number}}</b>
                                </td>
                            </tr>
                            <tr>
                                <td >
                                    <span class="label label-warning label-mini">Courier Name</span> <b>{{$order->shippings->courier_name}}</b>
                                </td>
                            </tr>
                            <tr>
                                <td >
                                    <span class="label label-warning label-mini">Shipping Date</span> <b>{{$order->shippings->shipping_date}}</b>
                                </td>
                            </tr>
                            @endif

                            </tbody>
                        </table>
                </div>
                <div class="col-sm-4 ">

                </div>
                <div class="col-sm-3 ">
                    <table class="table table-hover ">
                        <tbody>
                        <tr >
                            <td >
                                <span class="label label-default label-mini"> Sub-Total  </span>
                            </td>
                            <td><b> ৳  {{number_format($order->subtotal)}}</b></td>
                        </tr>
                        <tr >
                            <td >
                                <span class="label label-default label-mini"> Delivery Charge </span>
                            </td>
                            <td><b> ৳  {{number_format($order->total - $order->subtotal)}}</b></td>
                        </tr>
                        <tr >
                            <td >
                                <span class="label label-default label-mini"> Paid-Total  </span>
                            </td>
                            <td><b> ৳  {{number_format($order->total)}}</b></td>
                        </tr>
                        @if($order->status != "Due")
                            <tr >
                                <td class="text-center" colspan="2">
                                    <span class="label label-danger label-mini"><b>Payment Details</b></span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <span class="label label-primary label-mini">Method  </span> <b> &nbsp;Bkash-{{$order->payments->method}}</b>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <span class="label label-primary label-mini">Trx Id  </span> <b> &nbsp;{{$order->payments->trx_id}}</b>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <span class="label label-primary label-mini">Bkash Number  </span> <b> &nbsp;{{$order->payments->sender_mobile_number}}</b>
                                </td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
