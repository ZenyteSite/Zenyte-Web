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
                        <h5 class="category-title">Vote for Zenyte</h5>
                        <p style="font-size:12px;">Every vote helps so please vote every 12 hours! You can claim your votes through the Vote Manager who is located north of Edgeville bank.<br> He has a variety of items that he'd love to exchange for your voting tickets.</p>
                        <div class="row" style="margin-top: 20px; margin-left: 10px;">
                            <h5 style="color: #c9aa71; font-size: 15px; font-style:italic; margin-top: 10px;">Did you know? You can claim your votes ingame by using ::claim or talking to the Wise Old Man in Edgeville!</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col s12">
                <hr>
                <div class="center-align" id="votebtns">
                    @foreach($sites as $site)
                        @if($site->mostRecentVote($forumUser->getName()) > Carbon\Carbon::now()->subDays(1)->toDateTimeString())
                            <span class="tooltipped" data-tooltip="{{ Carbon\CarbonInterval::seconds($site->getNextAvailableVoteTimeInSeconds($site->mostRecentVote($forumUser->getName())->voted_on))->cascade()->forHumans() }} until next vote" data-position="top">
                            <a target="_blank" class="btn tooltipped custom-btn skill-dropdown disabled" style="margin-bottom: 10px;" >{{ $site->title }}</a>
                            </span>
                        @else
                            <a href="{{ route('vote.proceedToVoteSite', $site->id) }}" target="_blank" class="btn custom-btn skill-dropdown " style="margin-bottom: 10px;">{{ $site->title }}</a>
                        @endif
                    @endforeach
                </div>
                <hr style="margin-top: 10px;">
                <div class="row">
                    <div class="col s12 xl4">
                        <div class="card">
                            <table class="striped">
                                <thead>
                                <tr>
                                    <th colspan="2" class="left mg-l-30" id="leaderboard-header">Vote Leaderboards ({{ date('M', time()) }})</th>
                                    <th class="desc-tag votm-switch" id="switch-mode">(View last month)</th>
                                </tr>
                                </thead>

                                @foreach($thisMonthLeaders as $thisMonthLeader)
                                <tr class="current-leaders">
                                    <td style="padding-left: 20px"><a href="https://zenyte.com/account/user/{{ $thisMonthLeader->username }}">{{ $thisMonthLeader->username }}</a></td>
                                    <td style="padding-right: 20px" class="right-align">{{ $thisMonthLeader->votecount }} Votes</td>
                                </tr>
                                @endforeach
                        </div>

                        @foreach($lastMonthLeaders as $lastMonthLeader)
                        <tr class="last-leaders" style="display: none">
                            <td style="padding-left: 20px"><a href="https://zenyte.com/account/user/{{$lastMonthLeader->username}}">{{ $lastMonthLeader->username }}</a></td>
                            <td style="padding-right: 20px" class="right-align">{{ $lastMonthLeader->votecount }} Votes</td>
                        </tr>
                        @endforeach
                    </div>

                    </table>
                </div>
            </div>
            <div class="col s12 xl4">
                <div class="card">
                    <div class="card-content center-align">
                        <h5>{{ $votesAllTime }}</h5>
                        <small>Total Votes</small>
                    </div>
                </div>
            </div>
            <div class="col s12 xl4">
                <div class="card">
                    <div class="card-content center-align">
                        <h5>{{ $votesThisMonth }}</h5>
                        <small>Votes for {{ date("F Y") }}</small>
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
    const monthNames = ["Jan", "Feb", "Mar", "Apr", "May", "June",
        "July", "Aug", "Sep", "Oct", "Nov", "Dec"
    ];

    const date = new Date();
    const currentMonth = monthNames[date.getMonth()];
    const lastMonth = date.getMonth() == 0 ? "Dec" : monthNames[date.getMonth()-1];

    var modeSwitch = $('#switch-mode');
    var leaderHeader = $('#leaderboard-header');
    var leaderDiv = $('.current-leaders');
    var lastLeaderDiv = $('.last-leaders');

    modeSwitch.on("click", function(e) {
        if(leaderDiv.css('display') === 'none') {
            console.log('hi');
            leaderHeader.html('Vote Leaderboards ('+currentMonth+')');
            modeSwitch.html("(View last month)");
            lastLeaderDiv.fadeOut();
            leaderDiv.fadeIn();
        } else {
            leaderHeader.html('Vote Leaderboards ('+lastMonth+')');
            modeSwitch.html("(View this month)");
            leaderDiv.fadeOut();
            lastLeaderDiv.fadeIn();
        }
    });
</script>
</body>
@include('layout.footer')
</html>