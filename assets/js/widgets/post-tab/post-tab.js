/**
 * Posts Tab Widget - JavaScript
 * 
 */

(function ($) {
    'use strict';

    var AvasPostsTab = {

        init: function () {
            this.bindEvents();
        },

        bindEvents: function () {
            // Handle Elementor frontend init (editor + frontend)
            $(window).on('elementor/frontend/init', function () {
                elementorFrontend.hooks.addAction(
                    'frontend/element_ready/elematic-post-tab.default',
                    AvasPostsTab.initWidget
                );
            });

        },

        initWidget: function ($scope) {
            var $wrapper = $scope.hasClass('elematic-posts-tab-wrapper')
                ? $scope
                : $scope.find('.elematic-posts-tab-wrapper');

            if (!$wrapper.length) return;

            var trigger = $wrapper.data('trigger') || 'click';

            var $tabs    = $wrapper.find('.elematic-tab-item');
            var $panes   = $wrapper.find('.elematic-tab-pane');

            function switchTab(termId) {
                $tabs.removeClass('elematic-active');
                $panes.removeClass('elematic-active');

                $tabs.filter('[data-tab="' + termId + '"]').addClass('elematic-active');
                $panes.filter('[data-tab-content="' + termId + '"]').addClass('elematic-active');
            }

            if (trigger === 'mouseover') {
                $tabs.on('mouseenter', function () {
                    switchTab($(this).data('tab'));
                });
            } else {
                // Default: click
                $tabs.on('click', function () {
                    switchTab($(this).data('tab'));
                });
            }
        }
    };

    AvasPostsTab.init();

}(jQuery));