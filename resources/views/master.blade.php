<!DOCTYPE html>
<html lang="en">
    @include('includes.header_link')
    <body>
    <!-- Load Facebook SDK for JavaScript -->
    <div id="fb-root"></div>
    <script>
        window.fbAsyncInit = function() {
            FB.init({
                xfbml            : true,
                version          : 'v6.0'
            });
        };

        (function(d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s); js.id = id;
            js.src = 'https://connect.facebook.net/en_US/sdk/xfbml.customerchat.js';
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));</script>

    <!-- Your customer chat code -->
    <div class="fb-customerchat"
         attribution=setup_tool
         page_id="532726043884259"
         theme_color="#fc0000"
         logged_in_greeting="Welcome to Nobin Bangladesh."
         logged_out_greeting="Welcome to Nobin Bangladesh.">
    </div>
    <div id="loader" class="center"><img src="{{ asset('assets/img/icon/276.gif') }}" alt=""></div>
    @include('includes.top_navbar')
    @include('includes.top_bar')
    @include('includes.navbar')

    @yield('content')



    @include('includes.footer')
    @include('includes.footer_link')
    <script>
        document.onreadystatechange = function() {
            if (document.readyState !== "complete") {
                document.querySelector("#loader").style.visibility = "visible";
                document.querySelector("body").style.visibility = "hidden";
            } else {
                document.querySelector("#loader").style.display = "none";
                document.querySelector("body").style.visibility = "visible";
            }
        };
        $(document).ready(function () {
            $("#addCart").click(function () {
                var price = $(".product-price").text();
                var productName = $(".product-name").text();

                $("#cart_product_name").html(productName);
                $("#cart_product_price").html(price);
            });
            $("#cancel_cart").click(function () {
               $("#cart_div").remove();
            });
            $("#removeDiv").click(function () {
                $("#remove").remove();
                // $("#removeDiv").parent().remove();
            });



        });
    </script>
</body>

</html>
