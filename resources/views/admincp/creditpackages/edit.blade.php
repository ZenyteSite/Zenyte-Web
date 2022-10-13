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
                            <h5 class="left category-title">Admin Control Panel - Credit Packages Control Panel</h5>
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
                        <form method="POST" action="{{ route('admincp.creditpackages.edit', $creditpackage->id) }}" enctype="multipart/form-data">
                            @csrf
                            <div class="input-field" style="margin-bottom: 20px;">
                                <span>Credits Amount</span><br>
                                <small>The amount of credits a user should receive when they purchase this</small>
                                <input class="input-field" type="text" name="amount" required value="{{ $creditpackage->amount }}">
                            </div>
                            <div class="input-field" style="margin-bottom: 20px;">
                                <span>Bonus Amount</span><br>
                                <small>The bonus amount of credits a user should receive when they purchase this. Leaving this empty will result in no bonus credits being given.</small>
                                <input class="input-field" type="text" name="bonus" value="{{ $creditpackage->bonus }}">
                            </div>
                            <div class="input-field" style="margin-bottom: 20px;">
                                <span>Holiday Bonus Amount</span><br>
                                <small>The holiday bonus amount of credits a user should receive when they purchase this. Leaving this empty will result in no holiday bonus credits being given.</small>
                                <input class="input-field" type="text" name="holiday_bonus" value="{{ $creditpackage->holiday_bonus }}">
                            </div>
                            <div class="input-field" style="margin-bottom: 20px;">
                                <span>Discount (%)</span><br>
                                <small>The amount of discount to apply to this credit package. This is in %. If you do not wish to apply a discount to this credit package, simply leave this field blank.</small>
                                <input class="input-field" type="text" name="discount" max="99.9" value="{{ $creditpackage->discount }}">
                            </div>
                            <div class="input-field" style="margin-bottom: 20px;">
                                <span>Price ($)</span><br>
                                <small>The amount a user must pay for this credit package. This is in USD. The discount will be calculated based on this number.</small>
                                <input class="input-field" type="text" name="price" required value="{{ $creditpackage->price }}">
                            </div>
                            <p>Existing Thumbnail Image</p>
                            <img src="{{ $creditpackage->getImageUrl() }}" height="250px">
                            <p>Please note: adding an image here will replace your existing thumbnail image. If you don't want to replace your existing thumbnail image, simply don't upload any image here.</p>
                            <small>This the image that will show on the credit image when viewing the buy credits page</small>
                            <div class="file-field input-field">
                                <div class="btn">
                                    <span>Upload Credit Image</span>
                                    <input type="file" name="credit-image">
                                </div>
                                <div class="file-path-wrapper">
                                    <input class="file-path validate" type="text">
                                </div>
                            </div>
                            <hr>
                            <button type="submit" class="btn custom-btn skill-dropdown">Save Changes</button>
                        </form>
                    </div>
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