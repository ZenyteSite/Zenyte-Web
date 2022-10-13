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
                            <a class="btn custom-btn right skill-dropdown" style="width:175px" href="{{ route('admincp.credits.giveCredits') }}">
                                Give Credits
                            </a>
                            <a class="btn custom-btn right skill-dropdown" style="width:175px" href="{{ route('admincp.credits.creditLog') }}">
                                Credit Log
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            @include('layout.sidebar.admincp_sidebar')
            <div class="col s12 xl9">
                <form action="{{ route('admincp.credits') }}" method="post">
                    @csrf
                    <div class="input-field">
                        <input type="text" id="name" name="search" placeholder="Search by username"><i class="material-icons hide-on-med-and-down">search</i>
                    </div>
                </form>
                <div class="card">
                    <table class="responsive-table striped">
                        <thead>
                        <tr>
                            <th class="center-align">User ID</th>
                            <th>Username</th>
                            <th>Current Credit Amount</th>
                            <th>Total Credits Received</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($credits as $credit)
                            <tr>
                               <td class="center-align">
                                    {{ $credit->user_id }}
                                </td>
                               <td>
                                    {{ $credit->username }}
                                </td>
                               <td>
                                    {{ number_format($credit->credits) }}
                                </td>
                               <td>
                                    {{ number_format($credit->total_credits) }}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    @if(count($credits) > 1)
                    {{ $credits->links() }}
                        @endif
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