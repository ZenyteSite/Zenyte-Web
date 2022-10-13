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
            <div class="col s12">
                <div class="card">
                    <div class="card-content">
                        <div class="row" style="margin: 0;">
                            <form class="searchform left" method="POST" action="{{ route('modcp.logging', ['type' => $action]) }}">
                                @csrf
                                <div class="input-field">
                                    <input type="text" name="search_input" placeholder="Search {{ lcfirst($action) }}'s by username, ip, or mac address">
                                    <i class="material-icons hide-on-med-and-down">search</i>
                                </div>
                            </form>

                            <a class='dropdown-button btn skill-dropdown right' href='#' data-activates='dropdown3'>
                               Log Type
                                <i class="material-icons right">menu</i>
                            </a>
                            <ul id='dropdown3' class='dropdown-content'>
                                    <li>
                                        <a href="{{ route('modcp.logging', ['type' => 'trade']) }}">Trade</a>
                                    </li>
                                <li>
                                    <a href="{{ route('modcp.logging', ['type' => 'duel']) }}">Duel</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            @include('layout.sidebar.modcp_sidebar')
            <div class="col s12 xl9">
                <div class="card">
                    <div class="card-content">
                        <ul class="collection">
                    @foreach($logs as $log)
                        <li class="collection-item trade-collection">
                            [<strong>{{ Carbon\Carbon::parse($log->time_added)->format('F j, Y, g:i:a') }}</strong>]
                            <a href="https://zenyte.com/account/{{ $log->user }}">{{ $log->user }}</a> made a {{ $action }} with
                            @if($action === 'Duel')
                                <a href="https://zenyte.com/account/{{ $log->opponent }}">{{ $log->opponent }}</a>
                            @elseif($action === 'Trade')
                                <a href="https://zenyte.com/account/{{ $log->partner }}">{{ $log->partner }}</a>
                            @endif
                            <span class="right"><a href="{{ route('modcp.logging.view', [ $log->id, 'type' => $action]) }}" target="_blank">View {{ $action }}</a></span>
                            <hr>
                            <span style="color: #c9aa71">Given:</span>
                            @if($action == 'Duel')
                                @include('modcp.logging.templates.indexDuelGiven')
                            @elseif($action == 'Trade')
                                @include('modcp.logging.templates.indexTradeGiven')
                            @endif
                            <hr>
                            <span style="color: #c9aa71">Received:</span>
                            @if($action == 'Duel')
                                @include('modcp.logging.templates.indexDuelReceived')
                            @elseif($action == 'Trade')
                                @include('modcp.logging.templates.indexTradeReceived')
                            @endif
                        </li>
                        @endforeach
                        </ul>
                    </div>
                    </div>
                {{ $logs->links() }}
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