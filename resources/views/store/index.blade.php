@include('layout.head')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@splidejs/splide@2.4.14/dist/css/splide.min.css" integrity="sha256-EqzwzekQXKNbB5EE4nNBQT+2gWQIWRZQXAd89YdIq8M=" crossorigin="anonymous">
<link href="//cdn.jsdelivr.net/npm/@sweetalert2/theme-borderless/borderless.css" rel="stylesheet">
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
              @if(Session::get('paymentComplete'))
                <div class="alert-success">
                  {{ Session::get('paymentComplete') }}
                </div>
              @endif
              <div class="col s3 m3 l3">
                <div class="input-field">
                  <input type="text" id="item" name="item" class="left" placeholder="Type an item name here" autocomplete="off">
                </div>
              </div>
              <div class="col s9 m9 l9">
                @if(config('store.sale.crypto.enabled') && config('store.sale.paypal.enabled'))
                  @if(config('store.sale.crypto.amount') == config('store.sale.paypal.amount'))
                    <a href="" class="btn custom-btn skill-dropdown right">Buy Credits <span class="pal-blue">(+{{ config('store.sale.paypal.amount') }}%)</span></a>
                  @else
                    <a href="" class="btn custom-btn skill-dropdown right">Buy Credits <span
                              class="pal-blue">(+{{ config('store.sale.paypal.amount') }}% with Paypal & +{{ config('store.sale.crypto.amount') }}% with Coinbase)</span></a>
                  @endif
                @elseif(config('store.sale.paypal.enabled'))
                  <a href="" class="btn custom-btn skill-dropdown right">Buy Credits <span class="pal-blue">(+{{ config('store.sale.paypal.amount') }}% with PayPal)</span></a>
                @elseif(config('store.sale.crypto.enabled'))
                  <a href="" class="btn custom-btn skill-dropdown right">Buy Credits <span class="pal-blue">(+{{ config('store.sale.crypto.amount') }}% with Coinbase)</span></a>
                @else
                  <a href="" class="btn custom-btn skill-dropdown right">Buy Credits</a>
                @endif
                <a href="" class="btn custom-btn skill-dropdown right">OSRS GP @if(config('store.sale.osgp.enabled')) <span class="pal-blue">(+{{ config('store.sale.osgp.amount') }}%)</span>@endif</a>
                <a class='dropdown-button btn custom-btn skill-dropdown right' href='javascript:void(0);' data-activates='dropdown3'>
                  <span class="cattitle">Categories</span>
                  <i class="material-icons right">menu</i>
                </a>

                <ul id='dropdown3' class='dropdown-content'>
                  <li><a href="/store/#" id="storecat" data-catid="-1" data-cattitle="All Items">Show All</a></li>
                  @foreach($categories as $category)
                    <li><a href="/store/#" id="storecat" data-catid="{{ $category->id }}" data-cattitle="{{ $category->title }}">{{ ucwords($category->title) }}</a></li>
                  @endforeach
                </ul>
              </div>
            </div>
            <div class="row" style="margin-top: 25px; margin-left: 24px;">
              <h5 style="color: #c9aa71; font-size: 15px; font-style:italic;">Did you know? You can claim your items ingame by talking to the Wise Old Man in Edgeville!</h5>
            </div>
            <div class="row" style="margin-top: 25px; margin-left: 24px;">
              <h5 style="color: #ea4335 !important; font-size: 15px; font-style:italic;">Purchasing bonds will subtract from your total donated; claiming a bond will add this amount back to the claimee!</h5>
            </div>
            @if(config('store.sale.paypal.enabled') || config('store.sale.crypto.enabled') || config('store.sale.osgp.enabled'))
              <div class="row" style="margin-top: 25px; margin-left: 24px; ">
                <h5 style="color: #4CAF50 !important; font-size: 15px; font-style:italic;">There is currently a sale underway! Get bonus credits now by clicking the 'Buy Credits' link above!</h5>
              </div>
            @endif
          </div>
        </div>
      </div>
    </div>
    <hr>
    <h5>Featured {{ count($featuredProducts) > 1 ? 'Products' : 'Product' }}</h5>
    <div class="row" style="display:flex;">
      @foreach($featuredProducts as $featuredProduct)
        <div class="col" style="width:{{ ceil(100 / count($featuredProducts)) }}%">
          <div class="card" style="border:2px solid #00BDF5;">
            <div class="card-content center-align" style="min-height:250px;">
              <a data-toggle="modal" data-href="{{ route('api.products') }}/{{ $featuredProduct->id }}/getDescription" href="#product-description-modal" class="edit-btn left-0 modal-trigger" id="item-modal-trigger" data-name="{{ $featuredProduct->item_name }}" data-id="{{ $featuredProduct->id }}" data-amount="{{ $featuredProduct->item_amount }}"
                 data-description="{{ $featuredProduct->description }}" data-price="{{ $featuredProduct->getDiscountedPrice() }}">
                <i class="fal fa-info-circle"></i>
              </a>
              <div class="product-image">
                <img src="{{ $featuredProduct->getThumbnailImage() }}">
              </div>
              <div class="product-title text-shadow" style="font-size:20px;">
                <span class="pal-blue">{{ $featuredProduct->item_name }}</span> @if($featuredProduct->ironman === 1) <img height="16px" src="{{ asset('img/ironmanicon.png') }}"> @endif
              </div>
              <p class="product-price" style="font-size:14px;">
                @if($featuredProduct->item_discount > 0)
                  <span class="green-text text-darken-3">{{ $featuredProduct->getDiscountedPrice() }} credits</span>
                  <s class="red-text text-darken-3">{{ $featuredProduct->item_price }} credits</s>
                @else
                  <span class="green-text text-darken-3"> {{ $featuredProduct->getDiscountedPrice() }} credits</span>
                @endif
              </p>
              <div style="margin-top: 10px;">
                <a href="/store/#" id="addcart" class="addcart" data-itemid="{{ $featuredProduct->id }}" style="font-size:20px;">Add</a>
              </div>
            </div>
          </div>
        </div>
      @endforeach
    </div>
    <hr>
    <div class="row">
      <div class="col s12 xl9">
        <div class="row" id="pagination" style="display:none;">
          <div class="col s12 xl4 offset-xl4">
            <div class="chip pagebtns" style="width:100%;">
              <div class="left">
                <a href="/store/#" id="pagebtn" data-page="1"><span class="material-icons">first_page</span></a>
                <a href="/store/#" id="pagebtn" class="previous_page"><span class="material-icons">chevron_left</span></a>
              </div>
              <span id="currentPage"></span> / <span id="totalPages"></span>
              <div class="right">
                <a href="/store/#" id="pagebtn" class="next_page"><span class="material-icons">chevron_right</span></a>
                <a href="/store/#" id="pagebtn" class="last_page"><span class="material-icons">last_page</span></a>
              </div>
            </div>
          </div>
        </div>
        <div id="storeitems">
          <div class="loading">
            <div class="loading-inner">
              <h5>Loading</h5>
              <small>Please wait...</small>
            </div>
          </div>
        </div>
        <div class="row" id="pagination" style="display:none;">
          <div class="col s12 xl4 offset-xl4">
            <div class="chip pagebtns" style="width:100%;">
              <div class="left">
                <a href="/store/#" id="pagebtn" data-page="1"><span class="material-icons">first_page</span></a>
                <a href="/store/#" id="pagebtn" class="previous_page"><span class="material-icons">chevron_left</span></a>
              </div>
              <span id="currentPage"></span> / <span id="totalPages"></span>
              <div class="right">
                <a href="/store/#" id="pagebtn" class="next_page"><span class="material-icons">chevron_right</span></a>
                <a href="/store/#" id="pagebtn" class="last_page"><span class="material-icons">last_page</span></a>
              </div>
            </div>
          </div>
        </div>
      </div>
      @include('layout.sidebar.store_sidebar')
    </div>
  </div>
</div>
</div>
</div>
@include('layout.scripts')
<script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@2.4.14/dist/js/splide.min.js" integrity="sha256-OxCXgDfO+MJLFQq9Ej7bedtkP2ho7Rduj/MVlRrVp6U=" crossorigin="anonymous"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@9/dist/sweetalert2.min.js"></script>
{{--TODO: Coinbase, checkout--}}
<div class="modal fade in" id="product-description-modal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content"></div>
  </div>
</div>
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
                                <a data-toggle="modal"
                                data-href="{{ route('api.products') }}/${product.id}/getDescription"
                                href="#product-description-modal"
                                class="edit-btn left-0 modal-trigger"
                                id="item-modal-trigger"
                                data-name="${product.item_name}"
                                data-id="${product.id}"
                                data-amount="${product.item_amount}"
                                data-description="${product.description}"
                                data-price="${price}">
                                    <i class="fal fa-info-circle"></i>
                                </a>
                                <div class="product-image">
                                    <img src="${product.thumbnail_image}">
                                </div>
                                <div class="product-title">
                                    ${product.item_name} (x ${product.item_amount})`;
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
        $(this).find("#price").text(parseFloat(response.price).toFixed(2));
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
  function checkout(totalPrice, currentCredits) {
      console.log(totalPrice);
        if(cartItems.children().length == 0) {
        Swal.fire({
          title: 'No Items',
          text: 'You must have items in your cart before proceeding to the checkout',
          confirmButtonText: 'Close',
          icon: 'error',
          confirmButtonColor: '#f83f3f',
        });
      } else {
            Swal.fire({
                title: 'Are you sure?',
                text: `All store transactions are final. You will spend ${totalPrice} credits, leaving you with ${currentCredits - totalPrice} credits`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, take me to the checkout!'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.replace("{{ route('store.itemCheckout') }}");
                }
            });
        }
  }

  $('.checkoutButton').on('click', function() {
    checkout(parseFloat($('#totalprice').html()), $('#currentCredits').data('credits'));
  });

  function ajaxModal() {
    $('body').on('click', '[data-toggle][data-href]', function () {
      var modal = $($(this).attr('href'));
      $.ajax({
        url: $(this).data().href,
        type: 'GET',
        data: {
          format: 'modal',
        },
        beforeSend: function () {
          $('.productModalLoading').css('display', '');
          $('.productModalContent').css('display', 'none');
        },
        success: function (data) {
          modal.find('.modal-content').html(data);
          $('.productModalLoading').css('display', 'none');
          $('.productModalContent').css('display', '');
          new Splide('.splide', {
            type      : 'loop',
          } ).mount();
        },
        fail: function () {
          modal.modal('hide');
          console.log('Failed to open modal');
        }
      });
    });
  }

  ajaxModal();
</script>
</body>
@include('layout.footer')
</html>