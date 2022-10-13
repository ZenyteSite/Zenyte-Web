@if($log->given == '[]')
    <span>Nothing Given</span>
@else
    <div class="ptrade-items">
        @foreach(json_decode($log->given) as $given)
            <div class="item">
                @if($given->amount == 1)
                    <div class="item-amount"></div>
                @elseif($given->amount > 99999 && $given->amount < 9999999)
                    <div class="item-amount" style="color: white !important">{{ App\Models\ModCP\Tradelog::formatAmount($given->amount) }}</div>
                @elseif($given->amount > 9999999)
                    <div class="item-amount" style="color: #34e48b !important">{{ App\Models\ModCP\Tradelog::formatAmount($given->amount) }}</div>
                @else
                    <div class="item-amount">{{ $given->amount}}</div>
                @endif
                <img src="{{ asset('img/items')  . '/' . $given->id}}.png" class="tooltipped" data-position="top" data-tooltip="{{ number_format($given->amount) }} {{ $given->name }}">
            </div>
        @endforeach
    </div>
@endif