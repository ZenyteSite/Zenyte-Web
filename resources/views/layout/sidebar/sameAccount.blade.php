@if($player)
<div class="col s12 m6 xl3">
    <div class="card" style="padding: 0;">
        <div class="card-content center-align" style="padding: 20px 25px;">
            <img src="{{ $player->getAvatarUrl() }}" class="avatarimg">
            <h5 class="author_name">{{ $player->getName() }}</h5>
            <a href="#" class="btn menu-btn skill-dropdown"><i class="material-icons left"></i>Sign Out</a>
            <hr style="margin: 10px 0 !important; border: 1px solid #7c6a5d">
            <h5 style="font-size: 14px; color: #7C6D5C !important">Rank: <span style="color: #c9aa71 !important;">{{ $player->getRole() }}</span></h5>
            <h5 style="font-size: 14px; color: #7C6D5C !important">Posts: <span style="color: #c9aa71 !important;">{{ $player->getPostcount() }}</span></h5>
            <h5 style="font-size: 14px; color: #7C6D5C !important">Joined: <span style="color: #c9aa71 !important;"> {{ $player->getJoined()->format('m/d/y') }}</span></h5>
        </div>
        @if($player->isStaff())
        <div class="collection no-border">
            <div class="collection-item menu-cat-header"><span>Staff nav</span></div>

            @if($player->isAdmin())
                <a href="#" class="menu-btn btn skill-dropdown"><i class="material-icons left"></i>Admin CP</a>
            @endif
            <a href="#" class="menu-btn btn skill-dropdown"><i class="material-icons left"></i>Mod CP</a>
        </div>
        @endif
        <div class="collection no-border">
            <div class="collection-item menu-cat-header"><span>Website settings</span></div>
            <a href="{{ route('account') }}" class="menu-btn btn skill-dropdown"><i class="material-icons left"></i>Account</a>
            <a href="{{ $player->getProfileUrl() }}" class="menu-btn btn skill-dropdown"><i class="fal fa-newspaper left"></i> Forum settings</a>
            <div class="collection-item menu-cat-header"><span>Game</span></div>
            <a href="#" class="menu-btn btn skill-dropdown"><i class="material-icons left"></i>Donations</a>
        </div>
    </div>
</div>
@endif