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
                            <h5 class="left category-title">Admin Control Panel - Advertisement Control Panel</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            @include('layout.sidebar.admincp_sidebar')
            <div class="col s12 xl9">
                <div class="card">
                    <div class="card-content">
                        <form method="POST" action="{{ route('admincp.advertisements.edit', $advertisementSite->id) }}">
                            @csrf
                            <div class="input-field" style="margin-bottom: 20px;">
                                <span>Website/Ad Name</span><br>
                                <small>A friendly name to track this advertisement, for example 'RuneLocus Right Sidebar Advertisement</small>
                                <input class="input-field" type="text" name="website" required value="{{ $advertisementSite->website }}">
                            </div>
                            <div class="input-field" style="margin-bottom: 20px;">
                                <span>URL Prefix</span><br>
                                <small>The referring prefix that will appear after your URL.</small><br>
                                <small style="color:#c9aa71">This should just be a word or multiple words. It will automatically be appended to your URLs after '?r='.<br> If you put 'runelocus' here, your URL would be https://zenyte.org/?r=runelocus.</small>
                                <input class="input-field" type="text" name="link" required value="{{ $advertisementSite->link }}">
                            </div>
                            <div class="input-field" style="margin-bottom: 20px;">
                                <span>Cost</span><br>
                                <small>The cost of this advertisement.</small><br>
                                <small style="color:#c9aa71">This cost should be based on 30 days of the advertisement running. If the advertisement is free, simply enter 0 here.</small>
                                <input class="input-field" type="text" name="cost" required value="{{ $advertisementSite->cost }}">
                            </div>
                            <hr>
                            <button type="submit" class="btn custom-btn skill-dropdown">Save Changes</button>
                        </form>
                    </div>
                </div>
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