@extends('vendor.master')
@section('title','Due Orders')
@section('Order_management','active')
@section('Due_Order','active')
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
                            <th scope="col"class="text-center"><i class="fas fa-user-cog"></i></i> Customer</th>
                            <th scope="col"class="text-center"><i class="fas fa-phone-volume"></i></i> Phone</th>
                            <th scope="col"class="text-center"><i class="fas fa-envelope"></i></i> Email</th>
                            <th scope="col"class="text-center"><i class="fas fa-money-bill-wave"></i> Amount</th>
                            <th scope="col"class="text-center"><i class=" fa fa-edit"></i> Status</th>
                            <th scope="col"class="text-center"><i class="fas fa-clock"></i></i> Order Placed </th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($due_orders as $s)
                            <tr >

                                <td class="text-center"><b>{{$s->customers->name}}</b></td>
                                <td class="text-center"><b>{{$s->customers->phone}}</b></td>
                                <td class="text-center"><b>{{$s->customers->email}}</b></td>
                                <td class="text-center"><b>৳ {{number_format($s->total)}}</b></td>

                                <td class="text-center">@if($s->status === 'Due')<span class="label label-danger label-mini">{{$s->status}}</span>{{--@elseif($s->status === 'Available')<span class="label label-success label-mini">{{$s->status}}</span>@else<span class="label label-default label-mini">{{$s->status}}</span> --}}@endif</td>
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
                                <td>
                                    <a href="{{route('temp_order_details',Crypt::encrypt($s->id))}}" title="See Details" class="btn btn-primary "><i class="fas fa-arrow-circle-right"></i> </a>
                                    <a href="{{route('dueOrderRemove',Crypt::encrypt($s->id))}}" title="Remove" onclick="return confirm('Are you sure ?')" class="btn btn-danger "><i class="fas fa-trash"></i> </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {!! $due_orders->links()  !!}
                </div>
            </div>
    </div>
@endsection
