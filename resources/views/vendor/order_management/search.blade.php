@if($search_count > 0)
    @foreach($search_result as $s)
        <tr >
            <td class="text-center"><b>{{$s->invoice_id}}</b></td>
            <td class="text-center"><b>{{$s->payments->trx_id}}</b></td>
            <td class="text-center"><b>{{$s->payments->sender_mobile_number}}</b></td>
            <td class="text-center"><b>৳ {{number_format($s->total)}}</b></td>
            <td class="text-center"><b>{{$s->customers->name}}</b></td>
            <td class="text-center"><b>{{$s->customers->phone}}</b></td>
            <td class="text-center"><b>{{$s->shippings->address}} , {{$s->shippings->city}}</b></td>
            <td class="text-center">@if($s->status === 'Pending')<span class="label label-warning label-mini">{{$s->status}}</span>@elseif($s->status === 'Cancel')<span class="label label-danger label-mini">{{$s->status}}</span>@elseif($s->status === 'Processing')<span class="label label-info label-mini">{{$s->status}}</span>@elseif($s->status === 'Delivered')<span class="label label-success label-mini">{{$s->status}}</span>@else<span class="label label-primary label-mini">{{$s->status}}</span> @endif</td>
            <td class="print_hide">
                @if($s->status === "Processing")
                    <a href="{{route('generateInvoice',Crypt::encrypt($s->id))}}" title="Generate Invoice" class="btn btn-default "><i class="fas fa-file-invoice-dollar"></i> </a>
                    <a href="{{route('order_details',Crypt::encrypt($s->id))}}" title="See Details" class="btn btn-primary "><i class="fas fa-arrow-circle-right"></i> </a>
                    <a class="btn btn-info " data-toggle="modal" data-target="#modal_order_shipping" onclick="setOrderShipping('{{$s->id}}','{{$s->invoice_id}}','{{$s->shippings->shipping_tracking_number}}','{{$s->shippings->courier_name}}','{{$s->shippings->shipping_date}}')" data-whatever="@mdo" title="Shipping"><i class="fas fa-truck"></i></a>
                    <a href="{{route('orderDelivered',Crypt::encrypt($s->id))}}" title="Delivered" class="btn btn-success " onclick="return confirm('Are you sure that the order is delivered ?')"><i class="fas fa-truck-loading"></i> </a>
                @elseif($s->status === "Shipping")
                    <a href="{{route('generateInvoice',Crypt::encrypt($s->id))}}" title="Generate Invoice" class="btn btn-default "><i class="fas fa-file-invoice-dollar"></i> </a>
                    <a href="{{route('order_details',Crypt::encrypt($s->id))}}" title="See Details" class="btn btn-primary "><i class="fas fa-arrow-circle-right"></i> </a>
                    <a href="{{route('orderDelivered',Crypt::encrypt($s->id))}}" title="Delivered" class="btn btn-success " onclick="return confirm('Are you sure that the order is delivered ?')"><i class="fas fa-truck-loading"></i> </a>
                    <a href="{{route('orderProcessiong',Crypt::encrypt($s->id))}}" title="Undo to processing" class="btn btn-warning " onclick="return confirm('Are you sure that the order is still in processing ?')"><i class="fas fa-undo"></i></i> </a>
                @elseif($s->status === "Delivered")
                    <a href="{{route('generateInvoice',Crypt::encrypt($s->id))}}" title="Generate Invoice" class="btn btn-default "><i class="fas fa-file-invoice-dollar"></i> </a>
                    <a href="{{route('order_details',Crypt::encrypt($s->id))}}" title="See Details" class="btn btn-primary "><i class="fas fa-arrow-circle-right"></i> </a>
                    <a href="{{route('orderProcessiong',Crypt::encrypt($s->id))}}" title="Undo to processing" class="btn btn-warning " onclick="return confirm('Are you sure that the order is still in processing ?')"><i class="fas fa-undo"></i></i> </a>
                @elseif($s->status === "Pending")
                    <a href="{{route('temp_order_details',Crypt::encrypt($s->id))}}" title="See Details" class="btn btn-primary "><i class="fas fa-arrow-circle-right"></i> </a>
                    <a href="{{route('orderProceed',Crypt::encrypt($s->id))}}" title="Proceed" class="btn btn-success " onclick="return confirm('Received the money ?')"><i class="fas fa-check"></i> </a>
                    <a class="btn btn-warning " data-toggle="modal" data-target="#modal_order_payment_update" onclick="setOrderPayment('{{$s->id}}','{{$s->trx_id}}','{{$s->sender_mobile_number}}','{{$s->invoice_id}}')" data-whatever="@mdo" title="Edit Payment"><i class="fas fa-pen-nib"></i></a>
                    <a class="btn btn-danger " data-toggle="modal" data-target="#modal_order_cancel_reason" onclick="setCancelOrderId('{{$s->id}}','{{$s->invoice_id}}')" data-whatever="@mdo" title="Cancel"><i class="fas fa-times"></i></a>
                @elseif($s->status === "Cancel")
                    <a href="{{route('temp_order_details',Crypt::encrypt($s->id))}}" title="See Details" class="btn btn-primary "><i class="fas fa-arrow-circle-right"></i> </a>
                    <a href="{{route('orderProceed',Crypt::encrypt($s->id))}}" title="Proceed" class="btn btn-success " onclick="return confirm('Received the money ?')"><i class="fas fa-check"></i> </a>
                    <a class="btn btn-warning " data-toggle="modal" data-target="#modal_order_payment_update" onclick="setOrderPayment('{{$s->id}}','{{$s->trx_id}}','{{$s->sender_mobile_number}}','{{$s->invoice_id}}')" data-whatever="@mdo" title="Edit Payment"><i class="fas fa-pen-nib"></i></a>
                    <a href="{{route('dueOrderRemove',Crypt::encrypt($s->id))}}" title="Remove" onclick="return confirm('Are you sure ?')" class="btn btn-danger "><i class="fas fa-trash"></i> </a>
                @endif
            </td>
        </tr>
    @endforeach
@else
        <tr >
            <td class="text-center" colspan="9"><h1 style="color: red">No data Found</h1></td>
        </tr>
@endif


