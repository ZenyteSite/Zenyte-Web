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
                            <h5 class="left category-title">Viewing Trade <span style="color:#F44336">(ID {{ $trade->id }})</span> between: <a href="{{ route('account', $trade->user) }}" style="color:#93B045">{{ $trade->user }}</a> and <a href="{{ route('account', $trade->partner) }}" style="color:#93B045">{{ $trade->partner }}</span></h5>
                            <a href="{{ route('modcp.logging') }}" class="custom-btn right btn skill-dropdown"><i class="fal fa-arrow-left left"></i> Back to logs</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            @include('layout.sidebar.modcp_sidebar')
            <div class="col s12 xl9">
                <div class="center-align">Hover an item to see the name and exact amount</div>

                <div class="item-box">
                    <div class="header">
                        <a href="{{ route('account', $trade->user) }}">{{ $trade->user }}</a> trading with
                        <a href="{{ route('account', $trade->partner) }}">{{ $trade->partner }}</a>
                    </div>

                    <div class="timestamp">
                       {{ Carbon\Carbon::parse($trade->time_added)->format('F j, Y, g:i:a') }}
                    </div>

                    <div class="left-side">
                        @if($trade->given == '[]')
                            <span>Nothing Given</span>
                        @else
                                @foreach(json_decode($trade->given) as $given)
                                    <div class="item">
                                        @if($given->amount == 1)
                                            <div class="item-amount"></div>
                                        @elseif($given->amount > 99999 && $given->amount < 9999999)
                                            <div class="item-amount" style="color: white !important">{{ App\Models\ModCP\Tradelog::formatAmount($given->amount) }}</div>
                                        @elseif($given->amount > 9999999)
                                            <div class="item-amount" style="color: #34e48b !important">{{ App\Models\ModCP\Tradelog::formatAmount($given->amount) }}</div>
                                        @else
                                            <div class="item-amount">{{ $given->amount}}</div>
                                        @endif
                                        <img src="{{ asset('img/items')  . '/' . $given->id}}.png" class="tooltipped" data-position="top" data-tooltip="{{ number_format($given->amount) }} {{ $given->name }} | ID: {{ $given->id }}">
                                    </div>
                                @endforeach
                        @endif
                    </div>

                    <div class="right-side">
                        @if($trade->received == '[]')
                            <span>Nothing Given</span>
                        @else
                                @foreach(json_decode($trade->received) as $received)
                                    <div class="item">
                                        @if($received->amount == 1)
                                            <div class="item-amount"></div>
                                        @elseif($received->amount > 99999 && $received->amount < 9999999)
                                            <div class="item-amount" style="color: white !important">{{ App\Models\ModCP\Tradelog::formatAmount($received->amount) }}</div>
                                        @elseif($received->amount > 9999999)
                                            <div class="item-amount" style="color: #34e48b !important">{{ App\Models\ModCP\Tradelog::formatAmount($received->amount) }}</div>
                                        @else
                                            <div class="item-amount">{{ $received->amount}}</div>
                                        @endif
                                        <img src="{{ asset('img/items')  . '/' . $received->id }}.png" class="tooltipped" data-position="top" data-tooltip="{{ number_format($received->amount) }} {{ $received->name }} | ID: {{ $received->id }}">
                                    </div>
                                @endforeach
                        @endif
                    </div>
                </div>
                <div class="center-align">
                    @if($forumUser->isAdmin())
                        {{ $trade->user }}: <strong>{{ $trade->user_ip }}</strong>&nbsp;&nbsp;|&nbsp;&nbsp;{{ $trade->partner }}: <strong>{{ $trade->partner_ip }}</strong>
                    @endif

                    @if ($trade->user_ip === $trade->partner_ip)
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