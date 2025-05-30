$(document).ready(function() {		
	// initiate layout and plugins
	$('#sidebar .has-sub > a').click(function () {
		var sub = $(this).next();
		if (sub.is(":visible")) {
			$('.arrow', jQuery(this)).removeClass("open");
			sub.slideUp(200);
		} else {
			$('.arrow', jQuery(this)).addClass("open");
			sub.slideDown(200);
		}
	});
});