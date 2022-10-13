<div class="top-bar hide-on-med-only hide-on-small-only">
    <div class="container" style="width:100%;padding: 0 15px 0 15px;">
        <ul class="top-bar__links top-bar__links--left">
            <li class="top-bar__item"><a href="">About</a></li>
            <li class="top-bar__item"><a href="">Support</a></li>
            <li class="top-bar__item top-bar__item--secondary"><a href="">Play Now</a></li>
        </ul>
        <ul class="top-bar__links top-bar__links--right">
            {{--TODO: If logged in--}}
            @if($forumUser)
                <li class="top-bar__item"><a class="dropdown-button" data-activates="user-dropdown" href="javascript:void(0);"><i class="fal fa-caret-circle-down"></i>  {{ $forumUser->getName() }}</a></li>
                <div id="user-dropdown">
                <ul id="user-drop-links">
                <li class="li-title">Profile</li>
                <li><a href="{{ route('account') }}"><i class="fal fa-user left"></i>Account</a></li>
                <li class="li-title">Forum</li>
                <li><a href="{{ $forumUser->getProfileUrl() }}"><i class="fal fa-newspaper left"></i>Forum account</a></li>
                <li><a href="https://forums.zenyte.com/settings/"><i class="fal fa-cog left"></i>Settings</a></li>
                <li><a href="/logout"><i class="fal fa-sign-out left"></i>Log out</a></li>
                </ul>
                </div>
            @if($forumUser->isStaff())
                <li class="top-bar__item top-bar__item--secondary"><a href="#">Dashboard</a></li>
            @endif
            @else
            <li class="top-bar__item"><a href=""> Login </a></li>
            <li class="top-bar__item top-bar__item--secondary"><a href=''>Register</a></li>
            @endif
        </ul>
        <div class="clear-fix"></div>
    </div>
</div>