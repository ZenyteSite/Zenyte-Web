<div class="col s12 xl3">
    <div class="card" style="padding: 0;">
        <div class="card-content center-align">
            <img src="{{ $forumUser->getAvatarUrl() }}" class="avatarimg">
            <h5 class="author_name">{{ $forumUser->getName() }}</h5>
            <hr>
            <h5 style="font-size: 14px; color: #7C6D5C !important">Rank: <span style="color: #c9aa71 !important;">{{ $forumUser->getRole()  }}</span></h5>
        </div>
        <div class="card-action center-align">
            <a href="{{ route('modcp') }}" class="menu-btn btn skill-dropdown"><i class="material-icons left">dashboard</i>Mod CP</a>
            <a href="#" class="menu-btn btn skill-dropdown"><i class="material-icons left">exit_to_app</i>Logout</a>
        </div>
        <div class="collection no-border">
            <div class="collection-item menu-cat-header"><span>Moderation</span></div>
            <a href="{{ route('modcp.punishments') }}" class="menu-btn btn skill-dropdown"><i class="fal fa-clipboard-list left"></i>Punishments</a>
            <a href="{{ route('modcp.logging') }}" class="menu-btn btn skill-dropdown"><i class="fal fa-search left"></i>Game Logs</a>
            <div class="collection-item menu-cat-header"><span>Tools</span></div>
            <a href="{{ route('modcp.osgp') }}" class="menu-btn btn skill-dropdown"><i class="fal fa-coins left"></i>OSRS GP Panel</a>
        </div>
    </div>
</div>