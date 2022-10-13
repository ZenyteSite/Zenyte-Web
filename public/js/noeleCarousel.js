function processCarPages(page) {
	var pages = document.querySelectorAll(".carousel-page-icons li");
	var index = 0;
	for(index = 0; index < pages.length; index++) {
		if(pages[index].className == "page-active") {
			$(pages[index]).removeClass("page-active");
			break;
		}
	}	
	$(pages[page]).addClass("page-active");
}

function processCarousel(page) {
	var images = document.querySelectorAll("#item-imgs-carousel li");
	var index;
	for(index = 0; index < images.length; index++) {
		if(images[index].className == "store-active") {
			$(images[index]).removeClass("store-active");
			break;
		}
	}
	
	$(images[page]).addClass("store-active");
	processCarPages(page);
}

function storeCarolNext() {
	var images = document.querySelectorAll("#item-imgs-carousel li");
	var index;
	var endIndex = 0;
	for(index = 0; index < images.length; index++) {
		if(images[index].className == "store-active") {
			if((index+1) != images.length) {
				endIndex = index + 1;
				break;
			}
		}
	}
	
	if(endIndex == 0) {
		$(images[images.length-1]).removeClass("store-active");
		$(images[0]).addClass("store-active");
	} else {
		$(images[endIndex-1]).removeClass("store-active");
		$(images[endIndex]).addClass("store-active");
	}
	
	processCarPages(endIndex);
}

function storeCarolPrev() {
	var images = document.querySelectorAll("#item-imgs-carousel li");
	var index;
	var endIndex = 0;
	for(index = 0; index < images.length; index++) {
		if(images[index].className == "store-active") {
			if(index != 0)
				endIndex = index - 1;
			else
				endIndex = images.length-1;
			
			break;
		}
	}
	
	$(images[index]).removeClass("store-active");
	$(images[endIndex]).addClass("store-active");
	processCarPages(endIndex);
}