<div class="modal-content">
    <div class="productModalLoading">
        <div class="loading">
            <div class="loading-inner">
                <h5>Loading</h5>
                <small>Please wait...</small>
            </div>
        </div>
    </div>
    <div class="productModalContent" style="display:none;">
        <div class="row">
            <div class="col l2 m3 s3">
                <div class="item-modal-img-border left" style="margin-right:10%;">
                    <img class="item-modal-img" src="{{ $product->getThumbnailImage() }}" alt="{{ $product->item_name }}">
                </div>
            </div>
            <div class="col l8 m6 s6">
                <div class="item-details">
                    <h5 id="item-modal-name">{{ $product->item_name }}</h5>
                    <div class="item-description">
                        {{ Illuminate\Mail\Markdown::parse($product->description) }}
                    </div>
                </div>
            </div>

            <div class="col l2 m3 s3">
                <div class="item-details-right">
                    <h5 id="item-amt">Amount: {{ $product->item_amount }}</h5>
                    <h5 id="item-price">Price: {{ $product->getDiscountedPrice() }} Credits</h5>
                </div>
            </div>
        </div>
        @if(count($product->getImages()) > 0)
        <div class="row">
            <div class="col l3 m3 s3">
            </div>
            <div class="col l6 m6 s6">
                <div class="splide">
                    <div class="splide__track">
                        <ul class="splide__list">
                            @foreach($product->getImages() as $productImage)
                            <li class="splide__slide"><img src="{{ $productImage }}" alt="{{ $product->item_name }} image"></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col l3 m3 s3">
            </div>
        </div>
        @endif
        <div class="modal-controls">
            <a class="modal-action modal-close btn custom-btn skill-dropdown">Close</a>
        </div>
    </div>
</div>