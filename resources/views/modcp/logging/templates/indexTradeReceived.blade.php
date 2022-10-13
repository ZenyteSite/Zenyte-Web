@if($log->received == '[]')
    <span>Nothing Given</span>
@else
    <div class="ptrade-items">
        @foreach(json_decode($log->received) as $received)
            <div class="item">
                @if($received->amount == 1)
                    <div class="item-amount"></div>
                @elseif($received->amount > 99999 && $received->amount < 9999999)
                    <div class="item-amount" style="color: white !important">{{ App\Models\ModCP\Tradelog::formatAmount($received->amount) }}</div>
                @elseif($received->amount > 9999999)
                    <div class="item-amount" style="color: #34e48b !important">{{ App\Models\ModCP\Tradelog::formatAmount($received->amount) }}</div>
                @else
                    <div class="item-amount">{{ $received->amount}}</div>
                @endif
                <img src="{{ asset('img/items')  . '/' . $received->id }}.png" class="tooltipped" data-position="top" data-tooltip="{{ number_format($received->amount) }} {{ $received->name }}">
            </div>
        @endforeach
    </div>
@endif