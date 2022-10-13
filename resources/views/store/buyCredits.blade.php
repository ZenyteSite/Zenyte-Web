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
                            <h5 id="store-title" class="left category-title">
                                Zenyte Credit Shop: <span class="pal-red">{{ ucfirst($paymentMethod) }}</span>
                            </h5>
                            <a href="{{ route('store') }}" class="btn custom-btn skill-dropdown right">Store Home</a>
                        </div>
                        <span class="left pal-orange">
                                Please Note: All credits amount shown below are AFTER additional credits have been added.
                            </span>
                        @if(config('store.sale.' . $paymentMethod . '.enabled'))
                            <div class="row" style="margin-top: 50px; margin-left: 24px; ">
                                <h5 style="color: #4CAF50 !important; font-size: 15px; font-style:italic;">There is currently a sale for all {{ ucfirst($paymentMethod) }} payments
                                    underway! {{ config('store.sale.' . $paymentMethod . '.amount') }}%
                                    bonus credits have been added to all credit packages!</h5>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col s12 m12 l9">
                <div class="row">
                    <div class="col s12 center-align">
                        <div class="card">
                            <div class="card-content center-align">
                                <p style="color:#00BDF5">Please choose a checkout method:</p>
                                <hr>
                                <a href="{{ route('store.buyCredits') }}?method=paypal" style="height: 100px" class="ht-100 btn custom-btn skill-dropdown {{ ($paymentMethod == 'paypal') ? 'active-g' : '' }}">
                                    <img style="height:75px" src="{{ asset('img/paypal.png') }}" class="ht-75"/>
                                </a>
                                <a href="{{ route('store.buyCredits') }}?method=crypto" style="height: 100px" class="ht-100 btn custom-btn skill-dropdown {{ ($paymentMethod == 'crypto') ? 'active-g' : '' }}">
                                    <img style="height:75px" src="{{ asset('img/coinbase.png') }}" class="ht-75"/>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    @foreach($packages as $package)
                        <div class="col s12 xl3">
                            <div class="card">
                                <div class="card-content center-align" style="min-height:300px;">
                                    <div class="coin-icon">
                                        <img src="{{ $package->getImageUrl() }}">
                                    </div>
                                    <h5 class="credit-title">{{ $package->getFullCreditsAmount($paymentMethod) }} Credits</h5>
                                    <p class="credit-price">${{ $package->price }} USD</p>
                                        <p><small class="green-text">+{{ $package->bonus }} bonus credits</small></p>

                                        <p><small class="pal-snow">+{{ $package->holiday_bonus }} holiday bonus credits</small></p>
                                    @if($paymentMethod == 'paypal')
                                        <form action="{{ route('store.paypalCheckout') }}?credit_id={{ $package->id }}" method="POST">
                                            @csrf
                                            <input type="submit" value="Buy" class="btn custom-btn skill-dropdown" style="margin-top: 13px;">
                                        </form>
                                    @elseif($paymentMethod == 'crypto')
                                        {{--                        <a class="buy-crypto btn custom-btn skill-dropdown" data-cost="{{option.price}}" data-credits="{{option.amount}}" data-bonus="{{option.bonus}}" data-holiday="{{constant('HOLIDAY') ? option.holiday_bonus : 0}}" data-id="{{ option.id }}" style="margin-top: 13px;">Buy</a>--}}
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            @include('layout.sidebar.store_sidebar_credits')
        </div>
    </div>
</div>
@include('layout.scripts')
{{--TODO: Buying credits, checkout, product descriptions--}}
<script>
    var currentPath = '{{ route('store') }}';
    var locked = false;
    var lastCategory = -1;
    var currentPage = 1;
    var storeItems = $('#storeitems');
    var catTitle = $('.cattitle');
    var searchField = $('#item');
    var cartItems = $('#cartitems');
    var timer = null;
    var totalPrice = $('#totalprice');
    var pagination = $('#pagination');

    loadItems(lastCategory, 1);

    function numberFormat(number) {
        return number.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
    }

    searchField.on('keyup', function () {
        var input = searchField.val();

        if (timer != null) {
            clearTimeout(timer);
            timer = null;
        }

        timer = setTimeout(function () {
            if (input == '') {
                loadItems(lastCategory, currentPage);
            } else {
                if (input.length == 1) {
                    return;
                }
                $.post("{{ route('api.store.categories') }}", {
                    search: input,
                    catId: -1
                }).done(function (data) {
                    var html = '';
                    $.each(data.products, function (index, value) {
                        html += renderProduct(value);
                    });
                    storeItems.html(html);
                });
            }
        }, 700);
    });

    $('#pagination').on("click", "#pagebtn", function (e) {
        e.preventDefault();

        var pattern = /^[0-9]+$/;

        if (!pattern.test('' + $(this).data('page') + '') || locked) {
            return;
        }
        locked = true;
        loadItems(lastCategory, $(this).data('page'));
    });

    $(document).on("click", "#storecat", function (e) {
        e.preventDefault();

        var categoryId = $(this).data("catid");
        var categoryTitle = $(this).data("cattitle");

        if (categoryId == lastCategory || locked) {
            return;
        }

        lastCategory = categoryId;
        locked = true;
        currentPage = 1;

        loadItemsFade(categoryId, categoryTitle, currentPage);
    });

    $(document).on("click", "#emptycart", function (e) {
        e.preventDefault();

        if (locked) {
            return;
        }

        locked = true;

        $.post("{{ route('store.emptyCart') }}", {"_token": "{{ csrf_token() }}"}).done(function (data) {
            Materialize.toast('<i class="material-icons left">check</i>' + data.toString(), 2000, 'toast-success');
            cartItems.html("");
            totalPrice.text("0");
            locked = false;
        });
    });

    $(document).on("click", "#addcart", function (e) {
        e.preventDefault();

        if (locked) {
            return;
        }
        locked = true;
        var item_id = $(this).data('itemid');

        $.post("{{ route('store.addToCart') }}",
            {
                "_token": "{{ csrf_token() }}",
                productID: item_id
            }).done(function (data) {
            var response = jQuery.parseJSON(data.toString());
            var alertText = "";

            if (updateCartItem(response)) {
                alertText = 'You added another ' + response.item_name + ' to your cart!';
            } else {
                alertText = 'x' + response.quantity + ' ' + response.item_name + ' has been added to your cart!';
                addToCart(response);
            }
            Materialize.toast(`<img height="20px" src="${response.thumbnail_img}" class="left">` + alertText, 2000, 'toast-success');
            totalPrice.text(response.total);
            locked = false;
        }).fail(function (data) {
            Materialize.toast('<i class="material-icons left">error_outline</i>' + data.responseText.toString(), 2000, 'toast-error');
            locked = false;
        });
    });

    function renderProduct(product) {
        var isDiscount = product.item_discount;
        var price = (isDiscount) ? product.item_price - (product.item_price * product.item_discount / 100) : product.item_price;
        var html = `<div class="col s12 xl3">
                        <div class="card">
                            <div class="card-content center-align" style="min-height:250px;">
                                <a href="#item-modal"
                                class="edit-btn left-0 modal-trigger"
                                id="item-modal-trigger"
                                data-name="${product.item_name}"
                                data-id="${product.id}"
                                data-amount="${product.item_amount}"
                                data-images="${product.extraImageUrls}"
                                data-description="${product.description}"
                                data-price="${price}">
                                    <i class="fal fa-info-circle"></i>
                                </a>
                                <div class="product-image">
                                    <img src="${product.thumbnail_image}">
                                </div>
                                <div class="product-title">
                                    ${product.item_name}`;
        if (product.ironman) {
            html += ` <img height="16px" src="{{ asset('img/ironmanicon.png') }}">`;
        }
        html += `</div>`;
        if (isDiscount) {
            html += `  <p class="product-price">
                            <span class="green-text text-darken-3">${numberFormat(price)} credits</span>
                            <s class="red-text text-darken-3">${numberFormat(product.item_price)} credits</s>
                        </p>`;
        } else {
            html += `<p class="product-price">${numberFormat(price)} credits</p>`
        }
        //We're a bond product
        if (product.bond_amount !== null) {
            html += `<p class="product-bond">- ${product.bond_amount} total donated</p>`;
        }
        html += `<div style="margin-top: 10px;">
                    <a href="/store/#" id="addcart" class="addcart" data-itemid="${product.id}">Add</a>
                </div>
                </div>
                </div>
                </div>`;

        return html;
    }

    function loadPagination(show = false, currentPage = 0, totalPages = 0) {
        if (show) {
            pagination.css('display', '');
            $('#currentPage').html(currentPage);
            $('#totalPages').html(totalPages);
            //Previous
            if (currentPage == 1) {
                $('.previous_page').attr('data-page', '').data('page', '');
            } else {
                $('.previous_page').attr('data-page', parseInt(currentPage) - 1).data('page', parseInt(currentPage) - 1);
            }
            //Next
            if (currentPage == totalPages) {
                $('.next_page').attr('data-page', '').data('page', '');
            } else {
                $('.next_page').attr('data-page', parseInt(currentPage) + 1).data('page', parseInt(currentPage) + 1);
            }
            //Last
            $('.last_page').attr('data-page', totalPages).data('page', parseInt(totalPages));
        } else {
            pagination.css('display', 'none');
            $('#currentPage').html('');
            $('#totalPages').html('');
        }
    }

    function loadItems(categoryId, pageNumber) {
        $.post("{{ route('api.store.categories') }}",
            {
                catId: categoryId,
                page: pageNumber
            }).done(function (data) {
            var html = '';
            $.each(data.products, function (index, value) {
                html += renderProduct(value);
            });
            storeItems.html(html);
            locked = false;
            if (data.count > 15) {
                loadPagination(true, data.currentPage, data.totalPages.toFixed(0));
            } else {
                loadPagination();
            }
        });
    }

    function loadItemsFade(categoryId, categoryTitle, pageNumber) {
        storeItems.fadeOut("fast", function () {
            catTitle.text(categoryTitle);
            $.post("{{ route('api.store.categories') }}",
                {
                    catId: categoryId,
                    page: pageNumber
                }).done(function (data) {
                var html = '';
                $.each(data.products, function (index, value) {
                    html += renderProduct(value);
                });
                storeItems.html(html);
                storeItems.fadeIn("fast", function () {
                    locked = false;
                    currentPage = 1;
                });
                if (data.count > 15) {
                    loadPagination(true, data.currentPage, data.totalPages.toFixed(0));
                } else {
                    loadPagination();
                }
            });
        });
    }

    function updateCartItem(response) {
        var found = false;
        $("div[id^='cartitem']").each(function () {
            if ($(this).data("itemid") == response.id) {
                $(this).find('#quantity').text(response.quantity);
                $(this).find("#price").text(response.price);
                found = true;
                return false;
            }
        });
        return found;
    }

    function addToCart(response) {
        var id = response.id;
        var name = response.item_name;
        var price = response.price;
        var quantity = response.quantity;
        var img = response.thumbnail_img;
        cartItems.append(
            `<div class="collection-item" id="cartitem" data-itemid="${id}">
            <div class="left" style="margin-right:10px;"><img height="40px;" src="${img}"></div>
            x<span id="quantity">${quantity}</span> ${name}<br>
            <small><span id="price">${price}</span> credits</small>
            </div>`);
    }

</script>
</body>
@include('layout.footer')
</html>