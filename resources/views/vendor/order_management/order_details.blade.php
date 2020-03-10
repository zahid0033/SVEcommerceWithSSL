@extends('vendor.master')
@section('title','Order : '.$order->invoice_id)
@section('Order_management','active')
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
                        <tr >
                            <td >
                                <span class="label label-info label-mini"><i class="fab fa-slack-hash"></i></span> <b> {{$order->invoice_id}}</b>
                            </td>
                        </tr>
                        <tr >
                            <td >
                                @php
                                    $time = date('g:i a,d M,Y',strtotime($order->created_at) + 6 * 3600);
                                @endphp
                                <span class="label label-info label-mini"><i class="fas fa-clock"></i></span> <b> {{$time}}</b>
                            </td>
                        </tr>
                        <tr >
                            <td ><span>
                                @if($order->status === "Processing")
                                    <span class="label label-info ">{{$order->status}}</span>
                                        <a class="btn btn-info  " data-toggle="modal" data-target="#modal_order_shipping" onclick="setOrderShipping('{{$order->id}}','{{$order->invoice_id}}','{{$order->shippings->shipping_tracking_number}}','{{$order->shippings->courier_name}}','{{$order->shippings->shipping_date}}')" data-whatever="@mdo" title="Shipping"><i class="fas fa-truck"></i></a>
                                        <a href="{{route('orderDelivered',Crypt::encrypt($order->id))}}" title="Delivered" class="btn btn-success " onclick="return confirm('Are you sure that the order is delivered ?')"><i class="fas fa-truck-loading"></i> </a>
                                @elseif($order->status === "Delivered")
                                    <span class="label label-success ">{{$order->status}}</span>
                                        <a href="{{route('orderProcessiong',Crypt::encrypt($order->id))}}" title="Undo to processing" class="btn btn-warning " onclick="return confirm('Are you sure that the order is still in processing ?')"><i class="fas fa-undo"></i></i> </a>
                                @elseif($order->status === "Pending")
                                    <span class="label label-warning ">{{$order->status}}</span>
                                        <a href="{{route('orderProceed',Crypt::encrypt($order->id))}}" title="Proceed" class="btn btn-success " onclick="return confirm('Received the money ?')"><i class="fas fa-check"></i> </a>
                                        <a class="btn btn-danger " data-toggle="modal" data-target="#modal_order_cancel_reason" onclick="setCancelOrderId('{{$order->id}}','{{$order->invoice_id}}')" data-whatever="@mdo" title="Cancel"><i class="fas fa-times"></i></a>
                                @elseif($order->status === "Cancel")
                                    <span class="label label-danger ">{{$order->status}}ed</span>
                                        <a href="{{route('orderProceed',Crypt::encrypt($order->id))}}" title="Proceed" class="btn btn-success  " onclick="return confirm('Received the money ?')"><i class="fas fa-check"></i> </a>
                                        <a href="{{route('dueOrderRemove',Crypt::encrypt($order->id))}}" title="Remove" onclick="return confirm('Are you sure ?')" class="btn btn-danger "><i class="fas fa-trash"></i> </a>
                                      <br>  <b style="font-size: xx-small ">{{$order->reason}}</b>
                                    @elseif($order->status === "Due")
                                        <span class="label label-default ">{{$order->status}}</span>
                                        <a href="{{route('dueOrderRemove',Crypt::encrypt($order->id))}}" title="Remove" onclick="return confirm('Are you sure ?')" class="btn btn-danger "><i class="fas fa-trash"></i> </a>
                                    @elseif($order->status === "Shipping")
                                        <span class="label label-default ">{{$order->status}}</span>
                                        <a href="{{route('orderDelivered',Crypt::encrypt($order->id))}}" title="Delivered" class="btn btn-success " onclick="return confirm('Are you sure that the order is delivered ?')"><i class="fas fa-truck-loading"></i> </a>
                                        <a href="{{route('orderProcessiong',Crypt::encrypt($order->id))}}" title="Undo to processing" class="btn btn-warning " onclick="return confirm('Are you sure that the order is still in processing ?')"><i class="fas fa-undo"></i></i> </a>
                                    @endif
                                </span>
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
                                    <span class="label label-info label-mini"><i class="fas fa-signature"></i></span> <b>{{$order->customers->name}}</b><br><br>

                                    <span class="label label-info label-mini"><i class="fas fa-venus-mars"></i></span> <b>{{$order->customers->gender}}</b><br><br>
                                    <span class="label label-info label-mini"><i class="fas fa-phone-volume"></i></span> <b>{{$order->customers->phone}}</b><br><br>
                                    <span class="label label-info label-mini"><i class="fas fa-envelope"></i></span> <b>{{$order->customers->email}}</b>
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
                                    <span class="label label-info label-mini"><i class="fas fa-home"></i></span> <b>{{$order->customers->address}}</b><b class="mark">{{$order->customers->city}}</b>
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
                        <th scope="col"class="text-center"><i class="fab fa-slack-hash"></i></th>
                        <th scope="col" class="text-center"> <i class="fas fa-puzzle-piece"></i> Product</th>
                        <th scope="col" class="text-center"> <i class="fas fa-gift"></i> </th>
                        <th scope="col"class="text-center"><i class="fas fa-money-bill-wave"></i> Selling price</th>
                        <th scope="col"class="text-center"><i class="fas fa-sort-numeric-up"></i> Quantity</th>
                        <th scope="col"class="text-center"><i class="fas fa-money-bill-wave"></i> Amount</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($selling_price as $i => $s)
                            <tr >
                                <td class="text-center" >
                                    @php
                                        $imgarray = json_decode($products[$i]->image);
                                    @endphp
                                    <img src="{{ asset('assets/vendor/images/products/') }}/{{$imgarray[0]->image}}" width="70px" {{--class="imgs"--}} alt="">
                                </td>
                                <td class="text-center" ><b> <a   href="{{route('productManagementEdit',Crypt::encrypt($products[$i]->id))}}" title="Click To Edit Product"> {{$products[$i]->name}}</a></b></td>
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
                                                empty
                                            @endif

                                        </b>

                                    <br>
                                </td>
                                <td class="text-center" ><b>৳ {{number_format($selling_price[$i])}}</b></td>
                                <td class="text-center" ><b> {{$quantity[$i]}}</b></td>
                                <td class="text-center" ><b>৳ {{number_format($selling_price[$i] * $quantity[$i])}}</b></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12  content-panel" style="overflow: auto">
                <div class="col-sm-3  "><br>
                    @if($order->status != "Due")
                    <hr style="border-top: 8px solid #89C0E0; background: transparent;"><br>
                    <table class="table table-hover ">
                        <tbody>
                        <tr>
                            <td >
                                <span class="label label-success label-mini"><b>Delivery Information</b></span>
                                @if($order->status === "Shipping" OR $order->status === "Processing")
                                    <a class="btn btn-info btn-xs" data-toggle="modal" data-target="#modal_order_shipping" onclick="setOrderShipping('{{$order->id}}','{{$order->invoice_id}}','{{$order->shippings->shipping_tracking_number}}','{{$order->shippings->courier_name}}','{{$order->shippings->shipping_date}}')" data-whatever="@mdo" title="Shipping"><i class="fas fa-truck"></i></a>
                                @endif
                            </td>
                        </tr>
                        <tr >
                            <td >
                                <span class="label label-warning label-mini"><i class="fas fa-signature"></i></span> <b>{{$order->shippings->name}}</b>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <span class="label label-warning label-mini"><i class="fas fa-phone-volume"></i></span> <b>{{$order->shippings->phone}}</b>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <span class="label label-warning label-mini"><i class="fas fa-envelope"></i></span> <b>{{$order->shippings->email}}</b>
                            </td>
                        </tr>
                        <tr>
                            <td >
                                <span class="label label-warning label-mini"><i class="fas fa-dolly-flatbed"></i></span> <b>{{$order->shippings->address}}</b><b class="mark">{{$order->customers->city}}</b>
                            </td>
                        </tr>

                        <tr>
                            <td >
                                <span class="label label-warning label-mini">C/N</span> <b>{{$order->shippings->shipping_tracking_number}}</b>
                            </td>
                        </tr>
                        <tr>
                            <td >
                                <span class="label label-warning label-mini"><i class="fas fa-dolly-flatbed"></i></span> <b>{{$order->shippings->courier_name}}</b>
                            </td>
                        </tr>
                        <tr>
                            <td >
                                <span class="label label-warning label-mini"><i class="fas fa-dolly-flatbed"></i></span> <b>{{$order->shippings->shipping_date}}</b>
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
                                @if($order->status === "Pending" OR $order->status === "Cancel"  )
                                    <a class="btn btn-warning btn-xs " data-toggle="modal" data-target="#modal_order_payment_update" onclick="setOrderPayment('{{$order->id}}','{{$order->trx_id}}','{{$order->sender_mobile_number}}','{{$order->invoice_id}}','temp')" data-whatever="@mdo" title="Edit Payment"><i class="fas fa-pen-nib"></i></a>
                                @elseif($order->status === "Processing")
                                    <a class="btn btn-warning btn-xs " data-toggle="modal" data-target="#modal_order_payment_update" onclick="setOrderPayment('{{$order->id}}','{{$order->payments->trx_id}}','{{$order->payments->sender_mobile_number}}','{{$order->invoice_id}}','main')" data-whatever="@mdo" title="Edit Payment"><i class="fas fa-pen-nib"></i></a>

                                @endif
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
