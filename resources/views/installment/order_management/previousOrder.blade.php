@extends('installment.master')
@section('title','Previous Orders')
@section('Order_management','active')
@section('PreviousOrder','active')
@section('content')
    <div class="container-fluid">
        <h1 class="text-center">Running Orders</h1>
        <table class="table table-striped table-hover table-bordered dtBasicExample" width="100%" cellspacing="0" >
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Phone</th>
                <th scope="col">Total</th>
                <th scope="col">Total Paid</th>
                <th scope="col">Due Payment</th>
                <th scope="col">Installment Amount</th>
                <th scope="col">Installment Dates</th>
                <th scope="col">Installment Number </th>
                <th scope="col">Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach($previous_orders as $key => $previous_order)
                <tr>
                    <td>{{ $key+1 }}</td>
                    <td>{{ $previous_order->installmentCustomers->name }}</td>
                    <td>{{ $previous_order->installmentCustomers->phone }}</td>
                    <td>
                        @if($previous_order->reduced_price != null)
                            <p><strike>{{  $previous_order->product_price }}</strike> {{ $previous_order->reduced_price }} </p>
                        @else
                            {{ $previous_order->product_price }}
                        @endif
                    </td>
                    <td>{{ $previous_order->paid_amount }}</td>
                    <td>{{ $previous_order->due_amount }}</td>
                    <td>{{ $previous_order->installment_amount }}</td>
                    <td>
                        @php
                            $installment_dates = json_decode($previous_order->installment_dates);
                            $installment_status = json_decode($previous_order->installment_status);
                            $status = json_decode($previous_order->installment_status);
                        @endphp
                        @foreach($installment_dates as $key => $installment_date)

                            @php $chosen_date = new Carbon\Carbon($installment_date); @endphp

                            @if( Carbon\Carbon::today()->gt($chosen_date) && $installment_status[$key] === 'pending' )
                                <span class="label {{$status[$key]}} " style="color: red;">{{$installment_date}} <span style="color: red;font-weight: 900;">&#9888;</span></span>
                            @else
                                <span class="label {{$status[$key]}} ">{{$installment_date}}</span>
                            @endif
                            {{--                            <span style="color: red;font-size: 20px;font-weight: 900;">&#9888;</span>--}}
                        @endforeach
                    </td>
                    <td>{{ $previous_order->installment_number }}</td>
                    <td><a class="label label-info" href="{{ route('installment.updateOrder',Crypt::encrypt($previous_order->id)) }}" title="View Details"><i class="fa fa-arrow-right" aria-hidden="true"></i></a></td>
                </tr>
            @endforeach

            </tbody>
            <tfoot>
            <tr>
                <th colspan="4" style="text-align:right">Total Paid:</th>
                <th colspan="6" id="total_amount_footer"></th>
            </tr>
            </tfoot>
        </table>

    </div>
@endsection
