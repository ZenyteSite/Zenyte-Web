<div class="col s12 xl3">
    <div class="card" style="padding: 0;">
        <div class="card-content center-align">
            <img src="{{ $forumUser->getAvatarUrl() }}" class="avatarimg">
            <h5 class="author_name">{{ $forumUser->getName() }}</h5>
            <h6 id="currentCredits" class="credits_store {{ (App\Models\Store\UserCredit::getCreditAmount($forumUser->getId(), $forumUser->getName())) <= 0 ? 'pal-red' : 'pal-bgreen'  }}" style="font-size: 15px; margin-top: 5px;" data-credits="{{ App\Models\Store\UserCredit::getCreditAmount($forumUser->getId(), $forumUser->getName()) }}">{{ number_format(App\Models\Store\UserCredit::getCreditAmount($forumUser->getId(), $forumUser->getName())) }} credits</h6>
            <h6 class="credits_store {{ (App\Models\CreditPayment::getTotalDonated($forumUser->getName()) <= 0) ? 'pal-red' : 'pal-blue' }}" style="font-size: 15px; margin-top: 5px;">${{ number_format(App\Models\CreditPayment::getTotalDonated($forumUser->getName())) }} total donated</h6>
        </div>

        <div class="card-action center-align">
            <a href="#" class="btn menu-btn skill-dropdown"><i class="material-icons left"></i>Sign Out</a>
        </div>
    </div>
    <div class="card">
        <div class="collection">
            <div class="collection-item">
                <h5>Your Cart</h5>
            </div>
            <span id="cartitems">
            @foreach(Cart::content() as $item)
                    <div class="collection-item" id="cartitem" data-itemid="{{ $item->id }}">
                        <div class="left" style="margin-right: 10px;"><img height="40px;" src="{{ App\Models\Product::getThumbnailImage($item->id) }}"></div>
                        x<span id="quantity">{{ $item->qty }}</span> {{ $item->name }}<br>
                        <small><span id="price">{{ App\Models\Product::find($item->id)->getDiscountedPrice() * $item->qty }}</span> credits</small>
                    </div>
            @endforeach
                  </span>
            <div class="collection-item right-align">
                Total: <span id="totalprice" data-total="{{ Cart::subTotal() }}">{{ Cart::subTotal() }}</span> credits
            </div>
            <div class="collection-item center-align">
                <a href="#!" class="btn skill-dropdown checkoutButton">Checkout</a>
                <p style="margin-top: 10px;"><a href="/store/#" id="emptycart">Empty Cart</a></p>
            </div>
        </div>
    </div>

</div>
