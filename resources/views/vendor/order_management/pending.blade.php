@extends('vendor.master')
@section('title','Pending Orders')
@section('Order_management','active')
@section('Pending_Order','active')
@section('content')
    <div class="container-fluid">
            <div class="row">
                {{--<div class="col-md-12  mar-top" style="overflow: auto">
                    <div class="col-sm-7">
                        <label  class=" label label-primary">Search</label>
                        <input name="search" type="text" id="search" onKeyUp="getSearch()" placeholder="Write here to search anything" class="form-control form-control-sm " >
                    </div>
                    <div class="col-sm-3 mar-top">
                        <b><span id="search_total_record" style="color: #0BBA8B"></span></b>
                    </div>
                    <div class="col-sm-2 mar-top">
                        <button  class="btn btn-success  center-block" onclick="printDiv('printMe')" title="print"><i class="fas fa-print"></i>  </button>
                    </div>

                </div>--}}
                <div class="col-md-12 text-center content-panel mar-top" style="overflow: auto"  id='printMe'>
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
                            <th scope="col"class="text-center"><i class="fas fa-clock"></i></i> Order Placed </th>

                            <th scope="col"class="text-center"> </th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($orders as $i=>$s)
                            <tr >
                                <td class="text-center"><b>{{$i+1}}</b></td>
                                <td class="text-center"><b>{{$s->invoice_id}}</b></td>
                                <td class="text-center"><b>{{--{{$s->payments->card_type}}--}}--</b></td>
                                <td class="text-center"><b>{{$s->shippings->phone}}</b></td>
                                <td class="text-center"><b>{{$s->shippings->address}} , {{$s->shippings->city}}</b></td>

                                <td class="text-center"><b>{{--৳ {{number_format($s->payments->amount)}}--}}--</b></td>
                                <td class="text-center"><b>{{$s->customers->name}}</b></td>
                                <td class="text-center"><b>{{$s->customers->phone}}</b></td>
                                <td class="text-center">@if($s->status === 'Pending')<span class="label label-warning label-mini">{{$s->status}}</span>@endif</td>
                                <td class="text-center">
                                    @php
                                        $time_ago = '';
                                        $date = new DateTime($s->created_at);
                                        $now = new DateTime();

                                        $diff = $date->diff($now)/*->format("%i minuts %h hours ago ")*/;
                                        if (($t = $diff->format("%m")) > 0)
                                            $time_ago = $t . ' months';
                                        else if (($t = $diff->format("%d")) > 0)
                                            $time_ago = $t . ' days';
                                        else if (($t = $diff->format("%H")) > 0)
                                            $time_ago = $t . ' hours';
                                        else if (($t = $diff->format("%i")) > 0)
                                            $time_ago = $t . ' minutes';
                                        else if (($t = $diff->format("%s")) > 0)
                                            $time_ago = $t . ' seconds';
                                    @endphp
                                    <span class="label label-default label-mini">{{$time_ago .' ago'}}</span>
                                </td>
                                <td class="print_hide">
                                    <a href="{{route('order_details',Crypt::encrypt($s->id))}}" title="See Details" class="btn btn-primary "><i class="fas fa-arrow-circle-right"></i> </a>
                                    <a href="{{route('OrderRemove',Crypt::encrypt($s->id))}}" title="Remove" onclick="return confirm('Are you sure ?')" class="btn btn-danger "><i class="fas fa-trash"></i> </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="col-md-12 text-center " style="overflow: auto"  >
                {!! $orders->links()  !!}
                </div>
            </div>
    </div>
@endsection

