<aside>
    <div id="sidebar"  class="nav-collapse ">
        <!-- sidebar menu start-->
        <ul class="sidebar-menu" id="nav-accordion">
            <p class="centered"><a href="profile.html"><img style="background: white;" src="{{asset('assets/vendor/images/brands/logo.jpg')}}" class="img-circle" width="60"></a></p>
            <h5 class="centered">{{ Auth::user()->name }}</h5>
            <li class="sub-menu">
                <a class="@yield('DashBoard')" href="{{route('installment.index')}}" >
                    <i class="fa fa-home"></i>
                    <span>DashBoar</span>
                </a>
            </li>
            <li class="sub-menu">
                <a class="@yield('Product_Management')" href="{{route('installment.products')}}" >
                    <i class="fas fa-store"></i>
                    <span>Products</span>
                </a>
            </li>
            <li class="sub-menu">
                <a class="@yield('Order_management')" >
                    <i class="fab fa-accusoft"></i>
                    <span>Order</span>
                </a>
                <ul class="sub" style="display: none;">
{{--                    <li class="@yield('makeOrder')" ><a  href=""><i class="fas fa-network-wired"></i> Create Order</a></li>--}}
                    <li class="@yield('RunningOrder')" ><a  href="{{ route('installment.runningOrders') }}"><i class="fas fa-truck-loading"></i>Running Orders</a></li>
{{--                    <li class="@yield('Defaulters')" ><a  href="{{ route('installment.defaulters') }}"><i class="fas fa-ban"></i>Defaulters</a></li>--}}
                </ul>
            </li>
            <li class="sub-menu">
                <a class="@yield('Defaulters')" href="{{route('installment.defaulters')}}" >
                    <i class="fas fa-list-ul"></i>
                    <span>Defaulters </span>
                </a>
            </li>
            <li class="sub-menu">
                <a class="@yield('Customer_management')" >
                    <i class="fab fa-accusoft"></i>
                    <span>Customers</span>
                </a>
                <ul class="sub" style="display: none;">
                    <li class="@yield('customerList')" ><a  href="{{ route('installment.customers') }}"><i class="fas fa-network-wired"></i> Customer List </a></li>
                    <li class="@yield('addCustomer')" ><a  href="{{ route('installment.addCustomer') }}"><i class="fas fa-truck-loading"></i>Create Customer</a></li>
                    {{--                    <li class="@yield('Defaulters')" ><a  href="{{ route('installment.defaulters') }}"><i class="fas fa-ban"></i>Defaulters</a></li>--}}
                </ul>
            </li>
            <li class="sub-menu">
                <a class="@yield('Accounts')" href="{{route('installment.accounts')}}" >
                    <i class="fas fa-list-ul"></i>
                    <span>Accounts </span>
                </a>
            </li>


        </ul>
        <!-- sidebar menu end-->`
    </div>
</aside>
