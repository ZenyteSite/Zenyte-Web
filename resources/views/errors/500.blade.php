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
        <div class="error center-align">

            <h1>500</h1>

            <div class="error-divide"></div>

            <p style="line-height:1.3em;">An internal error occurred when loading this page :(</p>

            <a href="{{ url()->previous() }}">Go Back</a> or <a href="/">Go Home</a>
        </div>
    </div>
</div>
</div>
</div>
</body>
@include('layout.footer')
</html>