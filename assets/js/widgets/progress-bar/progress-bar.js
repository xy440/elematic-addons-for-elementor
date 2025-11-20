(function ($) {
    'use strict';

    var widgetProgressBar = function ($scope) {
        var $wrappers = $scope.find('.elematic-progress-bar-wrapper');

        if (!$wrappers.length) {
            return;
        }

        var hasIO = 'IntersectionObserver' in window;

        $wrappers.each(function () {
            var $wrapper = $(this);
            var $bar = $wrapper.find('.elematic-progress-bar');

            if (!$bar.length) {
                return;
            }

            var value = parseFloat($bar.attr('aria-valuenow')) || 0;
            var isVertical = $wrapper.hasClass('elematic-progress-bar-style-vertical');

            // start from 0 so the transition is visible
            if (isVertical) {
                $bar.css('height', '0');
            } else {
                $bar.css('width', '0');
            }

            var animateBar = function () {
                if ($bar.data('elematic-animated')) {
                    return;
                }
                $bar.data('elematic-animated', true);

                if (isVertical) {
                    $bar.css('height', value + '%');
                } else {
                    $bar.css('width', value + '%');
                }
            };

            if (hasIO) {
                var observer = new IntersectionObserver(function (entries, obs) {
                    entries.forEach(function (entry) {
                        if (entry.isIntersecting) {
                            animateBar();
                            obs.unobserve(entry.target);
                        }
                    });
                }, { threshold: 0.3 });

                observer.observe($bar[0]);
            } else {
                // fallback: animate immediately
                animateBar();
            }
        });
    };

    $(window).on('elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction(
            'frontend/element_ready/elematic-progress-bar.default',
            widgetProgressBar
        );
    });

})(jQuery);