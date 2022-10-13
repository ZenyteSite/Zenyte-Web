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
                            <h5 class="left category-title">Mod Control Panel</h5>
                        @if($forumUser->isAdmin())
                                <a href="#" class="btn right custom-btn skill-dropdown">Go To Admin Dashboard <i class="material-icons right">dashboard</i></a>
                                @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            @include('layout.sidebar.modcp_sidebar')
            <div class="col s12 xl9">
                <h5>Your Recently Given Punishments</h5>
            @forelse($recentPunishments as $punishment)
                        <div class="card">
                            <div class="card-content" id="punish-log">
                                <div class="row" style="padding: 15px">
                                    <div class="left">
                                        <h6 class="pal-gold">Offender</h6>
                                        <p style="color:#00BDF5">{{ $punishment->offender }}</p>
                                        <div class="mg-b-4"></div>
                                    </div>
                                    <div class="right">
                                        <h6 class="pal-gold right">Punished on</h6><br>
                                        <p style="color:#00BDF5" class="right">2020-08-22 22:26:21</p><br>
                                        <div class="mg-b-4"></div>
                                    </div>
                                </div>
                                <div class="row center-align" style="margin-top: 15px">
                                    <h6 class="pal-gold">Reason</h6>
                                    <p style="color:#00BDF5">{{ $punishment->reason }}</p>
                                </div>
                                <div class="row center-align" style="margin-top: 15px">
                                    <a class="btn custom-btn skill-dropdown" style="width:350px" href="{{ route('modcp.punishments.view', $punishment->id) }}">
                                        View Punishment & Proof
                                    </a>
                                </div>
                            </div>
                        </div>
                @empty
                <h6>Looks like you've got no recently given punishments!</h6>
                @endforelse
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