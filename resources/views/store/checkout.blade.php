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
                        <div class="row" style="margin: 0;">
                            <h5 class="left category-title">Checkout Receipt</h5>
                            <a href="{{ route('store') }}" class="btn custom-btn skill-dropdown right">Store Home</a>
                            <a href="{{ route('store.buyCredits') }}" class="btn custom-btn skill-dropdown right">Buy Credits</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col s12 xl9">
                @if($cart)
                <div class="card">
                    <table class="striped">
                        <thead>
                        <tr>
                            <th></th>
                            <th>Item Name</th>
                            <th class="right-align">Quantity</th>
                            <th class="right-align">Price</th>
                        </tr>
                        </thead>
                       @foreach($cart as $item)
                        <tr>
                            <td><img src="{{ \App\Models\Product::find($item->id)->getThumbnailImage() }}" height="40px" alt="{{ \App\Models\Product::find($item->id)->item_name }}"</td>
                            <td>{{ \App\Models\Product::find($item->id)->item_name }}</td>
                            <td class="right-align">x{{ $item->qty }}</td>
                            <td class="right-align">{{ $item->price * $item->qty }} Zenyte Credits</td>
                        </tr>
                        @endforeach
                    </table>
                    <div class="card-action right-align">
                        Total: {{ $subtotal }} credits<br>
                    </div>
                </div>
                @endif
            </div>

            @include('layout.sidebar.store_sidebar_credits')
        </div>
    </div>
</div>