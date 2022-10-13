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
            <div class="col s12">
                <div class="card">
                    <div class="card-content">
                        <h5 class="category-title left">Adventurer's Log</h5>
                        <div class="row">
                            <form action="{{ route('account') }}" class="searchform right" method="POST">
                                @csrf
                                <div class="input-field">
                                    <input type="text" id="username" name="username" placeholder="Search by character name">
                                    <i class="material-icons hide-on-med-and-down">search</i>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="alert-error">The user you're looking for does not exist</div>
            </div>
        </div>
    </div>
</div>
@include('layout.scripts')
</body>
@include('layout.footer')
</html>