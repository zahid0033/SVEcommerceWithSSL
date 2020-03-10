@extends('master')
@section('content')
    <!-- BREADCRUMB -->
    <div id="breadcrumb">
        <div class="container">
            <ul class="breadcrumb">
                <li><a href="#">Home</a></li>
                <li class="active">Products</li>
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

                <!-- MAIN -->
                <div id="main" class="col-md-12">
                    <!-- store top filter -->
                    <div class="store-filter clearfix">
                        <div class="pull-left">
                            <div class="row-filter">

                                <a href="#" class="active"><i class="fa fa-bars"></i></a>
                            </div>
{{--                            <div class="sort-filter">--}}
{{--                                <span class="text-uppercase">Sort By:</span>--}}
{{--                                <select class="input">--}}
{{--                                    <option value="0">Position</option>--}}
{{--                                    <option value="0">Price</option>--}}
{{--                                    <option value="0">Rating</option>--}}
{{--                                </select>--}}
{{--                                <a href="#" class="main-btn icon-btn"><i class="fa fa-arrow-down"></i></a>--}}
{{--                            </div>--}}
                        </div>
                        <div class="pull-right">
                            {{ $products->links() }}
                        </div>
                    </div>
                    <!-- /store top filter -->

                    <!-- STORE -->
                    <div id="store">
                        <!-- row -->
                        <div class="row">
                            <!-- Product Single -->
                            @foreach($products as $product)
                                <div class="col-md-3 col-sm-6 col-xs-6">
                                    <div class="product product-single">
                                        <div class="product-thumb">
                                            <div class="product-label">
                                                @php
                                                    date_default_timezone_set("Asia/Dhaka");
                                                    $now = time(); // or your date as well
                                                    $your_date = strtotime( $product->created_at );
                                                    $datediff = $now - $your_date;
                                                    $days_left = round($datediff / (60 * 60 * 24));
                                                @endphp
                                                @if($days_left <= 30)
                                                    <span>New</span>
                                                @endif
                                                @if($product->offer_id != null && $product->offer_id == $product->offers->id)
                                                    @if($product->offers->type == "Discount")
                                                        <span class="sale">- {{$product->offers->offer_percentage}}%</span>
                                                    @elseif($product->offers->type == "Buy one get one")
                                                        <span class="sale" style="background: red">Buy 1 Get 1</span>
                                                    @endif
                                                @endif

                                            </div>

                                            <a href="{{ route('pages.single_product',Crypt::encrypt($product->id)  ) }}" class="main-btn quick-view"><i class="fa fa-search-plus"></i> See Details </a>
                                            @php
                                                $imgarray = json_decode($product->image);
                                            @endphp
                                            <img src="{{ asset('assets/vendor/images/products') }}/{{$imgarray[0]->image}}" alt="">
                                        </div>
                                        <div class="product-body">
                                            @if($product->offer_id != null && $product->offer_id == $product->offers->id)
                                                @if($product->offers->type == "Discount")
                                                    <h3 class="product-price">৳ {{ number_format($product->offer_price) }} <del class="product-old-price">৳ {{ number_format($product->price) }}</del></h3>
                                                @elseif($product->offers->type == "Buy one get one")
                                                    @php
                                                        $main_product_id = json_decode($product->offers->product_ids);
                                                        $free_product_id = json_decode($product->offers->free_product_ids);
                                                    @endphp
                                                    @for($i = 0; $i < count($main_product_id) ; $i++)
                                                        @if($main_product_id[$i]->id == $product->id)
                                                            @for($j = 0; $j < count($free_product_id) ; $j++)
                                                                @php
                                                                    $free_product[$j] = \App\Product::find($free_product_id[$j]->id);
                                                                @endphp
                                                                <h3 class="product-price">৳ {{ number_format($product->price) }} <span class="product-old-price">Get {{ $free_product[$j]->name }} Free</span></h3>
                                                            @endfor
                                                        @endif
                                                    @endfor
                                                @endif
                                            @elseif($product->offer_id == null)
                                                <h3 class="product-price">৳ {{ number_format($product->price) }}</h3>
                                            @endif

                                            <h2 class="product-name"><a href="{{ route('pages.single_product',Crypt::encrypt($product->id) ) }}">{{ $product->name }}</a></h2>
                                            <div class="product-btns text-center">
                                                @if($product->status == 'Available')
                                                    <a href="{{ route('cart.add',[$product->id]) }}" class="primary-btn add-to-cart"><i class="fa fa-shopping-cart"></i> Add to Cart</a>
                                                @elseif($product->status == 'Out of Stock')
                                                    <button class="primary-btn" style="background: #d43f3a;"><i class="fa fa-window-close"></i> Out Of Stock </button>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        @endforeach
                        <!-- /Product Single -->
                        </div>

                        <!-- /row -->
                    </div>
                    <!-- /STORE -->

                    <!-- store bottom filter -->
                    <div class="store-filter clearfix">
                        <div class="pull-left">
                            <div class="row-filter">
                                <a href="#" class="active"><i class="fa fa-bars"></i></a>
                            </div>
{{--                            <div class="sort-filter">--}}
{{--                                <span class="text-uppercase">Sort By:</span>--}}
{{--                                <select class="input">--}}
{{--                                    <option value="0">Position</option>--}}
{{--                                    <option value="0">Price</option>--}}
{{--                                    <option value="0">Rating</option>--}}
{{--                                </select>--}}
{{--                                <a href="#" class="main-btn icon-btn"><i class="fa fa-arrow-down"></i></a>--}}
{{--                            </div>--}}
                        </div>
                        <div class="pull-right">
                            {{ $products->links() }}
                        </div>
                    </div>
                    <!-- /store bottom filter -->
                </div>
                <!-- /MAIN -->
            </div>
            <!-- /row -->
        </div>
        <!-- /container -->
    </div>
    <!-- /section -->





@endsection
