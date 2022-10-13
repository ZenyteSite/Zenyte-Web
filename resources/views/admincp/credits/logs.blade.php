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
                            <a class="btn custom-btn right skill-dropdown" style="width:175px" href="{{ route('admincp.credits') }}">
                                View Credits
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            @include('layout.sidebar.admincp_sidebar')
            <div class="col s12 xl9">
                <form action="{{ route('admincp.credits.creditLog') }}" method="post">
                    @csrf
                    <div class="input-field">
                        <input type="text" id="name" name="search" placeholder="Search by author or recipient name"><i class="material-icons hide-on-med-and-down">search</i>
                    </div>
                </form>
                <div class="card">
                    <table class="responsive-table striped">
                        <thead>
                        <tr>
                            <th>Author</th>
                            <th>Recipient</th>
                            <th>Credits</th>
                            <th>Date</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($logs as $log)
                            <tr>
                               <td>
                                    {{ $log->author }}
                                </td>
                                <td>
                                    {{ $log->recipient }}
                                </td>
                               <td>
                                    {{ number_format($log->credits) }}
                                </td>
                               <td>
                                    {{ Carbon\Carbon::parse($log->given_at)->format('F j, Y, g:i:a') }}
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