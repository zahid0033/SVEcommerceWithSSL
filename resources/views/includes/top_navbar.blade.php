<div class="top_nav navbar navbar-inverse" role="navigation">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{ route('website.home') }}"><img class="logo" style="width: 120px; height: 40px" src="{{ asset('assets/website/images/logo/nobinLogo.png') }}" alt="logo"/></a>
        </div>
        <div class="collapse navbar-collapse">
            <ul class="nav navbar-nav menus" style="padding: 12px 12px;text-align: center;width: 50%;margin-left: auto;margin-right: auto;">
                <li class=""><a href="{{  route('website.home')  }}">Home</a></li>
                <li class=""><a href="{{ route('website.about') }}">About us</a></li>
                <li class=""><a href="{{ route('pages.products') }}">Products</a></li>
                <li class=""><a href="{{ route('website.offers') }}">Offers</a></li>
                <li class=""><a href="{{ route('website.contact') }}">Contact Us</a></li>
            </ul>
        </div>
    </div>
</div>
