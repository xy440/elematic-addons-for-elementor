!(function($){
	'use strict';

	/* Gallery Widget
	------------------------------------- */
	var widgetGallery = function( $scope, $ ) {
	var txGallery = $scope.find('.elematic-gallery-wrap').eq(0);
		
		if ( !txGallery.length ) {
            return;
        }

        var settings = txGallery.data("settings"),
        	find_id = txGallery.find( '.elematic-gallery-item' ),
        	find_grid_id = txGallery.find( '.elematic-gallery-grid' ),
        	find_filter_id = txGallery.find( '.elematic-gallery-filter-item' ),
        	find_fls_id = txGallery.find( '.elematic-gallery-filters' ),
        	find_search_id = txGallery.find( '.elematic-gallery-search-input' ),
			id = $(find_id).attr('id'),
			gid = $(find_grid_id).attr('id'),
			fid = $(find_filter_id).attr('id'),
			flsid = $(find_fls_id).attr('id'),
			sid = $(find_search_id).attr('id'),
			transitionDuration = settings["transitionDuration"] ? 400:0,
			columnWidth = settings["gall_cols"],
			layoutMode  = settings["layoutMode"];

        var buttonFilters = {},
			buttonFilter,
			qsRegex;

        //init Isotope
		var $grid = $('#' + gid).imagesLoaded( function() {
		$grid.isotope({
		  itemSelector: '#' + id,
		  percentPosition: true,
		  transitionDuration: transitionDuration, // 400
		  hiddenStyle: {
		    opacity: 0,
		  },
		  visibleStyle: {
		    opacity: 1,
		  },
		  filter: function() {
		    var $this = $(this);
		    var searchResult = qsRegex ? $this.text().match( qsRegex ) : true;
		    var buttonResult = buttonFilter ? $this.is( buttonFilter ) : true;
		    return searchResult && buttonResult;
		  },

		  layoutMode: layoutMode,  
		  masonry: {
		    columnWidth: columnWidth,
		  },

		})
		});

		// // bind filter button click
		$('#' + flsid).on( 'click', '#' + fid, function() {
		  var $this = $(this);
		  // get group key
		  var $buttonGroup = $this.parents('#' + fid);
		  var filterGroup = $buttonGroup.attr('data-filter-group');
		  // set filter for group
		  buttonFilters[ filterGroup ] = $this.attr('data-filter');
		  // combine filters
		  buttonFilter = concatValues( buttonFilters );
		  // Isotope arrange
		  $grid.isotope();
		});

		// use value of search field to filter
		var $quicksearch = $('#' + sid).keyup( debounce( function() {
		  qsRegex = new RegExp( $quicksearch.val(), 'gi' );
		  $grid.isotope();
		}, 200 ) );

		// flatten object by concatting values
		function concatValues( obj ) {
		  var value = '';
		  for ( var prop in obj ) {
		    value += obj[ prop ];
		  }
		  return value;
		}
		
		// debounce so filtering doesn't happen every millisecond
		function debounce( fn, threshold ) {
		  var timeout;
		  threshold = threshold || 100;
		  return function debounced() {
		    clearTimeout( timeout );
		    var args = arguments;
		    var _this = this;
		    function delayed() {
		      fn.apply( _this, args );
		    }
		    timeout = setTimeout( delayed, threshold );
		  };
		}

        // active filter
        $('.elematic-gallery-filter-item').on('click', function() {
        $(this).siblings().removeClass('active');
        $(this).addClass('active');
    	});

    };


	$( window ).on( 'elementor/frontend/init', function() {
		elementorFrontend.hooks.addAction( 'frontend/element_ready/elematic-gallery.default', widgetGallery ); // Gallery
 	} );


})( jQuery );


/* ---------------------------------------------------------
   EOF
------------------------------------------------------------ */