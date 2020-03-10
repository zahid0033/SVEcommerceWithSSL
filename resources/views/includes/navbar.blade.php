<!-- NAVIGATION -->
<div id="navigation">
    <!-- container -->
    <div class="container">
        <div id="responsive-nav">
            <!-- category nav -->
            <div class="category-nav show-on-click">
                <span class="category-header">Categories <i class="fa fa-list"></i></span>
                <ul class="category-list">
                    @php $categories = App\Category::all() @endphp
                    @foreach($categories as $catg)
                        @if($catg->parent_id == null)
                        <li class="dropdown side-dropdown">

                                <a class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">{{ $catg->name }} <i class="fa fa-angle-right"></i></a>

                                @php $subCategories = App\Category::where('parent_id',$catg->id)->get() @endphp

                                @if(!is_null($subCategories))
                                        <div class="custom-menu">
                                            <div class="row">
{{--                                                <h3 class="list-links-title" style="padding-left: 10px">Sub Categories</h3>--}}
                                                @foreach($subCategories as $subCatg)
                                                <div class="col-md-4">
                                                    <ul class="list-links">
                                                        <li><a href="{{ route('pages.subCatgProductSearch',Crypt::encrypt($subCatg->id) ) }}">{{ $subCatg->name }}</a></li>
                                                    </ul>
                                                    <hr class="hidden-md hidden-lg">
                                                </div>
                                                @endforeach
                                            </div>
                                            <div class="row hidden-sm hidden-xs">
                                                <div class="col-md-12">
                                                    <hr>
{{--                                                    <a class="banner banner-1" href="{{ route('pages.single') }}">--}}
{{--                                                        <img src="{{ asset('assets/vendor/images/categories') }}/{{ $subCatg->image }}" alt="">--}}
{{--                                                        <div class="banner-caption text-center">--}}
{{--                                                            <h2 class="white-color">NEW COLLECTION</h2>--}}
{{--                                                            <h3 class="white-color font-weak">HOT DEAL</h3>--}}
{{--                                                        </div>--}}
{{--                                                    </a>--}}
                                                </div>
                                            </div>
                                        </div>
                                @endif
                        </li>
                        @endif

                    @endforeach

                </ul>
            </div>
            <!-- /category nav -->

            <!-- menu nav -->
            <div class="menu-nav">
                <span class="menu-header">Menu <i class="fa fa-bars"></i></span>
                <ul class="menu-list">
                    <li><a href="{{ route('pages.allOfferSearch') }}">All Offers</a></li>
{{--                    <li><a href="{{  route('pages.single') }}">Shop</a></li>--}}
{{--                    <li class="dropdown mega-dropdown full-width"><a class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">Life Style <i class="fa fa-caret-down"></i></a>--}}
{{--                        <div class="custom-menu">--}}
{{--                            <div class="row">--}}
{{--                                <div class="col-md-3">--}}
{{--                                    <div class="hidden-sm hidden-xs">--}}
{{--                                        <a class="banner banner-1" href="{{ route('pages.single') }}">--}}
{{--                                            <img src="{{ asset('assets/img/banner06.jpg') }}" alt="">--}}
{{--                                            <div class="banner-caption text-center">--}}
{{--                                                <h3 class="white-color text-uppercase">Men's</h3>--}}
{{--                                            </div>--}}
{{--                                        </a>--}}
{{--                                        <hr>--}}
{{--                                    </div>--}}
{{--                                    <ul class="list-links">--}}
{{--                                        <li>--}}
{{--                                            <h3 class="list-links-title">Men's Categories</h3></li>--}}
{{--                                        <li><a href="{{ route('pages.single') }}">Pant</a></li>--}}
{{--                                        <li><a href="{{ route('pages.single') }}">Shoe</a></li>--}}
{{--                                        <li><a href="{{ route('pages.single') }}">Bag</a></li>--}}
{{--                                        <li><a href="{{ route('pages.single') }}">T-shirt</a></li>--}}
{{--                                        <li><a href="{{ route('pages.single') }}">Jacket</a></li>--}}
{{--                                    </ul>--}}
{{--                                </div>--}}
{{--                                <div class="col-md-3">--}}
{{--                                    <div class="hidden-sm hidden-xs">--}}
{{--                                        <a class="banner banner-1" href="{{ route('pages.single') }}">--}}
{{--                                            <img src="{{ asset('assets/img/banner07.jpg') }}" alt="">--}}
{{--                                            <div class="banner-caption text-center">--}}
{{--                                                <h3 class="white-color text-uppercase">Women’s</h3>--}}
{{--                                            </div>--}}
{{--                                        </a>--}}
{{--                                    </div>--}}
{{--                                    <hr>--}}
{{--                                    <ul class="list-links">--}}
{{--                                        <li>--}}
{{--                                            <h3 class="list-links-title">Women's Categories</h3></li>--}}
{{--                                        <li><a href="{{ route('pages.single') }}">Saree</a></li>--}}
{{--                                        <li><a href="{{ route('pages.single') }}">Clothing</a></li>--}}
{{--                                        <li><a href="{{ route('pages.single') }}">Weeding dress</a></li>--}}
{{--                                        <li><a href="{{ route('pages.single') }}">Salwar kameez</a></li>--}}
{{--                                        <li><a href="{{ route('pages.single') }}">Bags & Shoes</a></li>--}}
{{--                                    </ul>--}}
{{--                                </div>--}}
{{--                                <div class="col-md-3">--}}
{{--                                    <div class="hidden-sm hidden-xs">--}}
{{--                                        <a class="banner banner-1" href="{{ route('pages.single') }}">--}}
{{--                                            <img src="{{ asset('assets/img/banner08.jpg') }}" alt="">--}}
{{--                                            <div class="banner-caption text-center">--}}
{{--                                                <h3 class="white-color text-uppercase">Accessories</h3>--}}
{{--                                            </div>--}}
{{--                                        </a>--}}
{{--                                    </div>--}}
{{--                                    <hr>--}}
{{--                                    <ul class="list-links">--}}
{{--                                        <li>--}}
{{--                                            <h3 class="list-links-title">MOBILE ACCESSORIES</h3></li>--}}
{{--                                        <li><a href="{{ route('pages.single') }}">Headphone</a></li>--}}
{{--                                        <li><a href="{{ route('pages.single') }}">Data Cable</a></li>--}}
{{--                                        <li><a href="{{ route('pages.single') }}">Power Bank</a></li>--}}
{{--                                        <li><a href="{{ route('pages.single') }}">Memory Card</a></li>--}}
{{--                                        <li><a href="{{ route('pages.single') }}">Screen Protector</a></li>--}}
{{--                                    </ul>--}}
{{--                                </div>--}}
{{--                                <div class="col-md-3">--}}
{{--                                    <div class="hidden-sm hidden-xs">--}}
{{--                                        <a class="banner banner-1" href="{{ route('pages.single') }}">--}}
{{--                                            <img src="{{ asset('assets/img/banner16.jpg') }}" alt="">--}}
{{--                                            <div class="banner-caption text-center">--}}
{{--                                                <h3 class="white-color text-uppercase">Baby's</h3>--}}
{{--                                            </div>--}}
{{--                                        </a>--}}
{{--                                    </div>--}}
{{--                                    <hr>--}}
{{--                                    <ul class="list-links">--}}
{{--                                        <li>--}}
{{--                                            <h3 class="list-links-title">Baby's Categories</h3></li>--}}
{{--                                        <li><a href="{{ route('pages.single') }}">Feeding</a></li>--}}
{{--                                        <li><a href="{{ route('pages.single') }}">Baby Gear</a></li>--}}
{{--                                        <li><a href="{{ route('pages.single') }}">Nursery</a></li>--}}
{{--                                        <li><a href="{{ route('pages.single') }}">Toys</a></li>--}}
{{--                                        <li><a href="{{ route('pages.single') }}">Baby sitting</a></li>--}}
{{--                                    </ul>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </li>--}}
{{--                    <li><a href="{{  route('website.home') }}" target="_blank">Web Page</a></li>--}}
{{--                    <li class="dropdown default-dropdown"><a class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">Pages <i class="fa fa-caret-down"></i></a>--}}
{{--                        <ul class="custom-menu">--}}
{{--                            <li><a href="{{ route('pages.home') }}">Home</a></li>--}}
{{--                            <li><a href="{{ route('pages.products') }}">Products</a></li>--}}
{{--                            <li><a href="{{ route('pages.single_product') }}">Product Details</a></li>--}}
{{--                            <li><a href="{{ route('pages.checkout') }}">Checkout</a></li>--}}
{{--                        </ul>--}}
{{--                    </li>--}}
                </ul>
            </div>
            <!-- menu nav -->
        </div>
        <!-- message -->
        @if(session('msg'))
            <div class=" col-sm-8 alert alert-danger alert-dismissable">
                <button type="button" class="close " data-dismiss="alert" aria-hidden="true">&times;</button>
                <p align="center" ><marquee  behavior = "alternate" height="20px" width="450px"><strong >{{session('msg')}}!</strong></marquee></p>
            </div>
    @endif
    <!-- /message -->
    </div>
    <!-- /container -->
</div>
<!-- /NAVIGATION -->
