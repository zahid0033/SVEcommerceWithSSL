<table class="table table-striped table-hover table-bordered account_table" cellspacing="0">
    <thead>
    <tr>
        <th scope="col">#</th>
        <th scope="col">Name</th>
        <th scope="col">Phone</th>
        <th scope="col">Total Amount</th>
        <th scope="col">Collected Amount</th>
        <th scope="col">Installment Amount</th>
        <th scope="col">Due Amount</th>
        <th scope="col">Installment Dates</th>
        <th scope="col">Action</th>
    </tr>
    </thead>
    <tbody>
    @foreach($per_date_orders as $key => $per_date_order)
        <tr>
            <td>{{ $key+1 }}</td>
            <td>{{ $per_date_order->installmentCustomers->name }}</td>
            <td>{{ $per_date_order->installmentCustomers->phone }}</td>
            <td>
                @if($per_date_order->reduced_price != null)
                    <p><strike>{{  $per_date_order->product_price }}</strike> {{ $per_date_order->reduced_price }} </p>
                @else
                    {{ $per_date_order->product_price }}
                @endif
            </td>
            <td>
                @php
                    $counter = 0;
                    $downPaymentCounter = 0;
                    $payment_dates = json_decode($per_date_order->payment_dates);
                    $downPaymentDates = \Illuminate\Support\Carbon::parse($per_date_order->created_at)->toFormattedDateString();
                @endphp
                @foreach($payment_dates as $payment_date)
                    @if(in_array($payment_date, $selected_dates))
                        @php $counter= $counter+1; @endphp
                    @endif
                @endforeach
                @if(in_array($downPaymentDates, $selected_dates))
                    @php $downPaymentCounter = $downPaymentCounter+1; @endphp
                @endif

                {{ $per_date_order->installment_amount * $counter + $per_date_order->downPayment * $downPaymentCounter }}
            </td>
            <td>{{ $per_date_order->installment_amount }}</td>
            <td>{{ $per_date_order->due_amount }}</td>
            <td>
                @php
                    $installment_dates = json_decode($per_date_order->installment_dates);
                    $installment_status = json_decode($per_date_order->installment_status);
                    $status = json_decode($per_date_order->installment_status);
                    $downPaymentDate = \Illuminate\Support\Carbon::parse($per_date_order->created_at)->toFormattedDateString();
                @endphp
{{--                @foreach($installment_dates as $key => $installment_date)--}}

{{--                    @php $chosen_date = new Carbon\Carbon($installment_date); @endphp--}}

{{--                    @if( Carbon\Carbon::today()->gt($chosen_date) && $installment_status[$key] === 'pending' )--}}
{{--                        <span class="label {{$status[$key]}} " style="color: red;">{{$installment_date}} <span style="color: red;font-weight: 900;">&#9888;</span></span>--}}
{{--                    @else--}}
{{--                        <span class="label {{$status[$key]}} ">{{$installment_date}}</span>--}}
{{--                    @endif--}}
{{--                    --}}{{--                            <span style="color: red;font-size: 20px;font-weight: 900;">&#9888;</span>--}}
{{--                @endforeach--}}
                @foreach($payment_dates as $key => $payment_date)
                    @if(in_array($payment_date, $selected_dates))
                        <span class="label {{$status[$key]}} ">{{$installment_dates[$key]}}</span>
                    @endif
                @endforeach
                @if(in_array($downPaymentDate, $selected_dates))
                    <span class="label label-primary ">{{$downPaymentDate}}</span>
                @endif
            </td>
            <td><a class="label label-info" href="{{ route('installment.updateOrder',Crypt::encrypt($per_date_order->id)) }}" title="View Details"><i class="fa fa-arrow-right" aria-hidden="true"></i></a></td>
        </tr>
    @endforeach
    </tbody>
    <tfoot>
    <tr>
        <th colspan="4" style="text-align:right">Total Collect:</th>
        <th colspan="5" id="total_amount_footer"></th>
    </tr>
    </tfoot>
</table>
