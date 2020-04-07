@extends('installment.master')
@section('title','Update Order')
@section('content')
    <div class="container-fluid">
        <h1 class="text-center">Order Details</h1>
        <div class="row">
            <div class="col-md-12">
                <h3 class="text-center">Product Info</h3>
            </div>
            <div class="col-md-6">
                <h4><b>Product Name: </b>{{ $order->products->name }}</h4>
            </div>
            <div class="col-md-6">
                @if($order->reduced_price != null)
                    <h4><b>Product Price: </b><strike>{{  $order->product_price }}</strike> {{ $order->reduced_price }} </h4>
                @else
                    <h4><b>Product Price: </b>{{ $order->product_price }} </h4>
                @endif
            </div>
            <div class="col-md-12">
                <h3 class="text-center">Customer Info</h3>
            </div>
            <div class="col-md-3">
                <h4><b>Name: </b>{{ $order->installmentCustomers->name }}</h4>
            </div>
            <div class="col-md-3">
                <h4><b>Email: </b>{{ $order->installmentCustomers->email }}</h4>
            </div>
            <div class="col-md-3">
                <h4><b>Mobile: </b>{{ $order->installmentCustomers->phone }}</h4>
            </div>
            <div class="col-md-3">
                <h4><b>Address: </b>{{ $order->installmentCustomers->address }}</h4>
            </div>
            <div class="col-md-12">
                <h3 class="text-center">Payment Info</h3>
            </div>

            <div class="col-md-6">
                <h4><b>Already Paid</b></h4>
                @php
                    $installment_dates = json_decode($order->installment_dates);
                    $payment_dates = json_decode($order->payment_dates);
                    $installment_status = json_decode($order->installment_status);
                    $installment_note = json_decode($order->installment_note);
                @endphp
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th scope="col">Installment Date</th>
                        <th scope="col">Amount</th>
                        <th scope="col">Payment Date</th>
                        <th scope="col">Note </th>
                        <th scope="col">Status</th>
                        <th scope="col">Add note</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>Down Payment</td>
                        <td>{{ $order->downPayment }}</td>
                        <td>{{ $order->created_at }}</td>
                        <td></td>
                        <td><a href="" class="label label-success"> Down payment </a></td>
                        <td></td>
                    </tr>
                    @foreach($installment_dates as $key => $installment_date)
                        <tr>
                            @if($installment_status[$key] === "paid" || $installment_status[$key] === "latePaid")
                                <td>{{ $installment_date }}</td>
                                <td> {{ $order->installment_amount }}</td>
                                <td> {{ $payment_dates[$key] }}</td>
                                <td>
                                    <input type="hidden" id="order_id" value="{{ $order->id }}">
                                    <input type="button" class="btn btn-primary view_data" id="{{ $key }}" data-toggle="modal" value="view">
                                </td>
                                <td><span class="label {{$installment_status[$key]}} "> {{ $installment_status[$key]  }} </span></td>
                                <td>
                                    <input type="button" class="btn btn-primary update_note" id="{{ $key }}" data-toggle="modal" value="Add">
                                </td>
                            @endif
                        </tr>
                    @endforeach
                    <tr style="background: #98a19c">
                        <td><b>Total Paid</b></td>
                        <td><b>{{$order->paid_amount}}</b></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-md-6">
                <h4><b>Running Installment</b></h4>

                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th scope="col">Installment Date</th>
                        <th scope="col">Amount</th>
                        <th scope="col">Note</th>
                        <th scope="col">Status</th>
                        <th scope="col">Note Add</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($installment_dates as $key => $installment_date)
                        <tr>
                            @if($installment_status[$key] === "pending")
                                <td>
                                    <span>{{ $installment_date }}</span>
                                    @php $chosen_date = new Carbon\Carbon($installment_date); @endphp
                                    @if( Carbon\Carbon::today()->gt($chosen_date) && $installment_status[$key] === 'pending' )
                                        <span style="color: red;font-size: 20px;font-weight: 900;">&#9888;</span>
                                    @endif
                                </td>
                                <td> {{ $order->installment_amount }}</td>
                                <td>
                                    <input type="hidden" id="order_id" value="{{ $order->id }}">
                                    <input type="button" class="btn btn-primary view_data" id="{{ $key }}" data-toggle="modal" value="view">
                                </td>
                                <td class="text-center">
                                    <input type="text" class="form-control account_date fetchDate" id="date_field"/>
{{--                                    <a href='' onclick="this.href='updateItem?codice=${item.key.codice}&quantita='+document.getElementById('qta_field').value">update</a>--}}
{{--                                    <a href='' onclick="this.href=`/updateOrderStatus/{{$order->id}}/{{$key}}/paid`">paid</a>--}}

                                    @if( Carbon\Carbon::today()->gt($chosen_date) && $installment_status[$key] === 'pending' )
{{--                                        <span><a href="{{ route('installment.updateOrderStatus',['orderId'=> $order->id, 'statusId'=> $key, 'status'=> 'latePaid']) }}" class="label label-info"> Late Paid </a></span>--}}
                                        <span><a href='' onclick="let dates =document.getElementById('date_field').value; this.href='{{ route('installment.updateOrderStatus',['orderId'=> $order->id, 'statusId'=> $key, 'status'=> 'latePaid', ':date']) }}'; this.href = this.href.replace(':date', dates.replace(/\//g , '-')); " class="label label-info">Late Paid</a></span>
                                    @else
                                        <span><a href='' onclick="let dates =document.getElementById('date_field').value; this.href='{{ route('installment.updateOrderStatus',['orderId'=> $order->id, 'statusId'=> $key, 'status'=> 'paid', ':date'  ]) }}'; this.href = this.href.replace(':date', dates.replace(/\//g , '-')); " class="label label-warning">Paid</a></span>
                                    @endif
                                </td>
                                <td>
                                    <input type="button" class="btn btn-primary update_note" id="{{ $key }}" data-toggle="modal" value="Add">
                                </td>
                            @endif
                        </tr>
                    @endforeach
                    <tr style="background: #98a19c">
                        <td><b>Due Amount</b></td>
                        <td><b>{{$order->due_amount}}</b></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    </tbody>
                </table>
            </div>

        </div>
    </div>



    <!-- Modal start to view the note -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><b id="note_date">title</b></h5>
{{--                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">--}}
{{--                        <span aria-hidden="true">&times;</span>--}}
{{--                    </button>--}}
                </div>
                <div class="modal-body" id="note_details">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal end for view -->
    <!-- Modal start to update the note -->
    <div class="modal fade" id="noteUpdateModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><b class="note_date">title</b></h5>
                </div>
                <div class="modal-body" id="note_details">
                    <form>
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label>Note</label>
                            <input type="hidden" class="form-control" id="main_order_id" name="main_order_id" value="{{ $order->id }}"  placeholder="Enter Note">
                            <input type="hidden" class="form-control" id="note_id" name="note_id"  placeholder="Enter Note">
                            <input type="text" class="form-control" id="prev_note" name="prev_note"  placeholder="Enter Note">
                        </div>
                        <input type="button" id="edit_note" class="btn btn-primary" value="submit">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

@endsection
