@include('layout.head')

<script src="https://cdn.jsdelivr.net/bxslider/4.2.12/jquery.bxslider.min.js"></script>
<script>
    $(document).ready(function () {
        let slider = $('.slider');

        slider.show();
        slider.bxSlider({
            'mode': 'fade',
            'touchEnabled': false,
            'auto': true,
            'pause': 5000,
            'preloadImages': 'all',
            'easing': 'ease-in-out',
            'stopAutoOnClick': true
        });
    });
</script>
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
                            <h5 class="left category-title">Welcome to Zenyte!</h5>
                            <a href="" class="btn custom-btn play-button right pulse">Play Now</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col s12 m12 l9">
                <ul class="collapsible" data-collapsible="accordion" style="box-shadow: none;">
                    @foreach($threads as $thread)
                        <li style="margin-bottom:10px;background-color: #171412;">
                            <div class="collapsible-header {{ $loop->first ? 'active' : '' }}">
                                <i class="far fa-comment-alt"></i>
                                <span style="color:#c9aa71;">{{ $thread['title'] }}</span>
                                <span class="badge right">
                        <small>
                            {{ Carbon\Carbon::parse($thread['start_date'])->format('M. d, Y') }} by
                            <a href="{{ config('forum.FORUM_LINK') . 'profile/' . $thread['starter_id'] .'-' . $thread['seo_name'] }}">{{ $thread['firstPost']['author_name'] }}</a>
                        </small>
                    </span>
                            </div>
                            <div class="collapsible-body discordblock news-text" id="newsblock" style="max-height:500px;">
                                <a class="right g-link" href="{{ config('forum.FORUM_LINK') . '/topic/' . $thread['tid'] . '-' . $thread['title_seo'] }}"><i class="fal fa-eye"></i> READ ON FORUMS</a>
                                {!! $thread['post_body'] !!}
                                <div id="post-images" style="display:none">

                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
                <div class="row">
                    <div class="col s12 m12 l9">

                    </div>
                </div>
            </div>
            <div class="col s12 m12 l3">
                <div id="players">
                    <div id="status">
                        <div class="loading">
                            <div class="loading-inner">
                                <img src="/img/divider.png">
                                <h5>Loading</h5>
                                <small>Please wait...</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="discord">
                    <div class="card" style="padding: 0;">
                        <div class="card-content" style="padding-bottom: 15px;padding-top:20px;">
                            <span class="badge right transparent grey-text text-darken-1" style="font-size:12px"><span id="memberCount">{{ $discordCount }}</span> Members</span>
                            <h5 style="font-size:20px;">
                                Zenyte Discord
                            </h5>
                        </div>
                        <div class="card-content discordblock">
                            <hr>
                            <div class="channel-header">
                                <strong>Members Only</strong>
                            </div>
                            <div id="discordMembers">
                            </div>
                        </div>
                        <div class="card-action center-align">
                            <a href="https://zenyte.com/discord" class="btn custom-btn skill-dropdown" target="_blank">Join Server</a>
                        </div>
                </div>
                @include('layout.sidebar.video')
            </div>
        </div>
    </div>
</div>
<div id="modal1" class="modal" style="box-shadow: none; width: auto; max-height: 80%">
    <div class="modal-content center-align" id="image-modal" style="background: transparent;"></div>
</div>
@include('layout.scripts')
<script>
    $(function () {
        getPlayerCount();
        getDiscordInformation();
        function updatePlayersBlock(data) {
            if (data !== null) {
                var content = '';
                $.each(data, function (index, server) {
                    content += `
                    <div class="card status online">
                        <div class="card-content">
                            <div class="left status-container">
                                <div class="green darken-3 btn-floating pulse indicator"></div>
                            </div>
                            <div class="right center-align players-online">
                                <h6 class="green-text text-darken-3">${server['count']}</h6>
                                <small>Players</small>
                            </div>
                            <div class="players-online">
                                <h6 class="green-text text-darken-3">World ${server['worldNumber']}</h6>
                                <small>${server['worldName']}</small>
                            </div>
                        </div>
                    </div>`
                });
                $('#players').html(content);
            }
        }
        function getPlayerCount() {
            $.post("{{ route('api.home.status') }}").done(function (data) {
                updatePlayersBlock(data);
            });
        }
        window.setInterval(function () {
            getPlayerCount();
        }, 15000);

        function updateDiscordBlock(data) {
            if (data !== null) {
                var content = '';
                $.each(data['members'], function(index, member) {
                    var gameString = ``;
                    if(typeof member['game'] !== 'undefined') {
                        var maxStringLength = 15;
                        var gameName = member['game']['name'];
                        var game = (gameName.length > maxStringLength) ? gameName.substr(0, maxStringLength) + '&hellip;' : gameName;
                        gameString = `<br><span class="status"><small>Playing ${game}</small></span>`;
                    }
                    content += `
                        <div class="duser">
                            <div class="discord_avatar ${member['status']} left">
                                <img src="${member['avatar_url']}">
                            </div>
                            ${member['username']}`;
                    if(typeof member['game'] !== 'undefined') {
                        content += gameString;
                    }
                        content += `</div>`;
                });
                $('#discordMembers').html(content);
            }
        }
        function getDiscordInformation() {
            $.post("{{ route('api.home.discord') }}").done(function (data) {
                updateDiscordBlock(data);
            });
        }
        window.setInterval(function () {
            getDiscordInformation();
        }, 15000);
    });
</script>
</body>
@include('layout.footer')
</html>