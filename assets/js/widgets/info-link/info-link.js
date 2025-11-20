(function($, elementor) {

    'use strict';

    var widgetInfoLink = function($scope, $) {

        var $fancyTabs = $scope.find('.elematic-info-links'),
            $settings = $fancyTabs.data('settings');

        var iconBx = document.querySelectorAll('#' + $settings.tabs_id + ' .elematic-info-links-item');
        var contentBx = document.querySelectorAll('#' + $settings.tabs_id + ' .elematic-info-links-content');

        for (var i = 0; i < iconBx.length; i++) {
            iconBx[i].addEventListener($settings.mouse_event, function() {
                for (var i = 0; i < contentBx.length; i++) {
                    contentBx[i].className = 'elematic-info-links-content';
                }
                document.getElementById(this.dataset.id).className = 'elematic-info-links-content active';

                for (var i = 0; i < iconBx.length; i++) {
                    iconBx[i].className = 'elematic-info-links-item';
                }
                this.className = 'elematic-info-links-item active';

            });
        }

    };

    jQuery(window).on('elementor/frontend/init', function() {
        elementorFrontend.hooks.addAction('frontend/element_ready/elematic-info-link.default', widgetInfoLink);
    });

}(jQuery, window.elementorFrontend));


