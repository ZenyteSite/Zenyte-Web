var gameDiv = $("#game-activity");
var gameBtn = $("#gamelog-btn");

var pvpDiv = $("#pvp-activity");
var pvpBtn = $("#pvplog-btn");

gameLogAppear();
function gameLogAppear() {
	console.log('here');
    pvpDiv.fadeOut();
    gameDiv.fadeIn();
    addActiveBtnDiv(gameBtn);
}

function pvpLogAppear() {
    gameDiv.fadeOut();
    pvpDiv.fadeIn();
    addActiveBtnDiv(pvpBtn);
}

$("#gamelog-btn").on('click', function (e) {
    e.preventDefault();
    gameLogAppear();
});

$("#pvplog-btn").on('click', function (e) {
    e.preventDefault();
    pvpLogAppear();
});


function addActiveBtnDiv(standardBtn) {
    pvpBtn.removeClass("acc-tab-active");
    gameBtn.removeClass("acc-tab-active");

    standardBtn.addClass("acc-tab-active");
}
