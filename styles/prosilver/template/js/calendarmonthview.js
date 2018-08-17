;(function($, window, document) {
	$('document').ready(function(){
		var $topic = $('table tr td[data-topic]');
		$topic.hover(function(){
			var t = $(this).data('topic');
			$('table tr td[data-topic="' + t + '"').each(function(){
				$(this).removeClass('calendarevent-hover');
			});
		}, function(){
			t = $(this).data('topic');
			$('table tr td[data-topic="' + t + '"').each(function(){
				$(this).removeClass('calendarevent-hover');
			});
		});
	});
})(jQuery, window, document);
