<div class="col s12 xl3">
    <div class="card" style="padding: 0;">
        <div class="card-content center-align">
            <img src="{{ $forumUser->getAvatarUrl() }}" class="avatarimg">
            <h5 class="author_name">{{ $forumUser->getName() }}</h5>
            <hr>
            <h5 style="font-size: 14px; color: #7C6D5C !important">Rank: <span style="color: #c9aa71 !important;">{{ $forumUser->getRole()  }}</span></h5>
        </div>
        <div class="card-action center-align">
            <a href="{{ route('admincp') }}" class="menu-btn btn skill-dropdown"><i class="material-icons left">dashboard</i>Admin CP</a>
            <a href="#" class="menu-btn btn skill-dropdown"><i class="material-icons left">exit_to_app</i>Logout</a>
        </div>
        <div class="collection no-border">
            <div class="collection-item menu-cat-header"><span>Management</span></div>
            <a href="{{ route('modcp') }}" class="menu-btn btn skill-dropdown"><i class="material-icons left">router</i>Mod CP</a>
            <a href="{{ route('admincp.advertisements') }}" class="menu-btn btn skill-dropdown"><i class="material-icons left">compare_arrows</i>Ad Traffic</a>
            <a href="{{ route('admincp.vote') }}" class="menu-btn btn skill-dropdown"><i class="material-icons left">link</i>Vote CP</a>
            <a href="{{ route('admincp.refreshCache') }}" class="menu-btn btn skill-dropdown tooltipped" data-position="top" data-tooltip="Use this when you have modified a config file on the website">
                <i class="fas fa-recycle left"></i>Refresh Cache</a>
            <div class="collection-item menu-cat-header"><span>Store</span></div>
            <a href="{{ route('admincp.credits') }}" class="menu-btn btn skill-dropdown"><i class="material-icons left">attach_money</i>User Credits</a>
            <a href="{{ route('admincp.products') }}" class="menu-btn btn skill-dropdown"><i class="material-icons left">redeem</i>Products</a>
            <a href="{{ route('admincp.categories') }}" class="menu-btn btn skill-dropdown"><i class="material-icons left">list</i>Categories</a>
            <a href="{{ route('admincp.creditpackages') }}" class="menu-btn btn skill-dropdown"><i class="material-icons left">list</i>Credit Packages</a>
            <div class="collection-item menu-cat-header"><span>Payments</span></div>
            <a href="{{ route('admincp.payments') }}" class="menu-btn btn skill-dropdown"><i class="material-icons left">payment</i>Payments</a>
            <a href="{{ route('admincp.bonds') }}" class="menu-btn btn skill-dropdown"><i class="fas fa-handshake left"></i>Bonds</a>
            <a href="{{ route('admincp.bonds') }}" class="menu-btn btn skill-dropdown"><i class="fas fa-handshake left"></i>Item Purchases</a>
            <a href="{{ route('admincp.osgp') }}" class="menu-btn btn skill-dropdown"><i class="fas fa-coin left"></i>OSRS</a>
            <div class="collection-item menu-cat-header"><span>Logging</span></div>
            <a href="{{ route('modcp.punishments') }}" class="menu-btn btn skill-dropdown"><i class="fas fa-clipboard-list left"></i>Punishment Logs</a>
            <a href="{{ route('modcp.logging') }}" class="menu-btn btn skill-dropdown"><i class="fas fa-search left"></i>Game Logs</a>
        </div>
    </div>
</div>