var data = -1;
var timeLeft = -1;
var endTime = -1;
var base_url = "https://commerce.coinbase.com/charges/";

var trigger = $(".buy-crypto");

var checkout = $("#checkout");
var checkout2 = $("#checkout2");
var title = $("#store-title");
var timeDiv = title;

var packge = $("#package-name");
var orderId = $("#order-id");
var orderId2 = $("#order-id2");
var orderCost = $("#order-cost");
var loading = $("#loading-div");

var slide1 = $("#store-slide-1");
var slide2 = $("#store-slide-2");
var slide3 = $("#store-slide-3");

Date.prototype.addHours = function(h) {
  this.setTime(this.getTime() + (h*60*60*1000));
  return this;
}

function updateTime() {
	timeLeft = endTime - ( new Date().getTime() ) ;
	var hours = Math.floor( (timeLeft % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60) );
	var mins = Math.floor( (timeLeft % (1000 * 60 * 60)) / (1000 * 60) );
	var seconds = Math.floor( (timeLeft % (1000 * 60)) / (1000) );
	
	var payload =  hours + "H " + mins + "M " + seconds + "S";
	
	$("#time-left").html(payload);
}

function initializeTime() {
	startTime = new Date().getTime();
	endTime = new Date().addHours(1).getTime() - 2000;
	
	timeLeft = endTime - startTime;
	title.html("Crypto payment | Time remaining: <span class='pal-blue' id='time-left'>0H 59M 58S</span>");
	timeDiv = $("#time-left");
	setInterval(function() {
		updateTime()
	}, 1000);
}

function completeTransaction() {
	$("#status-icon").attr("src", "/img/check.png");
	$("#order-status").removeClass("pal-gold");
	$("#order-status").addClass("pal-dgreen");
	$("#order-status").html("Completed");
}

function stopLoading(divName) {
	loading.fadeOut(300, function() {
		divName.fadeIn(100);
	});
}

trigger.click(function() {
	productId = $(this).data("id");
	var credits = parseInt( $(this).data("credits") )
	var bonus = parseInt( $(this).data("bonus") );
	var holiday = parseInt( $(this).data("holiday") );
	var totalCredits = credits + holiday + bonus;
	
	$.post("https://zenyte.com/crypto/request", {item_id: productId}, function(url) {
		checkout.attr("href", base_url + url);
		checkout2.attr("href", base_url + url);
		orderId.html(url);
		orderId2.html("Order ID: <span class='pal-blue'>" + url + "</span>");
		initializeTime();
	});
	
	packge.html( $(this).data("credits") + " Zenyte Credits"  );
	orderCost.html( "$" + $(this).data("cost") + ".00 USD" );
	
	$("#crypto-table").html(`
		Base credits: ${credits} credits<br>
		Bonus credits: ${bonus} credits<br>
		Holiday credits: ${holiday} credits<br>
		<strong>Total credits: ${totalCredits} credits</strong>
	`);
		
	slide1.fadeOut("slow", function() {
		loading.fadeIn("slow");
		setTimeout(function() {
			stopLoading(slide2)
		}, 1200);
	});
	
});

checkout.click(function() {
	slide2.fadeOut("slow");
	slide3.fadeIn("slow");
});
