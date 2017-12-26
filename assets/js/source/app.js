WebFontConfig = {
    google: { families: [ 'Montserrat:500,500i|Nunito+Sans:400,400i' ] }
};
var $source = webfont.src;
(function() {
    var wf = document.createElement('script');
    wf.src = $source;
    wf.type = 'text/javascript';
    wf.async = 'true';

    var s = document.getElementsByTagName('script')[0];
    s.parentNode.insertBefore(wf, s);
})();

(function($){
	$(document).ready(function(){
		$('.gallery').find('br').detach();
		
		// Dynamic Image Sizing
		ajaxurl = webfont.ajaxurl;
		// console.log(ajaxurl);
		/* $('.portfolio-image').each(function() {
			// get the image ratio
			var ratio = new Image();
			ratio.src = $(this).data('src');

			// console.log(ratio);
			
			var targetEl = $(this),
				ajaxData = {
					action: 'resize_my_image', 
					width: $(this).parent().width(), 
					height: $(this).parent().width() * (ratio.height / ratio.width),
					source: $(this).data('src')
				};
			// console.log(ajaxData);
	
			$.getJSON(ajaxurl, ajaxData, function(response) {
				// console.log(response);
				targetEl.attr('src', response.src);
			});
		}); */
	});

	// Window load event with minimum delay
	// @link https://css-tricks.com/snippets/jquery/window-load-event-with-minimum-delay/
	(function fn() {
		fn.now = +new Date;
		$(window).load(function() {
			if (+new Date - fn.now < 500) {
				setTimeout(fn, 500);
			}
			// Do stuffs right here
		});
	})();
})(jQuery);
