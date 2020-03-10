@extends('master')
@section('content')
    <!-- BREADCRUMB -->
    <div id="breadcrumb">
        <div class="container">
            <ul class="breadcrumb">
                <li><a href="#">Home</a></li>
                <li class="active">Cart</li>
            </ul>
        </div>
    </div>
    <!-- /BREADCRUMB -->

    <div class="container">
        @if(Cart::count() == 0)
            <h1 style="padding: 1em;text-align: center">Cart Empty</h1>
            <a href="{{ route('pages.products') }}" style="padding-left:1em"><h2 style="padding-left: 1em; text-align:center;color:#2bace2;">Go to Product page</h2></a>
        @else
            <div class="row">
                <div class="col-md-12">
                    <div class="order-summary clearfix">
                        <div class="section-title">
                            <h3 class="title">Order Review</h3>
                        </div>
                        @if( $errors->has('qty') )
                            <span style="color:red">{{ $errors->first('qty') }}</span>
                        @endif
                        <table class="shopping-cart-table table">
                            <thead>
                            <tr>
                                <th>Product</th>
                                <th></th>
                                <th class="text-center">Price</th>
                                <th class="text-center">Quantity</th>
                                <th class="text-center">Total</th>
                                <th class="text-right"></th>
                            </tr>
                            </thead>


                            <tbody>

                            @php $i=0 @endphp
                            @foreach($cart_datas as $cart_data)

                                <tr>
                                    <td class="thumb"><img src="{{ asset('assets/vendor/images/products') }}/{{ $cart_data->options->image }}" alt=""></td>
                                    <td class="details">
                                        <a href="{{ route('pages.single_product',Crypt::encrypt($cart_data->id)  ) }}">{{ $cart_data->name }}</a>
                                        <ul>
                                            @if($cart_data->options->free_product == null)
                                                <li><span><b>Size:</b> {{ $cart_data->options->size }}</span></li>
                                            @else
                                                <li><span><b>Size:</b> {{ $cart_data->options->size }}</span></li>
                                                <li><span><b>Free product:</b> {{ $cart_data->options->free_product }}</span></li>
                                            @endif

{{--                                            <li><span>Color: Camelot</span></li>--}}
                                        </ul>
                                        @php $product_info = \App\Product::find($cart_data->id) @endphp
                                        @if($product_info->stock == 0)
                                            <button class="btn btn-danger">out of stock</button>
                                        @endif
                                    </td>
                                    @if($cart_data->options->offer_percentage != null)
                                        <td class="price text-center"><strong>{{$cart_data->price}}</strong><span class="primary-color"> -{{ $cart_data->options->offer_percentage }}% </span><br></td>
                                    @else
                                        <td class="price text-center"><strong>{{$cart_data->price}}</strong><br></td>
                                    @endif
{{--                                    <td class="price text-center"><strong>{{$cart_data->price}}</strong><br></td>--}}
                                    <td class="qty text-center">
                                        <form method="post" action="{{ route('cart.update') }}">
                                            {{ @csrf_field() }}
                                            <div class="">
                                                <input class="input" type="hidden" name="product_id" id="Pro_id{{ $i }}" value="{{ $cart_data->id }}">
                                                <input class="input" type="number" name="qty" id="qty{{ $i }}" value="{{ $cart_data->qty }}">
                                                <input class="input" type="hidden" name="rowId" id="cart_id{{ $i }}" value="{{ $cart_data->rowId }}">
                                            </div>
                                            <div class ="form-group{{ $errors->has('quantity.'.$i) ? 'has-error' : '' }}">
                                                <input class="hidden" type="number" name="quantity[]" id="quantity{{ $i }}" value="{{ $cart_data->qty }}">
                                                @if( $errors->has('quantity.'.$i) )
                                                    <span style="color:red">{{ $errors->first('quantity.'.$i) }}</span>
                                                @endif
                                            </div>
                                            <input type="submit" class="btn btn-sm btn-success" value="update">
                                        </form>
                                    </td>
                                    <td class="total text-center"><strong class="primary-color">{{ $cart_data->price * $cart_data->qty }}</strong></td>
                                    <td class="text-right"><a href="{{ route('cart.delete',[$cart_data->rowId])  }}" class="main-btn icon-btn"><i class="fa fa-close"></i></a></td>
                                </tr>
                                @php $i++ @endphp
                            @endforeach

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
                                <td colspan="2">Shipping by Customer</td>
                            </tr>
                            <tr>
                                <th class="empty" colspan="3"></th>
                                <th>TOTAL</th>
<!--                                --><?php //$total_with_delivery = str_replace(',', '', Cart::total()) + 20;
//                                      $total = number_format($total_with_delivery,2) ?>
                                <th colspan="2" class="total">{{Cart::total()}}</th>
                            </tr>
                            </tfoot>
                        </table>

                        <form method="post" action="{{ route('place_order') }}">
                            {{ @csrf_field() }}

                            @php $i=0 @endphp
                            @foreach($cart_datas as $key=>$cart_data)
                                <div class="form-group{{ $errors->has('quantity.'.$i) ? 'has-error' : '' }}">
                                    <input type="hidden" name="pro_id_{{$i}}" id="Pro_id{{ $i }}" value="{{ $cart_data->id }}"><br>
                                    <input type="hidden" name="quantity[]" id="quantity{{ $i }}" value="{{ $cart_data->qty }}"><br>
                                    <input type="hidden" name="cart_id_{{$i}}" id="cart_id{{ $i }}" value="{{ $cart_data->rowId }}">
{{--                                    @if( $errors->has('quantity.'.$i) )--}}
{{--                                        <span style="color:red">{{ $errors->first('quantity.'.$i) }}</span>--}}
{{--                                    @endif--}}
                                </div>
                                @php $i++ @endphp
                            @endforeach
                            <div class="pull-right">
                                <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                                <input type="submit" value="Place Order" class="primary-btn">
{{--                                <a href="{{ route('temp_orders') }}" class="primary-btn">Place Order</a>--}}
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        @endif
    </div>

@endsection
