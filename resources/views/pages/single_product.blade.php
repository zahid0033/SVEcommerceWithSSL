@extends('master')
@section('content')
    <!-- BREADCRUMB -->
    <div id="breadcrumb">
        <div class="container">
            <ul class="breadcrumb">
                <li><a href="#">Home</a></li>
                <li><a href="#">Products</a></li>
            </ul>
        </div>
    </div>
    <!-- /BREADCRUMB -->

    @foreach($product_single as $single)
        <!-- section -->
        <div class="section">
            <!-- container -->
            <div class="container">
                <!-- row -->
                <div class="row">
                    <!--  Product Details -->
                    <div class="product product-details clearfix">
                        <div class="col-md-6">
                            <div id="product-main-view">
                                @php
                                    $images = json_decode($single->image);
                                @endphp
                                @for($i = 0; $i < count($images) ; $i++)
                                    <div class="product-view">
                                        <img src="{{ asset('assets/vendor/images/products') }}/{{$images[$i]->image}}" alt="">
                                    </div>
                                @endfor
                            </div>
                            <div id="product-view">
                                @php
                                    $images = json_decode($single->image);
                                @endphp
                                @for($i = 0; $i < count($images) ; $i++)
                                    <div class="product-view">
                                        <img src="{{ asset('assets/vendor/images/products') }}/{{$images[$i]->image}}" alt="">
                                    </div>
                                @endfor
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="product-body">
                                <div class="product-label">
                                    @php
                                        date_default_timezone_set("Asia/Dhaka");
                                        $now = time(); // or your date as well
                                        $your_date = strtotime( $single->created_at );
                                        $datediff = $now - $your_date;
                                        $days_left = round($datediff / (60 * 60 * 24));
                                    @endphp
                                    @if($days_left <= 30)
                                        <span>New</span>
                                    @endif
                                    @if($single->offer_id != null && $single->offer_id == $single->offers->id)
                                        @if($single->offers->type == "Discount")
                                            <span class="sale">- {{$single->offers->offer_percentage}}%</span>
                                        @elseif($single->offers->type == "Buy one get one")
                                            <span class="sale" style="background: red">Buy 1 Get 1</span>
                                        @endif
                                    @endif



                                </div>
                                <h2 class="product-name">{{ $single->name }}</h2>
                                {{-- buy one get one  --}}

{{--                                @if($single->offer_id != null && $single->offer_id == $single->offers->id)--}}
{{--                                    @if($single->offers->type == "Discount")--}}
{{--                                        <h3 class="product-price">৳ {{ number_format($single->offer_price) }} <del class="product-old-price">৳ {{ number_format($single->price) }}</del></h3>--}}
{{--                                    @elseif($single->offers->type == "Buy one get one")--}}
{{--                                        @php--}}
{{--                                            $main_product_id = json_decode($single->offers->product_ids);--}}
{{--                                            $free_product_id = json_decode($single->offers->free_product_ids);--}}
{{--                                        @endphp--}}
{{--                                        @if($main_product_id[0]->id == $single->id)--}}
{{--                                            @php--}}
{{--                                                $free_product = \App\Product::find($free_product_id[0]->id);--}}
{{--                                            @endphp--}}
{{--                                            <h3 class="product-price">৳ {{ number_format($single->price) }} <span class="product-old-price">Get a <a href="{{ route('pages.single_product',Crypt::encrypt($free_product->id)  ) }}"> {{ $free_product->name }} </a> Free</span></h3>--}}
{{--                                        @endif--}}
{{--                                    @endif--}}
{{--                                @elseif($single->offer_id == null)--}}
{{--                                    <h3 class="product-price">৳ {{ number_format($single->price) }}</h3>--}}
{{--                                @endif--}}

                                @if($single->offer_id != null && $single->offer_id == $single->offers->id)
                                    @if($single->offers->type == "Discount")
                                        <h3 class="product-price">৳ {{ number_format($single->offer_price) }} <del class="product-old-price">৳ {{ number_format($single->price) }}</del></h3>
                                    @elseif($single->offers->type == "Buy one get one")
                                        @php
                                            $main_product_id = json_decode($single->offers->product_ids);
                                            $free_product_id = json_decode($single->offers->free_product_ids);
                                        @endphp
                                        @for($i = 0; $i < count($main_product_id) ; $i++)
                                            @if($main_product_id[$i]->id == $single->id)
                                                @for($j = 0; $j < count($free_product_id) ; $j++)
                                                    @php
                                                        $free_product[$j] = \App\Product::find($free_product_id[$j]->id);
                                                    @endphp
                                                    <h3 class="product-price">৳ {{ number_format($single->price) }} <span class="product-old-price">Get a <a href="{{ route('pages.single_product',Crypt::encrypt($free_product[$j]->id)  ) }}">{{ $free_product[$j]->name }} </a> Free</span></h3>
                                                @endfor
                                            @endif
                                        @endfor
                                    @endif
                                @elseif($single->offer_id == null)
                                    <h3 class="product-price">৳ {{ number_format($single->price) }}</h3>
                                @endif


                                {{-- buyone get one --}}

                                {{-- @if($single->offer_price != null)
                                    <h3 class="product-price">৳ {{ number_format($single->offer_price) }} <del class="product-old-price">৳ {{ number_format($single->price) }}</del></h3>
                                @else
                                    <h3 class="product-price">৳ {{ number_format($single->price) }}</h3>
                                @endif --}}
                                @if($single->status == 'Available')
                                    <p><strong>Availability:</strong> In Stock</p>
                                @elseif($single->status == 'Out of Stock')
                                    <p style="color: red"><strong>Availability:</strong> Out of Stock</p>
                                @endif

                                <p><strong>Brand:</strong> {{ $single->brands->name }}</p>
                                <h4><b>Description</b></h4>
                                <p>{!! $single->description !!}</p>


                                <div class="product-btns">
                                    @if($single->status == 'Available')
                                        <a href="{{ route('cart.add',[$single->id]) }}" class="primary-btn add-to-cart"><i class="fa fa-shopping-cart"></i> Add to Cart</a>
                                    @elseif($single->status == 'Out of Stock')
                                        <button class="primary-btn" style="background: #d43f3a;"><i class="fa fa-window-close"></i> Out Of Stock </button>
                                    @endif

                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="product-tab">
                                <ul class="tab-nav">
                                    <li class="active"><a data-toggle="tab" href="#tab1">Specification</a></li>
                                    <li><a data-toggle="tab" href="#tab2">Description</a></li>
                                </ul>
                                <div class="tab-content">
                                    <div id="tab1" class="tab-pane fade in active">
                                        {!! $single->specification !!}
                                    </div>
                                    <div id="tab2" class="tab-pane fade in ">
                                        {!! $single->description !!}
                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>
                    <!-- /Product Details -->
                </div>
                <!-- /row -->
            </div>
            <!-- /container -->
        </div>
        <!-- /section -->
    @endforeach

@endsection
