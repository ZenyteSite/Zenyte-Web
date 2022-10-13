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
                            <h5 class="left category-title">Admin Control Panel - Credit Control Panel</h5>
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
                        The user's ID is generated based on the username entered below. If the user currently has credits, we will update their existing row. If they have no credits, we will create a new row.
                    </div>
                </div>
                <div class="card">
                    <div class="card-content">
                        @if(Session::has('userNotFound'))
                            <div class="alert-error">
                                {{ Session::get('userNotFound') }}
                            </div>
                        @endif
                        <form method="POST" action="{{ route('admincp.credits.giveCredits') }}">
                            @csrf
                            <div class="input-field" style="margin-bottom: 20px;">
                                <span>Username</span><br>
                                <small>The username of the user who's credits are affected</small>
                                <input class="input-field" type="text" name="username" required>
                            </div>
                            <div class="input-field" style="margin-bottom: 20px;">
                                <span>Credit Amount</span><br>
                                <small>How many credits should be either added or removed from the user.</small><br>
                                <small style="color:#c9aa71">Please make this a whole number and then select using the options below whether you want to add or subtract this amount from the users total credits.</small>
                                <input class="input-field" type="number" step="1" min="0" name="credits" required>
                            </div>
                            <p>
                                <input class="with-gap" name="creditAction" value="add" type="radio" id="creditAction_add" checked/>
                                <label for="creditAction_add">Add Credits</label>
                            </p>
                            <p>
                                <input class="with-gap" name="creditAction" value="subtract" type="radio" id="creditAction_subtract"/>
                                <label for="creditAction_subtract" style="color:red">Subtract Credits</label>
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
</html>