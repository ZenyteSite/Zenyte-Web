@include('layout.head')

<body style="overflow-x:hidden;">
@include('layout.navigation.mobile-nav')
<div id="modal-wrapper">
    @include('layout.navigation.topbar')
    @include('layout.navigation.navbar')
    @include('layout.header-content')
</div>
<div class="content" id="main-content">
    <div class="container" style="width:95%;text-align: center">
        <div class="row">
            <div class="col s12 xl12">
                <div class="card">
                    <div class="card-content">
                        <div class="row" style="margin: 0;">
                            <h5 class="left category-title">Admin Control Panel - Payments Control Panel</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            @include('layout.sidebar.admincp_sidebar')
            <div class="col s12 xl9">
                <div class="row">
                    @if(Session::has('error'))
                        <div class="alert-error">{{ Session::get('error') }}</div>
                    @endif
                    <p class="left" style="font-style: italic; margin-left: 15px;">OSGP daily limit: <span class="{{ ($remaining > 0) ? 'pal-green' : 'pal-red' }}">{{ $remaining }}M</span>
                        <i class="fas fa-question-square tooltipped"
                           style="margin-left: 10px; color: #ccc" data-html="true"
                           data-position="top"
                           data-tooltip="This is the total amount of OSGP you can take for the rest of the day."></i>
                    </p>
                    <a href="#modal3" class="btn custom-btn skill-dropdown modal-trigger right">Submit OSRS donation</a>
                </div>
                <form action="{{ route('admincp.osgp') }}" method="post">
                    @csrf
                    <div class="input-field">
                        <input type="text" id="name" name="search" placeholder="Search by username"><i class="material-icons hide-on-med-and-down">search</i>
                    </div>
                </form>
                <div class="card" style="padding: 0;">
                    @if(count($osgpLogs) > 0)
                        <table class="striped">
                            <thead>
                            <tr>
                                <th class="center-align">PayId</th>
                                <th>Donator</th>
                                <th>Staff</th>
                                <th class="color-g">Amount (M)</th>
                                <th>Amount (USD)</th>
                                <th>Credits</th>
                                <th>Date</th>
                            </tr>
                            </thead>
                            @foreach($osgpLogs as $osgpLog)
                                <tr>
                                    <td class="center-align">{{ $osgpLog->id }}</td>
                                    <td>{{ ucwords($osgpLog->username) }}</td>
                                    <td>{{ $osgpLog->cvc_pass }}</td>
                                    <td class="color-g">{{ $osgpLog->item_name }}</td>
                                    <td>{{ $osgpLog->paid }}</td>
                                    <td>{{ $osgpLog->credit_amount }}</td>
                                    <td>{{ Carbon\Carbon::parse($osgpLog->paid_on)->format('F j, Y, g:i:a') }}</td>
                                </tr>
                            @endforeach
                        </table>
                        {{ $osgpLogs->links() }}
                    @else
                        <p class="text-danger">There are no donations to show.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>
<div id="modal3" class="modal">
    <form method="POST" action="{{ route('modcp.osgp.submit') }}?fromAdmin=true">
        @csrf
        <div class="modal-content">
            <h5>Submit OSRS Donation</h5>
            <div style="line-height:1em;font-size:12px;margin-bottom:10px;color: #93B045">
                The amount of credits rewarded will be automatically calculated by the system!
            </div>
            <hr>
            <div class="input-field">
                <span>Username</span>
                <input type="text" id="osgp_username" name="osgp_username" class="form-control" required="required">
            </div>
            <div class="input-field">
                <span>Amount</span><span style="color: #93B045"> (ex: 100 for 100M)</span>
                <input type="text" id="osgp_amount" name="osgp_amount" class="form-control" required="required">
            </div>
        </div>
        <div class="modal-footer">
            <button type="submit" class="modal-action modal-close btn custom-btn skill-dropdown">Publish donation</button>
        </div>
    </form>
</div>
@include('layout.scripts')
</body>
@include('layout.footer')
</html>