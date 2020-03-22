@extends('website.master')
@section('content')
    <section id="banner" class="banner-bg">
        <div class="single-item banner">
            <div><img style="width: 100%" src="{{ asset('assets/website/images/banner3.jpg') }}" alt=""></div>
            <div><img style="width: 100%" src="{{ asset('assets/website/images/banner4.jpg') }}" alt=""></div>
            <div><img style="width: 100%" src="{{ asset('assets/website/images/banner6.jpg') }}" alt=""></div>
            <div><img style="width: 100%" src="{{ asset('assets/website/images/banner5.jpg') }}" alt=""></div>
            <div><img style="width: 100%" src="{{ asset('assets/website/images/image_wall.jpg') }}" alt=""></div>
        </div>
    </section>
    <section id="why_us" style="margin: 50px 0">
        <div class="container">
            <h1 class="text-center mt-5 mb-3">Our Achievements</h1>
            <p class="text-center">Nobin Bangladesh was established by Mr. Anamul Hasan in 2001, is a fast growing Mobile Phone brand in Bangladesh and has been operating its business successfully for 19 years in the name of MOHAMMADIA TELECOM.in recent we have now NOBIN BANGLADESH is a sister concern of MOHAMMADIA TELECOM and workforce of  more than 50. Main products of Nobin Bangladesh are Television, Cellular Phone, Watch, Electrical Fan, LED Bulb. Nobin Bangladesh is the manufacturer and seller in the relevant industry and has gained high reputation in terms of its unbeatable capability for producing Electrical and Electronics goods in the most competitive way in aspect of quality, cost, design and innovation.</p>
        </div>
    </section>
    <section>
        <div class="section">
            <!-- container -->
            <div class="container">
                <!-- row -->
                <div class="row">
                    <!-- section title -->
                    <div class="col-md-12">
                        <div class="section-title">
                            <h2 class="title">Latest Products</h2>
                        </div>
                    </div>
                    <!-- section title -->

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
                                        <a href="{{ route('pages.single_product',Crypt::encrypt($product->id)  ) }}" class="primary-btn add-to-cart"><i class="fa fa-shopping-cart"></i> See Details </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    <!-- /Product Single -->

                </div>
                <!-- /row -->
            </div>
            <!-- /container -->
        </div>
    </section>
    <section>
        <div class="section section-grey">
            <!-- container -->
            <div class="container">
                <!-- row -->
                <div class="row">
                    <!-- banner -->
                    <div class="col-md-8">
                            <a  href="{{ route('pages.subCatgProductSearch',Crypt::encrypt($categories[0]->id) ) }}" class="banner banner-1">
                                <img src="{{ asset('assets/vendor/images/categories') }}/{{ $categories[0]->image }}" alt="">
                                <div class="banner-caption text-center">
                                    <h1 class="primary-color">HOT DEAL<br><span class="white-color font-weak">{{$categories[0]->name}}</span></h1>
                                    {{--                                <button class="primary-btn">Shop Now</button>--}}
                                </div>
                            </a>
                    </div>
                    <!-- /banner -->

                    <!-- banner -->
                    <div class="col-md-4 col-sm-6">
                        <a class="banner banner-1" href="{{ route('pages.subCatgProductSearch',Crypt::encrypt($categories[1]->id) ) }}">
                            <img src="{{ asset('assets/vendor/images/categories') }}/{{ $categories[1]->image }}" alt="">
                            <div class="banner-caption text-center">
                                <h2 class="white-color">{{$categories[1]->name}}</h2>
                            </div>
                        </a>
                    </div>
                    <!-- /banner -->

                    <!-- banner -->
                    <div class="col-md-4 col-sm-6">
                        <a class="banner banner-1" href="{{ route('pages.subCatgProductSearch',Crypt::encrypt($categories[2]->id) ) }}">
                            <img src="{{ asset('assets/vendor/images/categories') }}/{{ $categories[2]->image }}" alt="">
                            <div class="banner-caption text-center">
                                <h2 class="white-color">{{$categories[2]->name}}</h2>
                            </div>
                        </a>
                    </div>
                    <!-- /banner -->
                </div>
                <!-- /row -->
            </div>
            <!-- /container -->
        </div>
    </section>
    <section>
        <div class="container">
            <!-- row -->
            <div class="row">
                <!-- section title -->
                <div class="col-md-12">
                    <div class="section-title">
                        <h2 class="title">Picked For You</h2>
                    </div>
                </div>
                <!-- section title -->

                <!-- Product Single -->
                <div class="col-md-3 col-sm-6 col-xs-6">
                    <div class="product product-single product-hot">
                        <div class="product-thumb">
{{--                            <button class="main-btn quick-view"><i class="fa fa-search-plus"></i> Quick view</button>--}}
                            <img src="{{ asset('assets/vendor/images/categories') }}/{{ $categories[0]->image }}" alt="">
                        </div>
                        <div class="product-body">
                            <h2 class="product-name text-center"><a href="#">Televisions</a></h2>
                            <div class="product-btns text-center">
                                <button class="primary-btn add-to-cart">Best Sellings</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /Product Single -->

                <!-- Product Slick -->
                <div class="col-md-9 col-sm-6 col-xs-6">
                    <div class="row">
                        <div id="product-slick-2" class="">
                            <!-- Product Single -->
                            @foreach($tvs as $tv)

                                <div class="col-md-3 col-sm-6 col-xs-6">
                                    <div class="product product-single">
                                        <div class="product-thumb">
                                            <div class="product-label">
                                                @php
                                                    date_default_timezone_set("Asia/Dhaka");
                                                    $now = time(); // or your date as well
                                                    $your_date = strtotime( $tv->created_at );
                                                    $datediff = $now - $your_date;
                                                    $days_left = round($datediff / (60 * 60 * 24));
                                                @endphp
                                                @if($days_left <= 30)
                                                    <span>New</span>
                                                @endif
                                                @if($tv->offer_id != null && $tv->offer_id == $tv->offers->id)
                                                    @if($tv->offers->type == "Discount")
                                                        <span class="sale">- {{$tv->offers->offer_percentage}}%</span>
                                                    @elseif($tv->offers->type == "Buy one get one")
                                                        <span class="sale" style="background: red">Buy 1 Get 1</span>
                                                    @endif
                                                @endif

                                            </div>

                                            @php
                                                $imgarray = json_decode($tv->image);
                                            @endphp
                                            <img src="{{ asset('assets/vendor/images/products') }}/{{$imgarray[0]->image}}" alt="">
                                        </div>
                                        <div class="product-body">
                                            @if($tv->offer_id != null && $tv->offer_id == $tv->offers->id)
                                                @if($tv->offers->type == "Discount")
                                                    <h3 class="product-price">৳ {{ number_format($tv->offer_price) }} <del class="product-old-price">৳ {{ number_format($tv->price) }}</del></h3>
                                                @elseif($tv->offers->type == "Buy one get one")
                                                    @php
                                                        $main_product_id = json_decode($tv->offers->product_ids);
                                                        $free_product_id = json_decode($tv->offers->free_product_ids);
                                                    @endphp
                                                    @for($i = 0; $i < count($main_product_id) ; $i++)
                                                        @if($main_product_id[$i]->id == $tv->id)
                                                            @for($j = 0; $j < count($free_product_id) ; $j++)
                                                                @php
                                                                    $free_product[$j] = \App\Product::find($free_product_id[$j]->id);
                                                                @endphp
                                                                <h3 class="product-price">৳ {{ number_format($tv->price) }} <span class="product-old-price">Get {{ $free_product[$j]->name }} Free</span></h3>
                                                            @endfor
                                                        @endif
                                                    @endfor
                                                @endif
                                            @elseif($tv->offer_id == null)
                                                <h3 class="product-price">৳ {{ number_format($tv->price) }}</h3>
                                            @endif

                                            <h2 class="product-name"><a href="{{ route('pages.single_product',Crypt::encrypt($tv->id) ) }}">{{ $tv->name }}</a></h2>
                                            <div class="product-btns text-center">
                                                <a href="{{ route('pages.single_product',Crypt::encrypt($tv->id)  ) }}" class="primary-btn add-to-cart"><i class="fa fa-shopping-cart"></i> See Details </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            <!-- /Product Single -->

                        </div>
                    </div>
                </div>
                <!-- /Product Slick -->
            </div>
            <!-- /row -->
        </div>
    </section>

    @if(!$offers->isEmpty())
        <section id="we_have" style="margin: 50px 0">
            <div class="container">
                <h1 class="text-center mt-5 mb-3">Latest Offers</h1>
                <div class="row">
                    @foreach($offers as $offer)
                        <div class="col-md-4 col-sm-6">
                            <a class="banner banner-1" href="{{ route('pages.offerSearchByTitle',Crypt::encrypt($offer->id) ) }}">
                                <div class="card">
                                    <img class="card-img-top p-2" src="{{ asset('assets/vendor/images/offers') }}/{{$offer->image}}" alt="">
                                    <div class="banner-caption text-center">
                                        <h2 class="white-color">{{ $offer->title }}</h2>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>

            </div>
        </section>
    @endif
    <section id="we_deliver" style="margin: 50px 0">
        <div class="row">
            <div class="col-md-6">
                <div class="map-img text-center">
                    <img src="{{ asset('assets/website/images/loader.gif') }}" class="p-3" style="width: 300px;height: 300px" alt="">
                </div>
            </div>
            <div class="col-md-6 p-5">
                <div class="map-text" style="text-align: center">
                    <h1 style="margin-top: 50px">We Deliver</h1>
                    <h1>All Over</h1>
                    <h1 style="color: #ffffff">Bangladesh</h1>
                </div>
            </div>
        </div>
    </section>
    <section id="people_love_us" style="margin: 70px 0">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <div class="people_icon text-center p-3">
                        <i class="fa fa-truck fa-5x"></i>
                    </div>
                    <div class="people_title text-center">
                        <h2>Fast Delivery</h2>
                        <p>No waiting in traffic, no haggling, no worries carrying groceries, they're delivered right at your door.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="people_icon text-center p-3">
                        <i class="fa fa-user-circle fa-5x"></i>
                    </div>
                    <div class="people_title text-center">
                        <h2>24 hr service</h2>
                        <p>No waiting in traffic, no haggling, no worries carrying groceries, they're delivered right at your door.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="people_icon text-center p-3">
                        <i class="fa fa-shopping-bag fa-5x"></i>
                    </div>
                    <div class="people_title text-center">
                        <h2>Best Quality Product</h2>
                        <p>No waiting in traffic, no haggling, no worries carrying groceries, they're delivered right at your door.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        $('#carousel02').owlCarousel({
            rtl:false,
            loop:true,
            autoplay: true,
            dots: false,
            autoPlay:100,
            margin:10,
            nav:false,
            animateOut: 'fadeOut',
            animateIn: 'fadeIn',
            navText: [
                "<i class='fa fa-caret-left'></i>",
                "<i class='fa fa-caret-right'></i>"
            ],
            responsive:{
                0:{
                    items:2
                },
                600:{
                    items:4
                },
                1000:{
                    items:3
                }
            }
        });

    </script>
@endsection
