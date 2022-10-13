var countDownDate = new Date("Jun 7, 2019, 17:00:00").getTime();

function createDayDiv(days) {
  var increment = Math.round((days/40)*20) * 5;

  return "<div data-toggle='tooltip' title data-placement='top' data-label='" + days + "d' class='css-bar m-b-0 css-bar-success css-bar-"+increment+" countdown-bit'></div>";
}

function createHourDiv(hours) {
  var increment = Math.round((hours/24)*20) * 5;

  return "<div data-toggle='tooltip' title data-placement='top' data-label='" + hours + "h' class='css-bar m-b-0 css-bar-success css-bar-"+increment+" countdown-bit'></div>";
}

function createMinDiv(mins) {
  var increment = Math.round((mins/60)*20) * 5;

  return "<div data-toggle='tooltip' title data-placement='top' data-label='" + mins + "m' class='css-bar m-b-0 css-bar-success css-bar-"+increment+" countdown-bit'></div>";
}

function createSecondDiv(seconds) {
  var increment = Math.round((seconds/60)*20) * 5;

  return "<div data-toggle='tooltip' title data-placement='top' data-label='" + seconds + "s' class='css-bar m-b-0 css-bar-success css-bar-"+increment+" countdown-bit'></div>";
}

function countdownLoop() {
  if($('#elTwoFactorAuthentication').length > 0) {
	return;
  }

  // Get todays date and time
  var today = new Date();
  var now = new Date(today.valueOf() + today.getTimezoneOffset() * 60000);

  // Find the distance between now and the count down date
  var distance = countDownDate - now;

  // Time calculations for days, hours, minutes and seconds
  var days = Math.floor(distance / (1000 * 60 * 60 * 24));
  var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
  var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
  var seconds = Math.floor((distance % (1000 * 60)) / 1000);

  var dayDiv = createDayDiv(days);
  var hourDiv = createHourDiv(hours);
  var minuteDiv = createMinDiv(minutes);
  var secondDiv = createSecondDiv(seconds);

  document.getElementById("countdown-time").innerHTML = dayDiv + hourDiv + minuteDiv + secondDiv;
}

setInterval(countdownLoop, 1000);
