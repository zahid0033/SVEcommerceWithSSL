@extends('vendor.master')
@section('title','Cancel Orders')
@section('Order_management','active')
@section('cancel_Order','active')
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
                            <th scope="col"class="text-center"><i class="fab fa-slack-hash"></i> Order Id</th>
                            <th scope="col" class="text-center"> <i class="fas fa-puzzle-piece"></i> Trx Id</th>
                            <th scope="col"class="text-center"><i class="fas fa-mobile-alt"></i> Bkash No</th>
                            <th scope="col"class="text-center"><i class="fas fa-money-bill-wave"></i> Amount</th>
                            <th scope="col"class="text-center"><i class="fas fa-user-cog"></i></i> Customer</th>
                            <th scope="col"class="text-center"><i class="fas fa-phone-volume"></i></i> Customer Phone</th>
                            <th scope="col"class="text-center"><i class="fas fa-map-marker-alt"></i></i> Shipping</th>
                            <th scope="col"class="text-center"><i class=" fa fa-edit"></i> Status</th>
                            <th scope="col"class="text-center" style="width: 250px "><i class="fas fa-journal-whills"></i> For</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($cancel_orders as $s)
                            <tr >
                                <td class="text-center"><b>{{$s->invoice_id}}</b></td>
                                <td class="text-center"><b>{{$s->trx_id}}</b></td>
                                <td class="text-center"><b>{{$s->sender_mobile_number}}</b></td>
                                <td class="text-center"><b>৳ {{number_format($s->total)}}</b></td>
                                <td class="text-center"><b>{{$s->customers->name}}</b></td>
                                <td class="text-center"><b>{{$s->customers->phone}}</b></td>
                                <td class="text-center"><b>{{$s->shippings->address}} , {{$s->shippings->city}}</b></td>
                                <td class="text-center">@if($s->status === 'Cancel')<span class="label label-danger label-mini">{{$s->status}}ed</span>{{--@elseif($s->status === 'Available')<span class="label label-success label-mini">{{$s->status}}</span>@else<span class="label label-default label-mini">{{$s->status}}</span> --}}@endif</td>
                                <td class="text-center"><b>{{$s->reason}}</b></td>
                                <td>
                                    <a href="{{route('temp_order_details',Crypt::encrypt($s->id))}}" title="See Details" class="btn btn-primary "><i class="fas fa-arrow-circle-right"></i> </a>
                                    <a href="{{route('orderProceed',Crypt::encrypt($s->id))}}" title="Proceed" class="btn btn-success " onclick="return confirm('Received the money ?')"><i class="fas fa-check"></i> </a>
                                    <a class="btn btn-warning " data-toggle="modal" data-target="#modal_order_payment_update" onclick="setOrderPayment('{{$s->id}}','{{$s->trx_id}}','{{$s->sender_mobile_number}}','{{$s->invoice_id}}')" data-whatever="@mdo" title="Edit Payment"><i class="fas fa-pen-nib"></i></a>
                                    <a href="{{route('dueOrderRemove',Crypt::encrypt($s->id))}}" title="Remove" onclick="return confirm('Are you sure ?')" class="btn btn-danger "><i class="fas fa-trash"></i> </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {!! $cancel_orders->links()  !!}
                </div>
            </div>
    </div>
@endsection
