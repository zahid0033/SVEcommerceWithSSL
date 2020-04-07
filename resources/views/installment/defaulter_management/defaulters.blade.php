@extends('installment.master')
@section('title','Defaulters')
@section('Defaulters','active')
@section('content')
    <div class="container-fluid">
        <h1 class="text-center">Missing Orders</h1>
        <table class="table table-striped table-hover table-bordered defaulter_table" cellspacing="0">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Phone</th>
                <th scope="col">Total Amount</th>
                <th scope="col">Missing Dates</th>
                <th scope="col">Missing Amount</th>
                <th scope="col">Due Amount</th>
                <th scope="col">Installment Amount</th>
                <th scope="col">Action</th>
            </tr>
            </thead>
            <tbody>
        @foreach($late_orders as $key => $order)
            @php
                $installment_dates = json_decode($order->installment_dates);
                $payment_dates = json_decode($order->payment_dates);
                $installment_status = json_decode($order->installment_status);
                $installment_note = json_decode($order->installment_note);
            @endphp
            <tr>
                <td>{{ $key+1 }}</td>
                <td>{{ $order->installmentCustomers->name }}</td>
                <td>{{ $order->installmentCustomers->phone }}</td>
                <td>
                    @if($order->reduced_price != null)
                        <p><strike>{{  $order->product_price }}</strike> {{ $order->reduced_price }} </p>
                    @else
                        {{ $order->product_price }}
                    @endif
                </td>

                <td>
                    @php $count=0 @endphp
                    @foreach($installment_dates as $key => $installment_date)
                        @php $chosen_date = new Carbon\Carbon($installment_date); @endphp
                        @if( Carbon\Carbon::today()->gt($chosen_date) && $installment_status[$key] === 'pending' )
                            @php $count= $count+1 @endphp
                            <span class="label label-danger">{{ $installment_date }}</span>
                        @endif
                    @endforeach
                </td>
                <td>{{ $order->installment_amount * $count }}</td>
                <td>{{ $order->due_amount }}</td>
                <td>{{ $order->installment_amount }}</td>
                <td><a class="label label-info" href="{{ route('installment.updateOrder',Crypt::encrypt($order->id)) }}" title="View Details"><i class="fa fa-arrow-right" aria-hidden="true"></i></a></td>
            </tr>
        @endforeach
            </tbody>
            <tfoot>
            <tr>
                <th colspan="5" style="text-align:right">Total Due Until Today:</th>
                <th colspan="4" id="total_amount_footer"></th>
            </tr>
            </tfoot>
        </table>
    </div>
@endsection
