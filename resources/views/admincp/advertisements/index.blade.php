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
                            <a class="btn custom-btn right skill-dropdown" style="width:350px" href="{{ route('admincp.advertisements.create') }}">
                                Add Advertisement Link
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            @include('layout.sidebar.admincp_sidebar')
            <div class="col s12 xl9">
                <form action="{{ route('admincp.advertisements') }}" method="post">
                    @csrf
                    <div class="input-field">
                        <input type="text" id="name" name="search" placeholder="Search by advertisement name"><i class="material-icons hide-on-med-and-down">search</i>
                    </div>
                </form>
                <div class="card">
                    <table class="responsive-table table-ads striped">
                        <thead>
                        <tr>
                            <th style="width:10%;">Ad Name</th>
                            <th style="width:10%;">URL Prefix</th>
                            <th style="width:5%;">Cost</th>
                            <th style="width:10%;">Total Clicks</th>
                            <th style="width:15%;">Unique Clicks</th>
                            <th style="width:20%;">Link</th>
                            <th style="width:15%;">Date Added</th>
                            <th style="width:10%;">Controls</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($sites as $key => $site)
                            <tr>
                               <td style="width:10%;">
                                    {{ $site->website }}
                                </td>
                               <td style="width:10%;">
                                    {{ $site->link }}
                                </td>
                               <td style="width:5%;">
                                    ${{ $site->cost }}
                                </td>
                               <td style="width:10%;">
                                    {{ $site->total_clicks }}
                                </td>
                                <td style="width:15%;">
                                    {{ $site->unique_clicks }}
                                </td>
                               <td style="width:20%;">
                                    https://zenyte.org/?r={{ $site->link }}
                                </td>
                               <td style="width:15%;">
                                    {{ Carbon\Carbon::parse($site->date_added)->format('F j, Y, g:i:a') }}
                                </td>
                               <td style="width:10%;">
                                    <a href="{{ route('admincp.advertisements.edit', $site->id) }}"><i class="material-icons">edit</i></a>
                                    <a href="{{ route('admincp.advertisements.delete', $site->id) }}"><i class="material-icons">delete</i></a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {{ $sites->links() }}
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