;(function($, window, document) {
	$('document').ready(function(){
		var $ci = $('div.calendarmonthview-input').eq(0);

		var lowerLimit = $ci.data('lower-limit');
		var upperLimit = $ci.data('upper-limit');
		var minDuration = $ci.data('min-duration');
		var maxDuration = $ci.data('max-duration');

		$('#calendarmonthview_date_start').datepicker({
			dateFormat: "yy-mm-dd",
			minDate: Math.floor(lowerLimit / 86400),
			maxDate: Math.floor(upperLimit / 86400)
		});

		$('#calendarmonthview_date_end').datepicker({
			dateFormat: "yy-mm-dd",
			minDate: Math.floor(lowerLimit / 86400),
			maxDate: Math.floor((upperLimit + maxDuration) / 86400)
		});

	});
})(jQuery, window, document);
