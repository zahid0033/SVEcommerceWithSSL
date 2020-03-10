@extends('website.master')
@section('content')
    <section id="banner" class="banner-bg">
        <div class="single-item banner">
            <div><img style="width: 100%" src="{{ asset('assets/website/images/banner3.jpg') }}" alt=""></div>
            <div><img style="width: 100%" src="{{ asset('assets/website/images/banner4.jpg') }}" alt=""></div>
            <div><img style="width: 100%" src="{{ asset('assets/website/images/banner6.jpg') }}" alt=""></div>
            <div><img style="width: 100%" src="{{ asset('assets/website/images/banner5.jpg') }}" alt=""></div>
            <div><img style="width: 100%" src="{{ asset('assets/website/images/image_wall.jpg') }}" alt=""></div>
{{--            <div>--}}
{{--                <video width="100%"  height="490px" autoplay loop>--}}
{{--                    <source src="{{ asset('assets/website/images/banner5.mp4') }}" type="video/mp4">--}}
{{--                    Your browser does not support the video tag.--}}
{{--                </video>--}}
{{--            </div>--}}
        </div>
    </section>
    <section id="why_us" style="margin: 50px 0">
        <div class="container">
            <h1 class="text-center mt-5 mb-3">Our Achievements</h1>
            <p class="text-center">Nobin Bangladesh was established by Mr. Anamul Hasan in 2001, is a fast growing Mobile Phone brand in Bangladesh and has been operating its business successfully for 19 years in the name of MOHAMMADIA TELECOM.in recent we have now NOBIN BANGLADESH is a sister concern of MOHAMMADIA TELECOM and workforce of  more than 50. Main products of Nobin Bangladesh are Television, Cellular Phone, Watch, Electrical Fan, LED Bulb. Nobin Bangladesh is the manufacturer and seller in the relevant industry and has gained high reputation in terms of its unbeatable capability for producing Electrical and Electronics goods in the most competitive way in aspect of quality, cost, design and innovation.</p>
        </div>
    </section>
    <section id="we_have" style="margin: 50px 0">
        <div class="container">
            <h1 class="text-center mt-5 mb-3">Products We Have</h1>
            <div class="row">
                @foreach($categories as $category)
                    <div class="col-md-4 mb-3">
                        <a href="{{ route('pages.subCatgProductSearch',Crypt::encrypt($category->id) ) }}" target="_blank">
                            <div class="card" >
                            <img class="card-img-top p-2" src="{{ asset('assets/vendor/images/categories') }}/{{ $category->image }}" alt="Card image cap">
                            <div class="card-body">
                                <p class="card-text text-center"><b>{{ $category->name }}</b></p>
                            </div>
                        </div>
                        </a>
                    </div>
                @endforeach
            </div>

        </div>
    </section>

    @if(!$offers->isEmpty())
        <section id="we_have" style="margin: 50px 0">
            <div class="container">
                <h1 class="text-center mt-5 mb-3">Latest Offers</h1>
                <div class="row">
                    @foreach($offers as $offer)
                        <div class="col-md-4 mb-3">
                            <a href="{{ route('pages.offerSearchByTitle',Crypt::encrypt($offer->id) ) }}" target="_blank">
                                <div class="card" >
                                    <img class="card-img-top p-2" src="{{ asset('assets/vendor/images/offers') }}/{{$offer->image}}" alt="Card image cap">
                                    <div class="card-body">
                                        <p class="card-text text-center"><b>{{ $offer->title }}</b></p>
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
