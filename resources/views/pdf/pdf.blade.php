<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Order : {{$order->invoice_id}}</title>

    <style type="text/css">
        * {
            font-family: Verdana, Arial, sans-serif;
            font-size: 10px;
        }
        .bfont {
            font-size: 15px;
        }
        table{
            font-size: x-small;
        }
        tfoot tr td{
            font-weight: bold;
            font-size: x-small;
        }
        .gray {
            background-color: lightgray
        }
        img {
            vertical-align: top;
        }
    </style>
</head>
    <body>

        <table width="100%">
    <tr >
        <td valign="left" >
            <strong style="font-size: 15px">Invoice No : {{$order->invoice_id}}</strong> <br>
            <?php
            $time = date('d M,Y,g:i a',strtotime($order->created_at) + 6 * 3600);
            ?>
            <b style={{--"color: #a0aec0;"--}}> {{$time}}</b><br><br>
            <strong  > Bill to </strong> <br>
            {{$order->customers->name}} <br>
            {{$order->customers->phone}}<br>
            {{$order->customers->email}}
            <br><br><hr><br>
            <strong  ><>Deliver to</strong> <br>
            {{$order->shippings->name}} <br>
            {{$order->shippings->phone}} &nbsp;  {{$order->shippings->email}}<br>
            {{$order->shippings->address}}
            <br>
        </td>
        <td align="right">
            <img  src="assets/vendor/images/brands/{{ Auth::user()->brands->image }}" width="90" height="50"    >
            <br><br>
            {{ Auth::user()->brands->name }}  <br>
            {{ Auth::user()->brands->address }}  <br>
            {{ Auth::user()->brands->phone }}  <br>
            {{ Auth::user()->brands->email }}  <br>
        </td>
    </tr>
</table>
        <br/>
        <table width="100%">
    <thead style="background-color: #464f47; color: #fff;">
    <tr align="center" >
        <th colspan="2" >ITEM & DESCRIPTION</th>
        <th>RATE</th>
        <th>QUANTITY</th>
        <th>AMOUNT</th>
    </tr>
    </thead>
    <tbody>
    <?php for($i=0;$i<count($selling_price);$i++)
    {
    ?>
    <tr>
        <td align="left" > <strong># {{$i+1}} </strong>
            @if(!empty($products[$i]->image))
                <?php
                    $imgarray = json_decode($products[$i]->image);
                ?>
                <img  src="assets/vendor/images/products/{{$imgarray[0]->image}}" width="33" height="25"    >
            @endif
            {{$products[$i]->name}}
        </td>
        <td {{--style="color: #a0aec0;"--}} align="center" >
            @if($offer_type[$i] === 'Discount')
               {{-- Actual Price : ৳ {{number_format($products[$i]->price)}} <br>--}}
                Discount : {{$offer_percentage[$i]}} %
            @endif
            @if($offer_type[$i] === 'Buy one get one')
                @if(!empty($free_products[$i]->image))
                    <?php
                        $imgarray2 = json_decode($free_products[$i]->image);
                        ?>
                          {{--<img  src="assets/vendor/images/products/{{$imgarray2[0]->image}}" width="33" height="25"    >--}}
                @endif
                <b>   Free   <a   href="{{route('productManagementEdit',Crypt::encrypt($free_products[0]->id))}}" title="Click To Edit Product">{{$free_products[0]->name}}</a> </b>
            @endif
        </td>
        <td align="center">
            @if($offer_type[$i] === 'Discount')
               <del> {{number_format($products[$i]->price)}} </del>
                {{number_format($selling_price[$i])}} BDT
             @else
                {{number_format($selling_price[$i])}} BDT
            @endif
        </td>
        <td align="center">{{$quantity[$i]}}</td>
        <td align="center">{{number_format($selling_price[$i] * $quantity[$i])}} BDT</td>
    </tr>
    <?php
    }
    ?>
    </tbody>
</table>

<table align="right"  width="30%" >
    <tr>
        <td ><span  class="bfont">Sub-Total</span></td>
        <td ><span  class="bfont">{{number_format($order->subtotal)}} BDT</span></td>
    </tr>
    <tr>
        <td ><span  class="bfont">Delivery Charge</span></td>
        <td ><span  class="bfont">{{number_format($order->total - $order->subtotal)}} BDT</span></td>
    </tr>
    <tr>
        <td ><span  class="bfont">Paid-Total</span></td>
        <td  class="gray"><span  class="bfont">{{number_format($order->total)}} BDT</span></td>
    </tr>
    <hr width="99%" align="left" >
</table>
        <table align="left"  width="70%" style="padding: 50px;" >
            <tr>
                <td colspan="2"><b>Payment Details</b></td>
            </tr>
            <tr>
                <td align="left" width="20%" >Method</td>
                <td align="left" width="50%"  >Bkash-{{$order->payments->method}}</td>
            </tr>
            <tr>
                <td align="left" width="20%" >Trx Id</td>
                <td align="left" width="50%"  ><b> &nbsp;{{$order->payments->trx_id}}</b></td>
            </tr>
            <tr>
                <td align="left" width="20%" >Bkash Number</td>
                <td align="left" width="50%"  ><b> &nbsp;{{$order->payments->sender_mobile_number}}</b></td>
            </tr>
        </table>


</body>
</html>
