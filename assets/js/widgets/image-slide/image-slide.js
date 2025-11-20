!(function($){
	'use strict';

	var widgetImageSlide = function( $scope, $ ) {
		var image_slide = $scope.find('.elematic-image-slide-wrap').eq(0);

		if ( image_slide.length > 0 ) {
			var settings     = image_slide.data('settings'),
				speed        = settings.speed,
				direction    = settings.direction,
				pauseonhover = settings.pauseonhover,
				clone        = settings.clone,
				customHeight = settings.widgetHeight || null;

			// Wait for images to load before init
			var $imgs = image_slide.find('img');
			var initSlider = function(){
				// Kill any previous inline height
				image_slide.parent('.infiniteslide_wrap').css('height','');

				// Init infiniteslide
				image_slide.infiniteslide({
					speed: speed,
					direction: direction,
					'pauseonhover': pauseonhover,
					'clone': clone,
				});

				// ✅ Force container height (if customHeight set)
				if (direction === 'up' || direction === 'down') {
					var $wrap = image_slide.parent('.infiniteslide_wrap');
					if (customHeight) {
						$wrap.css({
							'height': customHeight + 'px',
							'overflow': 'hidden'
						});
					} else {
						$wrap.css('height',''); // let it auto
					}
				}
			};

			// Check if images already loaded
			var allLoaded = true;
			$imgs.each(function(){
				if (!this.complete) { allLoaded = false; return false; }
			});

			if (allLoaded) {
				initSlider();
			} else {
				// Run when all images finish
				$imgs.on('load', function(){
					if ($imgs.filter(function(){ return !this.complete; }).length === 0) {
						initSlider();
					}
				});
			}
		}
	};

	$( window ).on( 'elementor/frontend/init', function() {
		elementorFrontend.hooks.addAction(
			'frontend/element_ready/elematic-image-slide.default',
			widgetImageSlide
		);
	});
})( jQuery );