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
        <div class="row" style="padding-top: 50px;padding-bottom:50px;">
            <div class="col s12 m12 l6 offset-l3 center-align">
                <span class="large material-icons" style="font-size:80px;">error_outline</span>
                <h4>An error occurred</h4>
                <hr>
                <p>
                    {{ Session::get('24hourcheck') }}
                    <br>
                    <span class="red-text">{{ $timeLeft }}</span>
                </p>

                <a href="{{ route('vote') }}" class="skill-dropdown btn">Go Back</a>

            </div>
        </div>
    </div>
</div>
@include('layout.scripts')
<script>
</script>
</body>
@include('layout.footer')
</html>