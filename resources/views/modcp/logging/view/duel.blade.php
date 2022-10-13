@include('layout.head')
<style>
    .item-box {
        background-image: url({{ asset('img/trade.png') }});
        background-repeat: no-repeat;
        width: 485px;
        height: 304px;
        margin: auto;
        margin-bottom: 20px;
    }
    .item-box .left-side, .item-box .right-side {
        margin-top: 25px;
        width: 165px;
        height: 250px;
    }
    .item-box .header {
        display: inline-block;
        margin-top: 5px;
        text-align:center;
        font-family: 'Runescape', sans-serif !important;
        width: 100%;
        font-size: 15px;
        color: #ECE638;
        text-shadow: 1px 1px 0 #000;
    }
    .item-box .left-side {
        float: left;
        margin-left:20px;
    }
    .item-box .right-side {
        float: right;
        margin-right:20px;
    }
    .item-box .item {
        float:left;
        width: 36px;
        height:32px;
        text-align: center;
        vertical-align:baseline;
        margin: 1px 5px 1px 0;
    }
    .item-box .item .item-amount {
        position: absolute;
        margin-top: -7px;
        color: #ECE638;
        font-family: 'Runescape', sans-serif !important;
        text-shadow: 1px 1px 1px #000;
        font-size: 15px;
        font-smooth: never;
        -webkit-font-smoothing : none;
    }
    .timestamp {
        font-family: 'Runescape', sans-serif !important;
        font-size: 15px;
        position: absolute;
        padding-top: 7px;
        width: 87px;
        height: 44px;
        text-align: center;
        margin-left: 199px;
        margin-top: 31px;
        line-height: 0.9em;
        color: #ECE638;
        text-shadow: 1px 1px 0 #000;
    }
    .item-box .item img {
        vertical-align:baseline;
    }
</style>
<body style="overflow-x:hidden;">
@include('layout.navigation.mobile-nav')
<div id="modal-wrapper">
    @include('layout.navigation.topbar')
    @include('layout.navigation.navbar')
    @include('layout.header-content')
</div>
<div class="content" id="main-content">
    <div class="container" style="width:95%;">
        <div class="row">
            <div class="col s12 xl12">
                <div class="card">
                    <div class="card-content">
                        <div class="row" style="margin: 0;">
                            <h5 class="left category-title">Mod Control Panel - Logs</h5>
                            @if($forumUser->isAdmin())
                                <a href="#" class="btn right custom-btn skill-dropdown">Go To Admin Dashboard <i class="material-icons right">dashboard</i></a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col s12 xl12">
                <div class="card">
                    <div class="card-content">
                        <div class="row" style="margin: 0;">
                            <h5 class="left category-title">Viewing Duel <span style="color:#F44336">(ID {{ $duel->id }})</span> between: <a href="{{ route('account', $duel->user) }}" style="color:#93B045">{{ $duel->user }}</a> and <a href="{{ route('account', $duel->opponent) }}" style="color:#93B045">{{ $duel->opponent }}</span></h5>
                            <a href="{{ route('modcp.logging') }}" class="custom-btn right btn skill-dropdown"><i class="fal fa-arrow-left left"></i> Back to logs</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            @include('layout.sidebar.modcp_sidebar')
            <div class="col s12 xl9">
                <div class="alert-success"><strong>Please Note</strong>: This page will soon be revamped to show the proper dueling interfaces as well as the rules & equipment used.</div>
                <div class="item-box">
                    <div class="header">
                        <a href="{{ route('account', $duel->user) }}">{{ $duel->user }}</a> dueling with
                        <a href="{{ route('account', $duel->opponent) }}">{{ $duel->opponent }}</a>
                    </div>

                    <div class="timestamp">
                        {{ Carbon\Carbon::parse($duel->time_added) }}
                    </div>

                    <div class="left-side">
                        @if($duel->user_staked_coins > 0)
                            <div class="item">
                                @if($duel->user_staked_coins == 1)
                                    <div class="item-amount"></div>
                                @elseif($duel->user_staked_coins > 99999 && $duel->user_staked_coins < 9999999)
                                    <div class="item-amount" style="color: white !important">{{ App\Models\ModCP\Tradelog::formatAmount($duel->user_staked_coins) }}</div>
                                @elseif($duel->user_staked_coins > 9999999)
                                    <div class="item-amount" style="color: #34e48b !important">{{ App\Models\ModCP\Tradelog::formatAmount($duel->user_staked_coins) }}</div>
                                @else
                                    <div class="item-amount">{{ $duel->user_staked_coins}}</div>
                                @endif
                                <img src="{{ asset('img/items/995.png') }}" class="tooltipped" data-position="top" data-tooltip="{{ number_format($duel->user_staked_coins) }} Coins">
                            </div>
                        @endif
                        @if($duel->user_staked_tokens > 0)
                            <div class="item">
                                @if($duel->user_staked_tokens == 1)
                                    <div class="item-amount"></div>
                                @elseif($duel->user_staked_tokens > 99999 && $duel->user_staked_tokens < 9999999)
                                    <div class="item-amount" style="color: white !important">{{ App\Models\ModCP\Tradelog::formatAmount($duel->user_staked_tokens) }}</div>
                                @elseif($duel->user_staked_tokens > 9999999)
                                    <div class="item-amount" style="color: #34e48b !important">{{ App\Models\ModCP\Tradelog::formatAmount($duel->user_staked_tokens) }}</div>
                                @else
                                    <div class="item-amount">{{ $duel->user_staked_tokens}}</div>
                                @endif
                                <img src="{{ asset('img/items/13204.png') }}" class="tooltipped" data-position="top" data-tooltip="{{ number_format($duel->user_staked_tokens) }} Platinum Tokens">
                            </div>
                        @endif
                    </div>

                    <div class="right-side">
                        @if($duel->opponent_staked_coins > 0)
                            <div class="item">
                                @if($duel->opponent_staked_coins == 1)
                                    <div class="item-amount"></div>
                                @elseif($duel->opponent_staked_coins > 99999 && $duel->opponent_staked_coins < 9999999)
                                    <div class="item-amount" style="color: white !important">{{ App\Models\ModCP\Tradelog::formatAmount($duel->opponent_staked_coins) }}</div>
                                @elseif($duel->opponent_staked_coins > 9999999)
                                    <div class="item-amount" style="color: #34e48b !important">{{ App\Models\ModCP\Tradelog::formatAmount($duel->opponent_staked_coins) }}</div>
                                @else
                                    <div class="item-amount">{{ $duel->opponent_staked_coins}}</div>
                                @endif
                                <img src="{{ asset('img/items/995.png') }}" class="tooltipped" data-position="top" data-tooltip="{{ number_format($duel->opponent_staked_coins) }} Coins">
                            </div>
                        @endif
                        @if($duel->opponent_staked_tokens > 0)
                            <div class="item">
                                @if($duel->opponent_staked_tokens == 1)
                                    <div class="item-amount"></div>
                                @elseif($duel->opponent_staked_tokens > 99999 && $duel->opponent_staked_tokens < 9999999)
                                    <div class="item-amount" style="color: white !important">{{ App\Models\ModCP\Tradelog::formatAmount($duel->opponent_staked_tokens) }}</div>
                                @elseif($duel->opponent_staked_tokens > 9999999)
                                    <div class="item-amount" style="color: #34e48b !important">{{ App\Models\ModCP\Tradelog::formatAmount($duel->opponent_staked_tokens) }}</div>
                                @else
                                    <div class="item-amount">{{ $duel->opponent_staked_tokens}}</div>
                                @endif
                                <img src="{{ asset('img/items/13204.png') }}" class="tooltipped" data-position="top" data-tooltip="{{ number_format($duel->opponent_staked_tokens) }} Platinum Tokens">
                            </div>
                        @endif
                    </div>

                </div>
                <div class="center-align">
                   @if($forumUser->isAdmin())
                    {{ $duel->user }}: <strong>{{ $duel->user_ip }}</strong>&nbsp;&nbsp;|&nbsp;&nbsp;{{ $duel->opponent }}: <strong>{{ $duel->opponent_ip }}</strong>
                    @endif

                    @if ($duel->user_ip === $duel->opponent_ip)
                    <div class="red-text">These users have the same IP Address, indicating that it's an alt or someone on the same network.</div>
                    @endif
                </div>
            </div>
        </div>

    </div>
</div>
</div>
</div>
@include('layout.scripts')
</body>
@include('layout.footer')
</html>