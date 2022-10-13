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
                            <h5 class="left category-title">Admin Control Panel - Vote Control Panel</h5>
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
                        Simply enter the full URL up until the last incentive part. The system will then append the relevant data (a vote key) to the URL.<br> <strong>If in doubt, always ask your webmaster for assistance.</strong>
                    </div>
                </div>
                <div class="card">
                    <div class="card-content">
                        Your callback URL: <strong>{{ config('app.url') . '/vote/callback' }}</strong>
                    </div>
                </div>
                <div class="card">
                    <div class="card-content">
                        <form method="POST" action="{{ route('admincp.vote.edit', $voteSite->id) }}">
                            @csrf
                            <div class="input-field" style="margin-bottom: 20px;">
                                <span>Title</span><br>
                                <small>Displayed on the button.</small>
                                <input class="input-field" type="text" name="title" value="{{ $voteSite->title }}" required>
                            </div>
                            <div class="input-field" style="margin-bottom: 20px;">
                                <span>Toplist URL</span><br>
                                <small>The URL to the toplist.</small><br>
                                <small style="color:#c9aa71">Insert your relevant ID and the system will insert the incentive. An example of a URL to put here would be: https://www.runelocus.com/top-rsps-list/vote-45848/?id2=</small>
                                <input class="input-field" type="text" name="url" value="{{ $voteSite->url }}" required>
                            </div>
                            <div class="input-field" style="margin-bottom: 20px;">
                                <span>IP address</span><br>
                                <small style="color:#c9aa71">This is the IP address that the vote callback must come from.
                                    In most cases, it should be the IP of the toplist. This is only relevant if the 'require_toplist_ip_in_callback' configuration setting is set to true. If you don't know, or don't want to use IP address specific callbacks, simply leave this field blank.</small>
                                <input class="input-field" type="text" name="ip" value="{{ $voteSite->ipAddress }}">
                            </div>
                            <p>
                                <input class="input-field" type="checkbox" id="visible" name="visible" value="1" {{ $voteSite->visible ? 'checked' : '' }}>
                                <label for="visible">Visible?</label>
                            </p>
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