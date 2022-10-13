$(document).ready(function() {
    var currentPath     = '/store';
    var locked          = false;
    var lastCategory    = -1;
    var currentPage     = 1;
    var storeItems      = $('#storeitems');
    var catTitle        = $('.cattitle');
    var searchField     = $('#item');
    var cartItems       = $('#cartitems');
	var timer 			= null;

    loadItems(lastCategory, 1);

    searchField.on('keyup', function() {
    	var input = searchField.val();

    	if (timer != null) {
    		clearTimeout(timer);
    		timer = null;
    	}

    	timer = setTimeout(function() {
    		if (input == '') {
	            loadItems(lastCategory, currentPage);
	        } else {
	        	if (input.length == 1) {
	        		return;
	        	}
	            $.post(currentPath+"/search", { 
	            	searchfor: input 
	            }).done(function(data) {
	                storeItems.html(data.toString());
	            });
	        }
    	}, 700);
    });

    $(document).on("click", "#pagebtn",  function(e) {
        e.preventDefault();

        var pageNumber = $(this).data('page');
        var pattern = /^[0-9]+$/;

        if (!pattern.test(''+pageNumber+'') || pageNumber == currentPage || locked) {
            return;
        }

        currentPage = pageNumber;
        locked = true;

        loadItems(lastCategory, pageNumber);
    });

    $(document).on("click", "#storecat",  function(e) {
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

    $(document).on("click", "#emptycart",  function(e) {
        e.preventDefault();

        if (locked) {
            return;
        }

        locked = true;

        $.post(currentPath+"/emptycart").done(function(data) {
            Materialize.toast('<i class="material-icons left">check</i>'+data.toString(), 2000, 'toast-success');
            cartItems.html("");
            $('#totalprice').text("0");
            locked = false;
        });
    });

    $(document).on("click", "#addcart",  function(e) {
        e.preventDefault();

        if (locked) {
            return;
        }

        locked = true;
        var item_id = $(this).data('itemid');

        $.post(currentPath+"/addcart", { itemId:  item_id }).done(function(data) {
            try {
                var response = jQuery.parseJSON(data.toString());
                var alertText = "";

                if (updateCartItem(response)) {
                    alertText = 'You added another '+response.item_name+' to your cart!';
                } else {
                    alertText = 'x'+response.quantity+' '+response.item_name+' has been added to your cart!';
                    addToCart(response);
                }
                Materialize.toast('<img src="/img/item-images/'+response.idno+'.png" class="left">'+alertText, 2000, 'toast-success');
                $('#totalprice').text(response.total);
                locked = false;
            } catch(err) {
                Materialize.toast('<i class="material-icons left">error_outline</i>'+data.toString(), 2000, 'toast-error');
                locked = false;
            }
        });
    });

    function loadItems(categoryId, pageNumber) {
        $.post(currentPath+"/category", { catId: categoryId, page: pageNumber }).done(function(data) {
            $('#storeitems').html(data);
            locked = false;
        });
    }

    function loadItemsFade(categoryId, categoryTitle, pageNumber) {
        storeItems.fadeOut("fast", function() {
            catTitle.text(categoryTitle);
            $.post(currentPath+"/category", { catId: categoryId, page: pageNumber }).done(function(data) {
                storeItems.html(data);
                storeItems.fadeIn("fast", function() {
                    locked = false;
                    currentPage = 1;
                });
            });
        });
    }

    function updateCartItem(response) {
        var found = false;
        $("div[id^='cartitem']").each(function() {
            if ($(this).data("itemid") == response.item_id) {
                $(this).find('#quantity').text(response.quantity);
                $(this).find("#price").text(response.price);
                found = true;
                return false;
            }
        });
        return found;
    }

    function addToCart(response) {
        var id          = response.item_id;
        var name        = response.item_name;
        var price       = response.price;
        var discount    = response.discount;
        var itemno      = response.idno;
        var quantity    = response.quantity;

        cartItems.append(
            "<div class=\"collection-item\" id=\"cartitem\" data-itemid='"+id+"'>" +
            "<div class='left' style='margin-right:10px;'><img src='/img/item-images/"+itemno+".png'></div>" +
            "x<span id=\"quantity\">"+quantity+"</span> "+name+"<br>" +
            "<small><span id=\"price\">"+price+"</span> RC</small>" +
            "</div>");
    }

});
