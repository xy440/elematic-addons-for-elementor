(function($){
	'use strict';

	/* Table Widget
	------------------------------------- */
	var widgetTable = function($scope, $) {
	var $_this = $scope.find(".elematic-table-wrap"),
		$id = $_this.data("table_id");

		if (typeof enableProSorter !== "undefined" && $.isFunction(enableProSorter)) {
			$(document).ready(function() {
				enableProSorter(jQuery, $_this);
			});
		}

		var $th = $scope.find(".elematic-table").find("th");
		var $tbody = $scope.find(".elematic-table").find("tbody");

		$tbody.find("tr").each(function(i, item) {
			$(item)
				.find("td .td-content-wrapper")
					.each(function(index, item) {
						$(this).prepend('<div class="th-mobile-screen">' + $th.eq(index).html() + "</div>");
				});
		});
	};



	$( window ).on( 'elementor/frontend/init', function() {
	elementorFrontend.hooks.addAction( 'frontend/element_ready/elematic-table.default', widgetTable ); // Table
 		
 	} );


})( jQuery );


/* ---------------------------------------------------------
   EOF
------------------------------------------------------------ */