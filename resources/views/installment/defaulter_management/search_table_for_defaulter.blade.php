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
        <th scope="col">Note</th>
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
            <td><span class="label label-success defaulters_note_view" id="{{ $order->id }}" data-toggle="modal" ><i class="far fa-sticky-note"></i></span></td>
            <td>
                <a class="label label-info" href="{{ route('installment.updateOrder',Crypt::encrypt($order->id)) }}" title="View Details"><i class="fa fa-arrow-right" aria-hidden="true"></i></a>
                @if($order->call_status == "called")
                    <a class="label label-success" href="{{ route('installment.updateDefaulterCallStatus',['orderId'=>$order->id,'status'=> "notCalled"]) }}" title="Called"><i class="fas fa-phone-volume"></i></a>
                @elseif($order->call_status == "notCalled")
                    <a class="label label-info" href="{{ route('installment.updateDefaulterCallStatus',['orderId'=>$order->id,'status'=> "called"]) }}" title="Not called yet"><i class="fas fa-phone-slash"></i></a>
                @endif
                <span class="label label-warning call_note_edit" id="{{ $order->id }}" href="" title="Add note"><i class="far fa-clipboard"></i></span>
            </td>
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

<script type="text/javascript">
    $(".defaulters_note_view").on("click",function () {
        var order_id = $(this).attr("id");
        $.ajax({
            type:"GET",
            url: "/viewDefaulterCallNote",
            data: {order_id: order_id} ,
            datatype: "json",
            success: function (data) {
                $('#customer_name').html(data.customer_name);
                $('#note_details').html(data.note);
                $('#exampleModal').modal("show");
            }
        });
    });
    $(".call_note_edit").on("click",function () {
        var order_id = $(this).attr("id");
        $.ajax({
            type:"GET",
            url: "/viewDefaulterCallNote",
            data: {order_id: order_id} ,
            datatype: "json",
            success: function (data) {
                $('#noteUpdateModal').modal("show");
                $('#customer_name_title').html(data.customer_name);
                $('#order_id').val(order_id);
                $('#prev_note').val(data.note);

            }
        });
    });
    $("#call_note_update").on("click",function () {
        var order_id = $('#order_id').val();
        var prev_note = $('#prev_note').val();
        var _token = $('input[name="_token"]').val();
        $.ajax({
            type: "POST",
            url: "/updateDefaulterCallNote",
            data: {main_order_id: order_id, note: prev_note, _token: _token},
            datatype: "json",
            success: function (data) {
                $('#noteUpdateModal').modal("hide");
                // alert("Note Updated Successfully");
                // location.reload();
            }
        });
    });
</script>
