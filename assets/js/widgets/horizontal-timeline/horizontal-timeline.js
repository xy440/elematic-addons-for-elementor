/**
 * Horizontal Timeline JavaScript
 */

(function($) {
    'use strict';

    var HorizontalTimeline = function($wrapper) {
        this.$wrapper = $wrapper;
        this.$container = $wrapper.find('.elematic-htl-container');
        this.$track = $wrapper.find('.elematic-htl-track');
        this.$progress = $wrapper.find('.elematic-htl-line-progress');
        this.$prevBtn = $wrapper.find('.elematic-htl-nav-prev');
        this.$nextBtn = $wrapper.find('.elematic-htl-nav-next');
        this._resizeTimer = null;
        
        this.init();
    };

    HorizontalTimeline.prototype = {
        init: function() {
            this.bindEvents();
            this.updateProgress();
            this.updateNavState();
            this.updateStyle2DateHeight();
        },

        // Returns a scroll amount relative to the visible container width,
        // so it feels natural on both desktop and narrow mobile screens.
        getScrollAmount: function() {
            var containerWidth = this.$container.outerWidth();
            // Scroll ~70% of the visible width, min 100px, max 350px
            return Math.min(350, Math.max(100, Math.floor(containerWidth * 0.7)));
        },

        // For Style 2: measure the tallest .elematic-htl-date element and set
        // --htl-date-height on the track so the CSS calc() stays accurate.
        updateStyle2DateHeight: function() {
            var $dates = this.$track.find('.elematic-htl-date');
            if (!$dates.length) return;

            var maxH = 0;
            $dates.each(function() {
                var h = $(this).outerHeight(true);
                if (h > maxH) maxH = h;
            });

            this.$track[0].style.setProperty('--htl-date-height', maxH + 'px');
        },

        bindEvents: function() {
            var self = this;

            // Navigation buttons
            this.$prevBtn.on('click', function(e) {
                e.preventDefault();
                self.scrollPrev();
            });

            this.$nextBtn.on('click', function(e) {
                e.preventDefault();
                self.scrollNext();
            });

            // Scroll event for progress
            this.$container.on('scroll', function() {
                self.updateProgress();
                self.updateNavState();
            });

            // Keyboard navigation
            this.$wrapper.on('keydown', function(e) {
                if (e.keyCode === 37) { // Left arrow
                    self.scrollPrev();
                } else if (e.keyCode === 39) { // Right arrow
                    self.scrollNext();
                }
            });

            // Window resize
            $(window).on('resize', function() {
                clearTimeout(self._resizeTimer);
                self._resizeTimer = setTimeout(function() {
                    self.updateProgress();
                    self.updateNavState();
                    self.updateStyle2DateHeight();
                }, 150);
            });
        },

        scrollPrev: function() {
            var currentScroll = this.$container.scrollLeft();
            var newScroll = Math.max(0, currentScroll - this.getScrollAmount());
            
            this.$container.animate({
                scrollLeft: newScroll
            }, 300, 'swing');
        },

        scrollNext: function() {
            var currentScroll = this.$container.scrollLeft();
            var maxScroll = this.$container[0].scrollWidth - this.$container.outerWidth();
            var newScroll = Math.min(maxScroll, currentScroll + this.getScrollAmount());
            
            this.$container.animate({
                scrollLeft: newScroll
            }, 300, 'swing');
        },

        updateProgress: function() {
            var scrollLeft = this.$container.scrollLeft();
            var maxScroll = this.$container[0].scrollWidth - this.$container.outerWidth();
            
            if (maxScroll <= 0) {
                this.$progress.css('width', '100%');
                return;
            }

            var percentage = (scrollLeft / maxScroll) * 100;
            this.$progress.css('width', percentage + '%');
        },

        updateNavState: function() {
            var scrollLeft = this.$container.scrollLeft();
            var maxScroll = this.$container[0].scrollWidth - this.$container.outerWidth();

            // Disable/enable prev button
            if (scrollLeft <= 0) {
                this.$prevBtn.prop('disabled', true);
            } else {
                this.$prevBtn.prop('disabled', false);
            }

            // Disable/enable next button
            if (scrollLeft >= maxScroll - 1) {
                this.$nextBtn.prop('disabled', true);
            } else {
                this.$nextBtn.prop('disabled', false);
            }
        }
    };

    // Initialize for Elementor
    $(window).on('elementor/frontend/init', function() {
        elementorFrontend.hooks.addAction('frontend/element_ready/elematic-horizontal-timeline.default', function($scope) {
            var $wrapper = $scope.find('.elematic-htl-wrapper');
            if ($wrapper.length) {
                new HorizontalTimeline($wrapper);
            }
        });
    });


})(jQuery);