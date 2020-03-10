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
                            <th scope="col"class="text-center"><i class="fab fa-slack-hash"></i> Order Id</th>
                            <th scope="col" class="text-center"> <i class="fas fa-puzzle-piece"></i> Trx Id</th>
                            <th scope="col"class="text-center"><i class="fas fa-mobile-alt"></i> Bkash No</th>
                            <th scope="col"class="text-center"><i class="fas fa-money-bill-wave"></i> Amount</th>
                            <th scope="col"class="text-center"><i class="fas fa-user-cog"></i></i> Customer</th>
                            <th scope="col"class="text-center"><i class="fas fa-phone-volume"></i></i> Customer Phone</th>
                            <th scope="col"class="text-center"><i class="fas fa-map-marker-alt"></i></i> Shipping</th>
                            <th scope="col"class="text-center"><i class=" fa fa-edit"></i> Status</th>
                            <th scope="col"class="text-center"> </th>
                        </tr>
                        </thead>
                        <tbody id="search_table">
                        @foreach($pending_orders as $s)
                            <tr >
                                <td class="text-center"><b>{{$s->invoice_id}}</b></td>
                                <td class="text-center"><b>{{$s->trx_id}}</b></td>
                                <td class="text-center"><b>{{$s->sender_mobile_number}}</b></td>
                                <td class="text-center"><b>৳ {{number_format($s->total)}}</b></td>
                                <td class="text-center"><b>{{$s->customers->name}}</b></td>
                                <td class="text-center"><b>{{$s->customers->phone}}</b></td>
                                <td class="text-center"><b>{{$s->shippings->address}} , {{$s->shippings->city}}</b></td>
                                <td class="text-center">@if($s->status === 'Pending')<span class="label label-warning label-mini">{{$s->status}}</span>{{--@elseif($s->status === 'Available')<span class="label label-success label-mini">{{$s->status}}</span>@else<span class="label label-default label-mini">{{$s->status}}</span> --}}@endif</td>
                                <td class="print_hide">
                                    <a href="{{route('temp_order_details',Crypt::encrypt($s->id))}}" title="See Details" class="btn btn-primary "><i class="fas fa-arrow-circle-right"></i> </a>
                                    <a href="{{route('orderProceed',Crypt::encrypt($s->id))}}" title="Proceed" class="btn btn-success " onclick="return confirm('Received the money ?')"><i class="fas fa-check"></i> </a>
                                    <a class="btn btn-warning " data-toggle="modal" data-target="#modal_order_payment_update" onclick="setOrderPayment('{{$s->id}}','{{$s->trx_id}}','{{$s->sender_mobile_number}}','{{$s->invoice_id}}','temp')" data-whatever="@mdo" title="Edit Payment"><i class="fas fa-pen-nib"></i></a>
                                    <a class="btn btn-danger " data-toggle="modal" data-target="#modal_order_cancel_reason" onclick="setCancelOrderId('{{$s->id}}','{{$s->invoice_id}}')" data-whatever="@mdo" title="Cancel"><i class="fas fa-times"></i></a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                </div>
                <div class="col-md-12 text-center " style="overflow: auto"  >
                {!! $pending_orders->links()  !!}
                </div>
            </div>
    </div>
@endsection

