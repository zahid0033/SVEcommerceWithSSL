@extends('master')
@section('content')
    <!-- BREADCRUMB -->
    <div id="breadcrumb">
        <div class="container">
            <ul class="breadcrumb">
                <li><a href="#">Home</a></li>
                <li class="active">Checkout</li>
            </ul>
        </div>
    </div>
    <!-- /BREADCRUMB -->

    <!-- section -->
    <div class="section">
        <!-- container -->
        <div class="container">
            <!-- row -->
            <div class="row">
                <form id="checkout-form" method="post" action="{{ route('paymentConfirm') }}" class="clearfix">
                    @csrf
                    <div class="col-md-6">
                        <div class="billing-details">

                            <div class="section-title">
                                <h3 class="title">Shipping Details</h3>
                            </div>
                            <div class="form-group">
                                <input type="hidden" name="customer_id" value="{{Auth::user()->id}}">
                                <input type="hidden" name="temp_order_id" value="{{ $temp_orders->id }}">
                            </div>
                            <div class="form-group">
                                <input class="input" type="text" name="name" placeholder="Name" value="{{ Auth::user()->name }}" required>
                            </div>
                            <div class="form-group">
                                <input class="input" type="email" name="email" placeholder="Email" value="{{ Auth::user()->email }}" required>
                            </div>
                            <div class="form-group">
                                <input class="input" type="text" name="address" placeholder="Address" value="{{ Auth::user()->address }}" required>
                            </div>
                            <div class="form-group">
                                <input class="input" type="text" name="city" placeholder="City" value="{{ Auth::user()->city }}" required>
                            </div>
                            <div class="form-group">
                                <input class="input" type="tel" name="phone" placeholder="Phone" value="{{ Auth::user()->phone }}" required>
                            </div>

                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="cart_details">
                            <h2 style="text-align: center; color: deepskyblue"> Shopping Details</h2>
                            <table class="shopping-cart-table table">
                                <thead>

                                </thead>


                                <tbody>
                                </tbody>


                                <tfoot>
                                <tr>
                                    <th class="empty" colspan="3"></th>
                                    <th>SUBTOTAL</th>
                                    <th colspan="2" class="sub-total">{{ Cart::subtotal() }}</th>
                                </tr>
                                <tr>
                                    <th class="empty" colspan="3"></th>
                                    <th>SHIPING</th>
                                    <td colspan="2">Shipping by Customer </td>
                                </tr>
                                <tr>
                                    <th class="empty" colspan="3"></th>
                                    <th>TOTAL</th>
<!--                                    --><?php //$total_with_delivery = str_replace(',', '', Cart::total()) + 20;
//                                    $total = number_format($total_with_delivery,2) ?>
                                    <th colspan="2" class="total">{{ Cart::total() }}</th>
                                </tr>
                                </tfoot>
                            </table>
                        </div>


                        <div class="payments-methods">
                            <div class="section-title">
                                <h4 class="title">Payments Methods</h4>
                            </div>
                            <p>Merchant Bkash Number <b>01995-533445</b> </p>
                            <div class="form-group">
                                <input class="input" type="tel" name="sender_mbl" placeholder="Sender Number" required>
                            </div>
                            <div class="form-group">
                                <input class="input" type="text" name="trx_number" placeholder="Trx Number" required>
                            </div>
                        </div>
                    </div>


                    <input type="submit" value="Confirm payment" class="primary-btn">
                    {{--                    <a href="" class="primary-btn">Place Order</a>--}}


                </form>
            </div>
            <!-- /row -->
        </div>
        <!-- /container -->
    </div>
    <!-- /section -->
@endsection
