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
                            <a class="btn custom-btn right skill-dropdown" style="width:175px" href="{{ route('admincp.vote.create') }}">
                                Add Link
                            </a>
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
                    <table class="striped">
                        <thead>
                        <tr>
                            <th></th>
                            <th>Title</th>
                            <th>Vote URL</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($sites as $site)
                            <tr>
                                <td class="center-align"><i class="material-icons">{{ ($site->visible) ? 'visibility' : 'visibility_off' }}</i></td>

                                <td>
                                    {{ $site->title }}
                                </td>
                                <td>
                                    {{ $site->url }}
                                </td>
                                <td>
                                    <a href="{{ route('admincp.vote.edit', $site->id) }}"><i class="material-icons">edit</i></a>
                                </td>
                                <td>
                                    <a href="{{ route('admincp.vote.delete', $site->id) }}"><i class="material-icons">delete</i></a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
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