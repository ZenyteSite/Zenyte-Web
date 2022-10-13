@include('layout.head')

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
            <div class="col s12">
                <div class="card">
                    <div class="card-content">
                        <div class="row" style="margin: 0;">
                            <h5 class="category-title" style="text-align: center; margin-bottom: 15px !important;">Zenyte public market</h5>
                            <div class="row">
                                <h5 style="color: #00BDF5 !important; font-size: 15px; font-style:italic; text-align: center; margin-bottom: 15px !important;">Search any item in Zenyte by-name to find out what it's been traded for!</h5>
                            </div>
                            <div class="input-field">
                                <input type="text" id="item" name="item" class="left" placeholder="Type an item name here" autocomplete="off">
                            </div>
                        </div>
                    </div>
                </div>

                <div id="status" style="display: none">
                    <div class="loading-med">
                        <div class="loading-inner">
                            <img src="{{ asset('img/divider.png') }}">
                            <h5>Loading</h5>
                            <small>Please wait...</small>
                        </div>
                    </div>
                </div>

                <ul class="collection" id="ptrades">
                    @foreach($tradeLogs as $tradeLog)
                        <li class="collection-item trade-collection">
                            @if($forumUser->isStaff())
                                <span class="right">
                            <a href="#" target="_blank">View Trade</a>
                        </span>
                            @endif
                            <hr>
                            <span style="color: #c9aa71">Given:</span>
                            <div class="ptrade-items">
                                @foreach(json_decode($tradeLog->given) as $given)
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
                                        <img src="{{ asset('img/items')  . '/' . $given->id}}.png" class="tooltipped" data-position="top" data-tooltip="{{ number_format($given->amount) }} {{ $given->name }}">
                                    </div>
                                @endforeach
                            </div>
                            <hr>

                            <div class="mg-b-10"></div>

                            <span style="color: #c9aa71">Received:</span>
                            <div class="ptrade-items">
                                @foreach(json_decode($tradeLog->received) as $received)
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
                                        <img src="{{ asset('img/items')  . '/' . $received->id}}.png" class="tooltipped" data-position="top" data-tooltip="{{ number_format($received->amount) }} {{ $received->name }}">
                                    </div>
                                @endforeach
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>
</div>
</div>
@include('layout.scripts')
<script src="{{ asset('js/helpers.js') }}"></script>
<script>
    var loadingArea = $('#status');
    var contentArea = $('#ptrades');
    var searchField = $('#item');
    var timer = null;

    function startLoading() {
        contentArea.fadeOut(100, function () {
            loadingArea.fadeIn(100);
        });
    }

    //TODO: We're sending it as json, make sure we can decode it properly to return the right response here
    function finishLoading(data) {
        contentArea.html(renderTrade(data));
        loadingArea.fadeOut(300, function () {
            contentArea.fadeIn(200);
        });
    }

    function renderTrade(data) {
        var content = '';
        $.each(data, function (index, trade) {
            content += `<li class="collection-item trade-collection">`;
            @if($forumUser->isStaff())
                    {{--                    TODO: Use trade.id here--}}
                content += `<span class="right"><a href="" target="_blank">View Trade</a></span>`;
            @endif
                content += `
                <hr>
                <span style="color: #c9aa71">Given:</span>
                 <div class="ptrade-items">`;
            $.each(JSON.parse(trade['given']), function (index, given) {
                content += `<div class="item">`
                if (given['amount'] == 1) {
                    content += `<div class="item-amount"></div>`;
                } else if (given['amount'] > 99999 && given['amount'] < 9999999) {
                    content += `<div class="item-amount" style="color: white !important">${formatRsAmount(given['amount'])}</div>`;
                } else if (given['amount'] > 9999999) {
                    content += ` <div class="item-amount" style="color: #34e48b !important">${formatRsAmount(given['amount'])}</div>`;
                } else {
                    content += `<div class="item-amount">${given['amount']}</div>`;
                }
                content += `<img src="{{ asset('img/items') }}/${given['id']}.png" class="tooltipped" data-position="top" data-tooltip="${given['amount']} ${given['name']}">
                            </div>`;
            });
            content += `</div>
                           <hr>
                           <div class="mg-b-10"></div>
                    <span style="color: #c9aa71">Received:</span>
            <div class="ptrade-items">`;
            $.each(JSON.parse(trade['received']), function (index, received) {
                content += `<div class="item">`
                if (received['amount'] == 1) {
                    content += `<div class="item-amount"></div>`;
                } else if (received['amount'] > 99999 && received['amount'] < 9999999) {
                    content += `<div class="item-amount" style="color: white !important">${formatRsAmount(received['amount'])}</div>`;
                } else if (received['amount'] > 9999999) {
                    content += ` <div class="item-amount" style="color: #34e48b !important">${formatRsAmount(received['amount'])}</div>`;
                } else {
                    content += `<div class="item-amount">${received['amount']}</div>`;
                }
                content += `<img src="{{ asset('img/items') }}/${received['id']}.png" class="tooltipped" data-position="top" data-tooltip="${received['amount']} ${received['name']}">
                            </div>`;
            });
            content += `</div>
                            </li>`;
        });
        return content;
    }

    searchField.on('keydown', function () {
        startLoading();
    });

    searchField.on('keyup', function () {
        var input = searchField.val();

        if (timer != null) {
            clearTimeout(timer);
            timer = null;
        }

        timer = setTimeout(function () {
            if (input == '') {
                $.post('{{ route('api.market') }}').done(function (data) {
                    finishLoading(data);
                });
            } else {
                if (input.length == 1) {
                    return;
                }

                $.post('{{ route('api.market') }}', {itemSearch: input}).done(function (data) {
                    finishLoading(data);
                });
            }
        }, 700);
    });

</script>
</body>
@include('layout.footer')
</html>