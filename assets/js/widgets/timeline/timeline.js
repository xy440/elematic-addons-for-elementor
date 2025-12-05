/**
 * Elematic Timeline Widget
 * Refactored for multiple instances support with Elementor frontend hooks
 */

(function($) {
    'use strict';

    var ELematicTimeline = {
        
        /**
         * Initialize timeline for a specific scope
         */
        init: function($scope, $) {
            var $timeline = $scope.find('.elematic-timeline-wrap');
            
            if ($timeline.length === 0) {
                return;
            }

            // Initialize each timeline instance
            $timeline.each(function() {
                var $this = $(this);
                var timelineId = $this.attr('id');
                
                // Prevent double initialization
                if ($this.data('elematic-timeline-initialized')) {
                    return;
                }
                $this.data('elematic-timeline-initialized', true);

                // Initialize vertical timeline
                ELematicTimeline.initVerticalTimeline($this[0]);
                
                // Initialize scroll animations
                ELematicTimeline.initScrollAnimations($this);
                
                // Initialize line height animation
                ELematicTimeline.initLineAnimation($this);
            });
        },

        /**
         * Vertical Timeline Class
         */
        initVerticalTimeline: function(element) {
            var timeline = {
                element: element,
                blocks: element.getElementsByClassName("elematic-timeline-container"),
                images: element.getElementsByClassName("elematic-timeline-icon"),
                contents: element.getElementsByClassName("elematic-timeline-content"),
                offset: 0.8,
                scrolling: false
            };

            // Hide blocks initially
            this.hideBlocks(timeline);

            // Show blocks on scroll with throttling
            var scrollHandler = function() {
                if (!timeline.scrolling) {
                    timeline.scrolling = true;
                    if (!window.requestAnimationFrame) {
                        setTimeout(function() {
                            ELematicTimeline.showBlocks(timeline);
                            timeline.scrolling = false;
                        }, 250);
                    } else {
                        window.requestAnimationFrame(function() {
                            ELematicTimeline.showBlocks(timeline);
                            timeline.scrolling = false;
                        });
                    }
                }
            };

            window.addEventListener("scroll", scrollHandler);
            
            // Store handler for cleanup if needed
            $(element).data('scroll-handler', scrollHandler);
            
            // Initial check
            this.showBlocks(timeline);
        },

        /**
         * Hide timeline blocks outside viewport
         */
        hideBlocks: function(timeline) {
            if (!("classList" in document.documentElement)) {
                return;
            }

            for (var i = 0; i < timeline.blocks.length; i++) {
                if (timeline.blocks[i].getBoundingClientRect().top > window.innerHeight * timeline.offset) {
                    timeline.images[i].classList.add("elematic-vhidden");
                    timeline.contents[i].classList.add("elematic-vhidden");
                }
            }
        },

        /**
         * Show timeline blocks in viewport
         */
        showBlocks: function(timeline) {
            if (!("classList" in document.documentElement)) {
                return;
            }

            for (var i = 0; i < timeline.blocks.length; i++) {
                if (timeline.contents[i].classList.contains("elematic-vhidden") && 
                    timeline.blocks[i].getBoundingClientRect().top <= window.innerHeight * timeline.offset) {
                    
                    timeline.images[i].classList.add("elematic-timeline-icon-bounce-in");
                    timeline.contents[i].classList.add("elematic-timeline-content-bounce-in");
                    timeline.images[i].classList.remove("elematic-vhidden");
                    timeline.contents[i].classList.remove("elematic-vhidden");
                }
            }
        },

        /**
         * Initialize scroll-based highlighting
         */
        initScrollAnimations: function($timeline) {
            var $containers = $timeline.find('.elematic-timeline-container');
            var timelineId = $timeline.attr('id');
            
            if ($containers.length === 0) {
                return;
            }

            var highlightHandler = function(e) {
                var viewportHeight = document.documentElement.clientHeight;
                var zone = [15, 15];
                
                $containers.each(function() {
                    var elm = this;
                    var pos = elm.getBoundingClientRect();
                    var topPerc = pos.top / viewportHeight * 100;
                    var bottomPerc = pos.bottom / viewportHeight * 100;
                    var middle = (topPerc + bottomPerc) / 2;
                    var inViewport = middle > zone[1] && middle < (100 - zone[1]);
                    
                    $(elm).toggleClass('highlight', inViewport);
                });
            };

            // Debounced scroll handler
            var scrollTimeout;
            var debouncedHighlight = function(e) {
                clearTimeout(scrollTimeout);
                scrollTimeout = setTimeout(function() {
                    highlightHandler(e);
                }, 10);
            };

            $(window).on('scroll.elematic-timeline-' + timelineId, debouncedHighlight);
            $(window).on('resize.elematic-timeline-' + timelineId, highlightHandler);
            
            // Initial check
            highlightHandler();
        },

        /**
         * Initialize line height animation
         */
        initLineAnimation: function($timeline) {
            var $containers = $timeline.find('.elematic-timeline-container');
            var $lines = $timeline.find('.elematic-timeline-line-over');
            var timelineId = $timeline.attr('id');
            
            if ($containers.length === 0 || $lines.length === 0) {
                return;
            }

            var contentBlockHeight = [];
            var oldScroll = window.scrollY || window.pageYOffset;

            var scrollHandler = function() {
                var currentScroll = window.scrollY || window.pageYOffset;
                
                // Reset height array
                contentBlockHeight = [];
                
                $containers.each(function(index) {
                    var $container = $(this);
                    var height = $container.outerHeight();
                    contentBlockHeight.push(height);
                    
                    if ($container.hasClass('highlight')) {
                        $container.find('.elematic-timeline-line-over').css('height', height + 'px');
                    }
                });

                // Scroll direction detection
                if (currentScroll > oldScroll) {
                    // Scrolling down
                    $containers.filter('.highlight').prev()
                        .find('.elematic-timeline-line-over')
                        .addClass('elematic-highlighted');
                } else if (currentScroll < oldScroll) {
                    // Scrolling up
                    $containers.filter('.highlight').next()
                        .find('.elematic-timeline-line-over')
                        .removeClass('elematic-highlighted');
                }
                
                oldScroll = currentScroll;
            };

            // Debounced scroll handler
            var scrollTimeout;
            var debouncedScroll = function() {
                clearTimeout(scrollTimeout);
                scrollTimeout = setTimeout(scrollHandler, 10);
            };

            $(window).on('scroll.elematic-timeline-line-' + timelineId, debouncedScroll);
            
            // Initial check
            scrollHandler();
        },

        /**
         * Cleanup function (optional, for dynamic content)
         */
        destroy: function($scope) {
            var $timeline = $scope.find('.elematic-timeline-wrap');
            var timelineId = $timeline.attr('id');
            
            if (timelineId) {
                $(window).off('.elematic-timeline-' + timelineId);
                $(window).off('.elematic-timeline-line-' + timelineId);
            }
            
            $timeline.removeData('elematic-timeline-initialized');
        }
    };

    /**
     * Initialize on Elementor Frontend
     */
    $(window).on('elementor/frontend/init', function() {
        elementorFrontend.hooks.addAction('frontend/element_ready/elematic-timeline.default', ELematicTimeline.init);
    });


})(jQuery);