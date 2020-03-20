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
                </ul>
            </div>
            <!-- menu nav -->
        </div>
    </div>
    <!-- /container -->
</div>
<!-- /NAVIGATION -->
