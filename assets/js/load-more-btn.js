(function($) {
    'use strict';

    /**
     * Generalized function to handle the "Load More" functionality for any widget instance.
     * @param {jQuery} $scope - The widget scope
     * @param {string} widgetName - The widget name (post-grid, portfolio, etc.)
     */
    var widgetLoadMore = function($scope, widgetName) {
        // Find the specific grid wrapper and button within this widget scope
        var $gridWrapper = $scope.find('.elematic-' + widgetName + '-wrapper').eq(0);
        var $button = $scope.find('.elematic-load-more-btn').eq(0);

        // Check if we have both elements
        if (!$gridWrapper.length || !$button.length) {
            return;
        }

        // Retrieve the unique settings and other attributes associated with this button
        var loadingText = $button.data('loading-text') || 'Loading...';
        var loadMoreText = $button.data('load-more-text') || 'Load More';
        var noMoreText = $button.data('no-more-text') || 'No more posts';
        var settings = $button.data('settings');
        var page = parseInt($button.data('page'), 10) || 1;

        // Validate settings
        if (!settings) {
            return;
        }

        // Check if AJAX URL is available
        if (typeof elematic_load_more_params === 'undefined') {
            return;
        }

        // Check if the widget is a portfolio and if Isotope needs to be initialized
        var isIsotopeInitialized = widgetName === 'portfolio' && 
                                   typeof $.fn.isotope !== 'undefined' && 
                                   $gridWrapper.hasClass('isotope-initialized');

        // If Isotope is not initialized and this is a portfolio widget, initialize it
        if (widgetName === 'portfolio' && !isIsotopeInitialized && typeof $.fn.isotope !== 'undefined') {
            $gridWrapper.isotope({
                itemSelector: '.elematic-portfolio-item',
                layoutMode: 'fitRows',
                percentPosition: true,
            });
            $gridWrapper.addClass('isotope-initialized');
        }

        // Add click event listener for "Load More" button
        $button.on('click', function(event) {
            event.preventDefault();

            // Increment the page number for loading the next set of posts
            page++;

            // Change the button text to show loading
            $button.text(loadingText).addClass('elematic__loading').prop('disabled', true);

            $.ajax({
                url: elematic_load_more_params.ajaxurl,
                type: 'POST',
                data: {
                    action: 'load_more_posts',
                    settings: settings,
                    page: page,
                    nonce: elematic_load_more_params.nonce
                },
                success: function(response) {
                    if (response.success) {
                        // Check if HTML is present
                        if (!response.data || !response.data.html) {
                            $button.text(noMoreText).removeClass('elematic__loading').prop('disabled', true).addClass('elematic-no-more-posts');
                            return;
                        }

                        // Create new items and hide them initially
                        var $newItems = $(response.data.html);
                        
                        if ($newItems.length) {
                            // Add initial state class for animation
                            $newItems.addClass('elematic-item-loading');
                            
                            // Append new posts to the grid
                            $gridWrapper.append($newItems);

                            // Smooth scroll to first new item (optional, adjust offset as needed)
                            var scrollOffset = $newItems.first().offset().top - 100;
                            $('html, body').animate({
                                scrollTop: scrollOffset
                            }, 600);

                            // Check if the widget is the portfolio widget and Isotope is available
                            if (widgetName === 'portfolio' && typeof $.fn.isotope !== 'undefined') {
                                // Initialize or update Isotope layout for the new items
                                $gridWrapper.isotope('appended', $newItems);
                                
                                // Re-layout after images are loaded
                                if (typeof $gridWrapper.imagesLoaded === 'function') {
                                    $gridWrapper.imagesLoaded().progress(function() {
                                        $gridWrapper.isotope('layout');
                                    });
                                }

                                // Ensure new items are visible and remove Elementor entrance animation effects
                                $newItems.find('.elementor-invisible').removeClass('elementor-invisible');
                                
                                // Reinitialize Bootstrap modals for newly appended items
                                $newItems.find('[data-bs-toggle="modal"]').each(function() {
                                    $(this).modal();
                                });
                            }

                            // Trigger animation after a brief delay
                            setTimeout(function() {
                                $newItems.each(function(index) {
                                    var $item = $(this);
                                    // Stagger the animation for each item
                                    setTimeout(function() {
                                        $item.removeClass('elematic-item-loading').addClass('elematic-item-loaded');
                                    }, index * 100); // 100ms delay between each item
                                });
                            }, 50);

                            // Reset button text and status after animation starts
                            setTimeout(function() {
                                $button.text(loadMoreText).removeClass('elematic__loading').prop('disabled', false);
                                $button.data('page', page);
                            }, 300);

                        } else {
                            $button.text(noMoreText).removeClass('elematic__loading').prop('disabled', true).addClass('elematic-no-more-posts');
                        }
                    } else {
                        // No more posts available
                        $button.text(noMoreText).removeClass('elematic__loading').prop('disabled', true).addClass('elematic-no-more-posts');

                        // Set a timeout to remove the "No more posts" message and hide the button after 5 seconds
                        setTimeout(function() {
                            $button.fadeOut(500, function() {
                                $button.remove();
                            });
                        }, 5000);
                    }
                },
                error: function(xhr, status, error) {
                    // Reset button on error
                    $button.text(loadMoreText).removeClass('elematic__loading').prop('disabled', false);
                }
            });
        });
    };

    // Attach the generalized function to Elementor's frontend hooks
    $(window).on('elementor/frontend/init', function() {
        // Post Grid widget
        elementorFrontend.hooks.addAction('frontend/element_ready/elematic-post-grid.default', function($scope) {
            widgetLoadMore($scope, 'post-grid');
        });

        // Portfolio widget (if you have one)
        elementorFrontend.hooks.addAction('frontend/element_ready/elematic-portfolio.default', function($scope) {
            widgetLoadMore($scope, 'portfolio');
        });
    });

})(jQuery);