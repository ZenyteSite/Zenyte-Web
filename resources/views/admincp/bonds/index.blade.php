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
                            <h5 class="left category-title">Admin Control Panel - Bonds Control Panel</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            @include('layout.sidebar.admincp_sidebar')
            <div class="col s12 xl9">
                <form action="{{ route('admincp.bonds') }}" method="post">
                    @csrf
                    <div class="input-field">
                        <input type="text" id="name" name="search" placeholder="Search by username"><i class="material-icons hide-on-med-and-down">search</i>
                    </div>
                </form>
                <div class="card">
                    <table class="responsive-table striped">
                        <thead>
                        <tr>
                            <th class="center-align">Payment ID</th>
                            <th class="center-align">Username</th>
                            <th class="center-align">Item</th>
                            <th class="center-align">Credits Received</th>
                            <th class="center-align">Paid</th>
                            <th class="center-align">Payment Date</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($bonds as $bond)
                            <tr>
                               <td class="center-align">
                                   {{ $bond->id }}
                                </td>
                               <td class="center-align">
                                    {{ $bond->username }}
                                </td>
                               <td class="center-align">
                                    {{ $bond->item_name }}
                                </td>
                                <td class="center-align">
                                    {{ $bond->credit_amount }}
                                </td>
                               <td class="center-align">
                                    {{ $bond->paid }}
                                </td>
                                <td class="center-align">
                                    {{ Carbon\Carbon::parse($bond->paid_on)->toDayDateTimeString() }}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {{ $bonds->links() }}
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