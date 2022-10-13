<div class="col s12 xl3">
    <div class="card" style="padding: 0;">
        <div class="card-content center-align">
            <img src="{{ $forumUser->getAvatarUrl() }}" class="avatarimg">
            <h5 class="author_name">{{ $forumUser->getName() }}</h5>
            <h6 class="credits_store {{ (App\Models\Store\UserCredit::getCreditAmount($forumUser->getId(), $forumUser->getName())) <= 0 ? 'pal-red' : 'pal-bgreen'  }}" style="font-size: 15px; margin-top: 5px;">{{ number_format(App\Models\Store\UserCredit::getCreditAmount($forumUser->getId(), $forumUser->getName())) }} credits</h6>
            <h6 class="credits_store {{ (App\Models\CreditPayment::getTotalDonated($forumUser->getName()) <= 0) ? 'pal-red' : 'pal-blue' }}" style="font-size: 15px; margin-top: 5px;">${{ number_format(App\Models\CreditPayment::getTotalDonated($forumUser->getName())) }} total donated</h6>
        </div>

        <div class="card-action center-align">
            <a href="#" class="btn menu-btn skill-dropdown"><i class="material-icons left"></i>Sign Out</a>
        </div>
    </div>
</div>
