@extends('vendor.master')
@section('title','Shipping Orders')
@section('Order_management','active')
@section('ShippingOrder','active')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <form method="post" enctype="multipart/form-data" action="{{ route('orderReport') }}">
                @csrf
                <div class="col-md-4 mar-top">
                    <label for="recipient-name" class=" label label-success"> Select Report Range</label>
                    <div id="reportrange" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
                        <i class="fa fa-calendar"></i>&nbsp;
                        <span></span> <i class="fa fa-caret-down"></i>
                    </div>
                    <input type="text" id="daterange" name="daterange"  class="form-control form-control-sm" style="display: none"/>
                    <input type="text"  name="type"   value ="Shipping" class="form-control form-control-sm" style="display: none"/>
                </div>
                <div class="col-md-8 mar-top text-left">
                    <input type="text"  name="type"   value ="Shipping" class="form-control form-control-sm" style="display: none"/>

                    <button type="submit" class="btn btn-success" style="margin-top: 22px;">Submit</button>
                </div>
            </form>
        </div>
            <div class="row">
                {{--<div class="btn-group col-md-12 mar-top">
                    @foreach($sub_categories as $s)
                        <button type="button" class="btn btn-round btn-info">{{$s->name}}</button>
                    @endforeach
                    <div class="btn-group">
                        <button type="button" class="btn btn-round btn-default dropdown-toggle" data-toggle="dropdown">
                            Dropdown
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a href="#">Dropdown link</a></li>
                            <li><a href="#">Dropdown link</a></li>
                        </ul>
                    </div>
                </div>--}}
                <div class="col-md-12 text-center content-panel mar-top" style="overflow: auto">
                    <table class="table  table-advance table-hover ">
                        <thead class="thead-dark">
                        <tr>
                            <th scope="col"class="text-center"><i class="fas fa-sort-numeric-down"></i> </th>
                            <th scope="col"class="text-center"><i class="fab fa-slack-hash"></i> Order Id</th>
                            <th scope="col" class="text-center"> <i class="fas fa-puzzle-piece"></i>Payment Type</th>
                            <th scope="col"class="text-center"><i class="fas fa-mobile-alt"></i> Delivery Contact</th>
                            <th scope="col"class="text-center"><i class="fas fa-map-marker-alt"></i></i> Shipping</th>

                            <th scope="col"class="text-center"><i class="fas fa-money-bill-wave"></i> Amount</th>
                            <th scope="col"class="text-center"><i class="fas fa-user-cog"></i></i> Customer</th>
                            <th scope="col"class="text-center"><i class="fas fa-phone-volume"></i></i> Customer Phone</th>
                            <th scope="col"class="text-center"><i class=" fa fa-edit"></i> Status</th>
                            <th scope="col"class="text-center"> </th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($orders as $i=>$s)
                            <tr >
                                <td class="text-center"><b>{{$i+1}}</b></td>
                                <td class="text-center"><b>{{$s->invoice_id}}</b></td>
                                <td class="text-center"><b>{{$s->payments->card_type}}</b></td>
                                <td class="text-center"><b>{{$s->shippings->phone}}</b></td>
                                <td class="text-center"><b>{{$s->shippings->address}} , {{$s->shippings->city}}</b></td>

                                <td class="text-center"><b>৳ {{number_format($s->payments->amount)}}</b></td>
                                <td class="text-center"><b>{{$s->customers->name}}</b></td>
                                <td class="text-center"><b>{{$s->customers->phone}}</b></td>
                                <td class="text-center">@if($s->status === 'Processing')<span class="label label-info label-mini">{{$s->status}}</span>@elseif($s->status === 'Delivered')<span class="label label-success label-mini">{{$s->status}}</span>@else<span class="label label-primary label-mini">{{$s->status}}</span> @endif</td>
                                <td class="text-left">
                                    @if(!empty($s->print_count))
                                        <a href="{{route('generateInvoice',Crypt::encrypt($s->id))}}" title="Downloded" class="btn btn-danger "><i class="fas fa-file-invoice-dollar"></i> </a>
                                    @else
                                        <a href="{{route('generateInvoice',Crypt::encrypt($s->id))}}" title="Downlode Invoice" class="btn btn-default "><i class="fas fa-file-invoice-dollar"></i> </a>
                                    @endif
                                    <a href="{{route('order_details',Crypt::encrypt($s->id))}}" title="See Details" class="btn btn-primary "><i class="fas fa-arrow-circle-right"></i> </a>
                                    @if($s->status === "Processing")
                                        <a class="btn btn-info " data-toggle="modal" data-target="#modal_order_shipping" onclick="setOrderShipping('{{$s->id}}','{{$s->invoice_id}}','{{$s->shippings->shipping_tracking_number}}','{{$s->shippings->courier_name}}','{{$s->shippings->shipping_date}}')" data-whatever="@mdo" title="Shipping"><i class="fas fa-truck"></i></a>
                                        <a href="{{route('orderDelivered',Crypt::encrypt($s->id))}}" title="Delivered" class="btn btn-success " onclick="return confirm('Are you sure that the order is delivered ?')"><i class="fas fa-truck-loading"></i> </a>
                                    @elseif($s->status === "Shipping")
                                        <a href="{{route('orderDelivered',Crypt::encrypt($s->id))}}" title="Delivered" class="btn btn-success " onclick="return confirm('Are you sure that the order is delivered ?')"><i class="fas fa-truck-loading"></i> </a>
                                        <a href="{{route('orderProcessiong',Crypt::encrypt($s->id))}}" title="Undo to processing" class="btn btn-warning " onclick="return confirm('Are you sure that the order is still in processing ?')"><i class="fas fa-undo"></i></i> </a>
                                    @elseif($s->status === "Delivered")
                                        <a href="{{route('orderProcessiong',Crypt::encrypt($s->id))}}" title="Undo to processing" class="btn btn-warning " onclick="return confirm('Are you sure that the order is still in processing ?')"><i class="fas fa-undo"></i></i> </a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {!! $orders->links()  !!}
                </div>
            </div>
    </div>
@endsection
