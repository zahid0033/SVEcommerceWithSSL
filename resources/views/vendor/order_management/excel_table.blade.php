<table class="table" >
        <thead >
        <tr>
            <th ><b > Order Id</b></th>
            <th ><b >Payment Type</b></th>
            <th ><b >Total Amount</b></th>
            <th ><b >Nobin Amount</b></th>
            <th ><b >Bank Transaction Id</b></th>
            <th > <b >Delivery To</b></th>
            <th ><b > Delivery Phone</b></th>
            <th ><b > Delivery Address</b></th>
            <th ><b > Delivery Email</b></th>
            <th > <b >Shipping Tracking Number</b></th>
            <th > <b >Courier Name</b></th>
            <th ><b > Shipping Date</b></th>
            <th ><b > Customer Name</b></th>
            <th ><b > Customer Phone</b></th>
            <th > <b >Customer Email</b></th>
            <th ><b >Status</b></th>
        </tr>
        </thead>
        <tbody >
    @foreach($search_result as $s)
        <tr >
            <td ><b >{{$s->invoice_id}}</b></td>
            <td >{{$s->payments->card_type}}</td>
            <td >৳ {{number_format($s->payments->amount)}}</td>
            <td >৳ {{number_format($s->payments->store_amount)}}</td>
            <td >{{$s->payments->bank_tran_id}}</td>
            <td >{{$s->shippings->name}}</td>
            <td >{{$s->shippings->phone}}</td>
            <td >{{$s->shippings->address}} , {{$s->shippings->city}}</td>
            <td >{{$s->shippings->email}}</td>
            <td >{{$s->shippings->shipping_tracking_number}}</td>
            <td >{{$s->shippings->courier_name}}</td>
            <td >{{$s->shippings->shipping_date}}</td>
            <td >{{$s->customers->name}}</td>
            <td >{{$s->customers->phone}}</td>
            <td >{{$s->customers->email}}</td>
            <td >{{ $s->status }}</td>
        </tr>
    @endforeach
        </tbody>
    </table>


