<header class="header black-bg">
    <div class="sidebar-toggle-box">
        <div class="fa fa-bars tooltips" data-placement="right" data-original-title="Toggle Navigation"></div>
    </div>
    <!--logo start-->
    <a href="{{ route('nvdashboard') }}" class="logo"><b>nobin bangladesh (Beta) </b> <img width="40px" src="{{ asset('assets/img/icon/home.gif') }}" alt=""></a>
    <!--logo end-->
    <div class="nav notify-row" id="top_menu">

    </div>
    <div class="top-menu">
        <ul class="nav pull-right top-menu">
            <li><img width="120px" src="{{ asset('assets/img/icon/276.gif') }}" alt=""></li>
        </ul>
        <ul class="nav pull-right top-menu">
            <li>
                <a class="dropdown-item" href="{{ route('logout') }}"
                   onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">

                    <button class="btn btn-danger" >Logout</button>
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </li>
        </ul>
    </div>
</header>
