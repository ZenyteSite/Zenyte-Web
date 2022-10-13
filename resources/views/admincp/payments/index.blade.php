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
                <div style="display:flex;">
                    <a class='dropdown-button btn skill-dropdown right' href='#' data-activates='dropdown3'>
                        Filter By Payment Method
                        <i class="material-icons right">menu</i>
                    </a>
                    <ul id='dropdown3' class='dropdown-content'>
                        <li>
                            <a href="{{ route('admincp.payments') }}">All Payments</a>
                            <a href="{{ route('admincp.payments') }}?paypal=true">Paypal Payments</a>
                            <a href="{{ route('admincp.payments') }}?osrs=true">OSRS Payments</a>
                            <a href="{{ route('admincp.payments') }}?coinbase=true">Coinbase Payments</a>
                        </li>
                    </ul>
                </div>
                <form action="{{ route('admincp.payments') }}" method="post">
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
                            <th class="center-align">Payment Method</th>
                            <th class="center-align">Payment Date</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($payments as $payment)
                            <tr>
                               <td class="center-align">
                                   {{ $payment->id }}
                                </td>
                               <td class="center-align">
                                    {{ $payment->username }}
                                </td>
                               <td class="center-align">
                                    {{ $payment->item_name }}
                                </td>
                                <td class="center-align">
                                    {{ $payment->credit_amount }}
                                </td>
                               <td class="center-align">
                                    {{ $payment->paid }}
                                </td>
                                <td class="center-align">
                                    {{ $payment->zip_pass }}
                                </td>
                                <td class="center-align">
                                    {{ Carbon\Carbon::parse($payment->paid_on)->toDayDateTimeString() }}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {{ $payments->links() }}
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