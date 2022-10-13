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
            <div class="col s12 xl12">
                <div class="card">
                    <div class="card-content">
                        <div class="row" style="margin: 0;">
                            <h5 class="left category-title">Admin Control Panel</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            @include('layout.sidebar.admincp_sidebar')
            <div class="col s12 xl9">
                @if(Session::get('success'))
                    <div class="alert-success">
                        {{ Session::get('success') }}
                    </div>
                @endif
                @if($forumUser->isOwner())
                    <div class="card center" style="width: 24%; padding: 10px; display: inline-block">
                        <span class="pal-gold">Total PayPal This Month:</span><br>
                        <span class="pal-bgreen" style="font-size: 16px">${{ number_format($totalPaypalThisMonth) }}</span>
                    </div>
                    <div class="card center" style="width: 24%; padding: 10px; display: inline-block">
                        <span class="pal-gold">Total Paypal All Time:</span><br>
                        <span class="pal-bgreen" style="font-size: 16px">${{ number_format($totalPaypal) }}</span>
                    </div>
                    <div class="card center" style="width: 24%; padding: 10px; display: inline-block">
                        <span class="pal-gold">Total Crypto This Month:</span><br>
                        <span class="pal-bgreen" style="font-size: 16px">${{ number_format($totalCoinbaseThisMonth) }}</span>
                    </div>
                    <div class="card center" style="width: 24%; padding: 10px; display: inline-block">
                        <span class="pal-gold">Total Crypto All Time:</span><br>
                        <span class="pal-bgreen" style="font-size: 16px">${{ number_format($totalCoinbase) }}</span>
                    </div>
                @endif
                <div class="card center" style="width: 24%; padding: 10px; display: inline-block">
                    <span class="pal-gold">Total Votes This Month:</span><br>
                    <span class="pal-bgreen" style="font-size: 16px">{{ number_format($totalVotesThisMonth) }}</span>
                </div>
                <div class="card center" style="width: 24%; padding: 10px; display: inline-block">
                    <span class="pal-gold">Total Votes All Time:</span><br>
                    <span class="pal-bgreen" style="font-size: 16px">{{ number_format($totalVotesAllTime) }}</span>
                </div>
                <div class="card center" style="width: 24%; padding: 10px; display: inline-block">
                    <span class="pal-gold">Total OSGP This Month:</span><br>
                    <span class="pal-bgreen" style="font-size: 16px">${{ number_format($totalOSGPThisMonth) }}</span>
                </div>
                <div class="card center" style="width: 24%; padding: 10px; display: inline-block">
                    <span class="pal-gold">Total OSGP All Time:</span><br>
                    <span class="pal-bgreen" style="font-size: 16px">${{ number_format($totalOSGP) }}</span>
                </div>
                <div style="display:flex;">
                    <a class='dropdown-button btn skill-dropdown right' href='#' data-activates='dropdown3'>
                        Graph Selection
                        <i class="material-icons right">menu</i>
                    </a>
                    <ul id='dropdown3' class='dropdown-content'>
                        <li>
                            <a href="#" id="paymentGraphSelection">Payment Graphs</a>
                            <a href="#" id="voteGraphSelection">Vote Graphs</a>
                        </li>
                    </ul>
                </div>
                <div id="paymentGraphs">
                    <div class="card center">
                        <h5 class="pal-gold">Payments Last 30 Days</h5>
                        {!! $last30DaysChart->renderHtml() !!}
                    </div>
                    <div class="card center">
                        <h5 class="pal-gold">Payments This Month</h5>
                        {!! $thisMonthChart->renderHtml() !!}
                    </div>
                    <div class="card center">
                        <h5 class="pal-gold">All Time Transactions Per Month</h5>
                        {!! $allPaymentsOverTime->renderHtml() !!}
                    </div>
                    <div class="card center" style="width: 33%; padding: 10px; display: inline-block">
                        <h5 class="pal-gold">Most Used Currencies All Time</h5>
                        {!! $mostUsedCurrencies->renderHtml() !!}
                    </div>
                    <div class="card center" style="width: 33%; padding: 10px; display: inline-block">
                        <h5 class="pal-gold">Most Used Currencies Last 90 Days</h5>
                        {!! $mostUsedCurrenciesThreeMonth->renderHtml() !!}
                    </div>
                    <div class="card center" style="width: 33%; padding: 10px; display: inline-block">
                        <h5 class="pal-gold">Most Used Currencies This Month</h5>
                        {!! $mostUsedCurrenciesThisMonth->renderHtml() !!}
                    </div>
                </div>
                <div id="voteGraphs" style="display:none;">
                    <div class="card center">
                        <h5 class="pal-gold">All Votes Over Time</h5>
                        {!! $allVotesOverTime->renderHtml() !!}
                    </div>
                    <div class="card center">
                        <h5 class="pal-gold">Votes Last 30 Days</h5>
                        {!! $last30DaysVotes->renderHtml() !!}
                    </div>
                    <div class="card center">
                        <h5 class="pal-gold">Votes This Month</h5>
                        {!! $thisMonthVotes->renderHtml() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>
@include('layout.scripts')
<script>
    $(function () {
        $('#paymentGraphSelection').on('click', function(event) {
            event.preventDefault();
            $('#paymentGraphs').css('display', 'block');
            $('#voteGraphs').css('display', 'none');
        });
        $('#voteGraphSelection').on('click', function(event) {
            event.preventDefault();
            $('#paymentGraphs').css('display', 'none');
            $('#voteGraphs').css('display', 'block');
        });
    });
</script>
{!! $last30DaysChart->renderChartJsLibrary() !!}

{!! $last30DaysChart->renderJs() !!}
{!! $thisMonthChart->renderJs() !!}
{!! $mostUsedCurrencies->renderJs() !!}
{!! $mostUsedCurrenciesThreeMonth->renderJs() !!}
{!! $mostUsedCurrenciesThisMonth->renderJs() !!}
{!! $allPaymentsOverTime->renderJs() !!}
{!! $allVotesOverTime->renderJs() !!}
{!! $last30DaysVotes->renderJs() !!}
{!! $thisMonthVotes->renderJs() !!}
</body>
@include('layout.footer')
</html>