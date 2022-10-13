@if(($log->user_staked_coins === 0 || $log->user_staked_coins === null) && $log->user_staked_tokens === 0 || $log->user_staked_tokens === null)
    <span>Nothing Given</span>
@else
    <div class="ptrade-items">
        @if($log->user_staked_coins > 0)
            <div class="item">
                @if($log->user_staked_coins == 1)
                    <div class="item-amount"></div>
                @elseif($log->user_staked_coins > 99999 && $log->user_staked_coins < 9999999)
                    <div class="item-amount" style="color: white !important">{{ App\Models\ModCP\Tradelog::formatAmount($log->user_staked_coins) }}</div>
                @elseif($log->user_staked_coins > 9999999)
                    <div class="item-amount" style="color: #34e48b !important">{{ App\Models\ModCP\Tradelog::formatAmount($log->user_staked_coins) }}</div>
                @else
                    <div class="item-amount">{{ $log->user_staked_coins}}</div>
                @endif
                <img src="{{ asset('img/items/995.png') }}" class="tooltipped" data-position="top" data-tooltip="{{ number_format($log->user_staked_coins) }} Coins">
            </div>
        @endif
            @if($log->user_staked_tokens > 0)
                <div class="item">
                    @if($log->user_staked_tokens == 1)
                        <div class="item-amount"></div>
                    @elseif($log->user_staked_tokens > 99999 && $log->user_staked_tokens < 9999999)
                        <div class="item-amount" style="color: white !important">{{ App\Models\ModCP\Tradelog::formatAmount($log->user_staked_tokens) }}</div>
                    @elseif($log->user_staked_tokens > 9999999)
                        <div class="item-amount" style="color: #34e48b !important">{{ App\Models\ModCP\Tradelog::formatAmount($log->user_staked_tokens) }}</div>
                    @else
                        <div class="item-amount">{{ $log->user_staked_tokens}}</div>
                    @endif
                    <img src="{{ asset('img/items/13204.png') }}" class="tooltipped" data-position="top" data-tooltip="{{ number_format($log->user_staked_tokens) }} Platinum Tokens">
                </div>
            @endif
    </div>
@endif