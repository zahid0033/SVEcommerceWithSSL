@extends('vendor.master')
@section('title','Failed Orders')
@section('Order_management','active')
@section('Failed_Order','active')
@section('content')
    <div class="container-fluid">
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
                                <td class="text-center">@if($s->status === 'Failed')<span class="label label-danger label-mini">{{$s->status}}</span>@endif</td>
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
                                    <a href="{{route('OrderRemove',Crypt::encrypt($s->id))}}" title="Remove" onclick="return confirm('Are you sure ?')" class="btn btn-danger "><i class="fas fa-trash"></i> </a>
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
