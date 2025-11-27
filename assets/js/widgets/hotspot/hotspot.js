!(function($){
	'use strict';

	/* Hotspot Widget
	------------------------------------- */
	var widgetHotspot = function( $scope, $ ) {
	var txHotspot = $scope.find('.elematic-hs-item').eq(0);

		if ( !txHotspot.length ) {
            return;
        }
				var pop = $('.elematic-hs-popup');
			      pop.on('click', function(e) {
			        e.stopPropagation();
			    });
			      
			    $('.elematic-hs-marker').on('click', function(e) {
			        e.preventDefault();
			        e.stopPropagation();
			        $(this).next('.elematic-hs-popup').toggleClass('open');
			        $(this).parent().siblings().children('.elematic-hs-popup').removeClass('open');
			    });
			      
			    $(document).on('click', function() {
			        pop.removeClass('open');
			    });
			      
			    pop.each(function() {
			        var w = $(window).outerWidth(),
			            edge = Math.round( ($(this).offset().left) + ($(this).outerWidth()) );
			        if( w < edge ) {
			          $(this).addClass('edge');
			        }
			    });
  	};

	$( window ).on( 'elementor/frontend/init', function() {
		elementorFrontend.hooks.addAction( 'frontend/element_ready/elematic-hotspot.default', widgetHotspot ); // hotspot
 		
 	} );


})( jQuery );


/* ---------------------------------------------------------
   EOF
------------------------------------------------------------ */