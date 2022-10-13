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
                        <h5 class="category-title left">Account information</h5>
                        <div class="row">
                            <form action="{{ route('account') }}" class="searchform right" method="POST">
                                @csrf
                                <div class="input-field">
                                    <input type="text" id="username" name="username" placeholder="Search by character name">
                                    <i class="material-icons hide-on-med-and-down">search</i>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            @if($isSameUser)
                @include('layout.sidebar.sameAccount')
            @else
                @include('layout.sidebar.viewAccount')
            @endif
            <div class="col s12 xl9 m6">
                <div class="card">
                    <div class="card-content">
                        <ul class="account-controls">
                            <li><a href="" id="gamelog-btn" class="btn right custom-btn skill-dropdown acc-tab-active"><i class="fal fa-gamepad"></i> Game activity</a></li>
                            <li><a href="" id="pvplog-btn" class="btn right custom-btn skill-dropdown"><i class="fal fa-swords"></i> PvP activity</a></li>
                        </ul>
                    </div>
                </div>
                <div id="game-activity">
                    @foreach($gameLogs as $gameLog)
                        <div class="card">
                            <div class="card-content">
                                <div class="adv-log-card">
                                    <img src="/img/adventure-icons/{{ $gameLog->icon }}">
                                    <p>{{ $gameLog->message }}</p>
                                    <p class="adv-log-date">{{ Carbon\Carbon::parse($gameLog->date)->format('F j, Y, g:i:a') }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div id="pvp-activity">
                    @foreach($pvpLogs as $pvpLog)
                        <div class="card">
                            <div class="card-content">
                                <div class="adv-log-card">
                                    <img src="/img/adventure-icons/{{ $pvpLog->icon }}">
                                    <p>{{ $pvpLog->message }}</p>
                                    <p class="adv-log-date">{{ Carbon\Carbon::parse($pvpLog->date)->format('F j, Y, g:i:a') }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="row">
                    <div class="col s6 xl6 m6">
                        <div class="card" style="padding: 0;">
                            <div class="collection pad-b-25">
                                <div class="collection-item center c9-color">{{ $player->getName() }}'s awards</div>
                                <div class="pad-t-25"></div>
                                <div id="account-awards">
{{--                                    TODO: Use https://api.zenyte.com/user/awards/corey --}}
{{--                                    https://forums.zenyte.com/uploads is the base img url, make that a config--}}
                                    @foreach($awards as $award)
                                        <div class="tooltipped award-icon" data-html="true" data-position="top"
                                             data-tooltip="{{ $award['title'] }}<br>{{ $award['reason'] }}<br>{{ Carbon\Carbon::createFromTimestamp($award['date'])->format('F j, Y, g:i a') }}">
                                            <img src="{{ config('forum.FORUM_ASSETS_LINK') . '/' . $award['icon']}}" title="" style="">
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col s6 xl6 m6">
                        <div class="card" style="padding: 0;">
                            <div class="collection">
                                <div class="collection-item center c9-color">{{ $player->getName() }}'s stats</div>
                                <div id="account-skills">
                                    {{--                            {% for res in result %}--}}
                                    {{--                            <div class="tooltipped account-skill" data-html="true" data-position="top" data-tooltip="Rank #{{ res.rank == 0 ? 1 : res.rank }} <br> {{ res.experience|number_format }} {{ res.skill_name|capitalize }} experience" >--}}
                                    {{--                                {% if res.skill_name === "total" %}--}}
                                    {{--                                {{ image('/img/skills/0.png', 'class' : 'skillicon-other') }}--}}
                                    {{--                                {% else %}--}}
                                    {{--                                {{ image('/img/skills/'~(loop.index0+1)~'.png', 'class' : 'skillicon-other') }}--}}
                                    {{--                                {% endif %}--}}
                                    {{--                                <p class="account-skill-level">{{ res.level }}</p>--}}
                                    {{--                            </div>--}}
                                    {{--                            {% endfor %}--}}
                                    <div class="tooltipped account-skill" data-html="true" data-position="top" data-tooltip="Rank #<br> experience">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>
@include('layout.scripts')
<script src="{{ asset('js/adventurers-log.js') }}"></script>
</body>
@include('layout.footer')
</html>