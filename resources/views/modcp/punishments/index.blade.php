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
                            <h5 class="left category-title">Mod Control Panel - Punishments</h5>
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
                            <form class="searchform left" method="POST" action="{{ route('modcp.punishments') }}">
                                @csrf
                                <div class="input-field">
                                    <input type="text" name="search_input" placeholder="Search by username, ip, or mac address">
                                    <i class="material-icons hide-on-med-and-down">search</i>
                                </div>
                            </form>

                            <a class='dropdown-button btn skill-dropdown right' href='#' data-activates='dropdown3'>
                                Action Filters
                                <i class="material-icons right">menu</i>
                            </a>
                            <ul id='dropdown3' class='dropdown-content'>
                                @foreach(config('modcp.punishment_filters') as $filter)
                                    <li>
                                        <a href="{{ request()->fullUrlWithQuery(['filter' => $filter]) }}">{{ ucwords($filter) }}</a>
                                    </li>
                                @endforeach
                            </ul>
                            @if(Request::has('filter'))
                                <a class="btn skill-dropdown right" style="margin-right: 15px;" href="{{ route('modcp.punishments') }}"><i class="fal fa-backspace"></i> Back to punishments</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            @include('layout.sidebar.modcp_sidebar')
            <div class="col s12 xl9">
                <div class="card">
                    <table class="striped responsive-table">
                        <thead>
                        <tr>
                            <th class="center-align">Moderator</th>
                            <th class="center-align">Offender</th>
                            <th class="center-align">IP Address</th>
                            <th class="center-align">Mac Address</th>
                            <th class="center-align">Action Type</th>
                            <th class="center-align">Expires</th>
                            <th class="center-align">Date</th>
                            <th class="center-align"></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($punishments as $punishment)
                            <tr class="tooltipped" data-position="bottom" data-delay="10" data-tooltip="{{ $punishment->reason }}">
                                <td class="center-align">{{ $punishment->mod_name }}</td>
                                <td class="center-align"><a class="pal-blue" href="#">{{ $punishment->offender }}</a></td>
                                <td class="center-align">{{ $punishment->ip_address }}</td>
                                <td class="center-align">{{ $punishment->mac_address }}</td>
                                <td class="center-align">{{ ucwords($punishment->action_type) }}</td>
                                <td class="center-align">{{ ($punishment->expires == 'Never') ? 'Never' : Carbon\Carbon::parse($punishment->expires)->format('M. d, Y') }}</td>
                                <td class="center-align">{{ Carbon\Carbon::parse($punishment->punished_on)->format('F j, Y, g:i:a') }}</td>
                                <td class="center-align"><a style="color:#c9aa71; cursor: pointer;" href="{{ route('modcp.punishments.view', $punishment->id) }}">View</a></td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                {{ $punishments->links() }}
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