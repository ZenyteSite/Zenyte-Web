<div class="openbtn">
    <i class="fas fa-bars"></i>
</div>

<div class="mobile-logo" style="top: 15px">
    <a href="#">
            <img src="{{ asset('img/logo-nav.png') }}" style="width: 250px" class="img-fluid" />
        </a>
</div>

<div id="submenu">
    <div class="sub-left"></div>
    <div class="submenu"></div>
    <div class="sub-right"></div>
    <div class="submenu-content">
        <ul class="first">
            <li><a href="https://forums.zenyte.com">Forums</a></li>
            <li class="nav-spacer"><img src="{{ asset('img/divider.png') }}"></li>
            <li><a href="">Discord</a></li>
            <li class="nav-spacer"><img src="{{ asset('img/divider.png') }}"></li>
            <li><a href="">Market</a></li>
        </ul>

        <ul class="second">

            {{--TODO: Make the 25% dynamic by allowing us a specific holiday bonus %---}}
            <li><a href="">Store <span class="pal-blue">(+25%)</span></a></li>

            <li class="nav-spacer"><img src="{{ asset('img/divider.png') }}"></li>
            <li><a href="">Vote</a></li>
            <li class="nav-spacer"><img src="{{ asset('img/divider.png') }}"></li>
            <li><a href="">Hiscores</a></li>
        </ul>
        <div class="logo-newnav">
            <a href="https://zenyte.com">
                <img src="{{ asset('img/logo-nav.png') }}" class="img-fluid" />
            </a>
        </div>

    </div>
</div>
