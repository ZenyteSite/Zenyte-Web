@if(Request::is('/'))
<div class="slider" style="z-index: -1;">
        <div class="slider-bg" style="background:url({{ asset('img/slides/background6.jpg') }}) top center no-repeat;">
            <div class="slider-content">
                <img src="{{ asset('img/slides/slide6.png') }}" class="slider-img img-fluid" style="margin-top:350px;">
            </div>
        </div>
    </div>

    <div class="slider-item">
        <div class="slider-bg" style="background:url({{ asset('img/slides/background4.jpg') }}) top center no-repeat;">
            <div class="slider-content">
                <img src="{{ asset('img/slides/slide4.png') }}" class="slider-img img-fluid" style="margin-top:350px;">
            </div>
        </div>
    </div>
    <div class="slider-item">
        <div class="slider-bg" style="background:url({{ asset('img/slides/background3.png') }}) top center no-repeat; margin-top: 43px;">
            <div class="slider-content">
                <img src="{{ asset('img/slides/slide3.png') }}" class="slider-img img-fluid" style="margin-top:250px;">
            </div>
        </div>
    </div>

</div>
<div class="playbutton-container">
    <a class="playbutton"></a>
</div>
@else
<div class="temp-play">
    <a href=""><div class="temp-play-btn countdown-discord"></div></a>
</div>
@endif