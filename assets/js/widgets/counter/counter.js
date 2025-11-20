!(function ($) {
  'use strict';

  var widgetCounter = function ($scope, $) {
    var $wrap = $scope.find('.elematic-counter-number-wrapper').eq(0);
    if (!$wrap.length) return;

    var $items = $scope.find('.elematic-counter-number');
    if (!$items.length) return;

    // read shared settings from the first item
    var settings = $items.eq(0).data('settings') || {};
    var duration = parseInt(settings.duration, 10) || 2000;

    var started = false;
    var ns = '.txCounter-' + ($scope.data('id') || Math.random().toString(36).slice(2));

    function inView() {
      var winTop = $(window).scrollTop();
      var winBottom = winTop + $(window).height();
      var top = $wrap.offset().top;
      // visible if bottom of viewport is past the top of the counter
      return winBottom >= top;
    }

    function noScrollNeeded() {
      // fire immediately on short pages
      return $(document).height() <= $(window).height();
    }

    function start() {
      if (started) return;
      if (!inView() && !noScrollNeeded()) return;

      $items.each(function () {
        var $el = $(this);
        // keep decimal precision from the original text
        var raw = ($el.text() || '').trim();
        var decimals = (raw.split('.')[1] || '').length;

        // parse target; allow commas in source text
        var target = parseFloat(raw.replace(/,/g, '')) || 0;

        $el.prop('Counter', 0).animate(
          { Counter: target },
          {
            duration: duration,
            step: function (val) {
              // keep decimals; you can add formatting if you need commas back
              $el.text(parseFloat(val).toFixed(decimals));
            },
          }
        );
      });

      started = true;
      // clean listeners once started
      $(window).off('scroll' + ns + ' resize' + ns + ' load' + ns);
    }

    // bind and also run once immediately
    $(window).on('scroll' + ns + ' resize' + ns + ' load' + ns, start);
    // immediate attempt in case we're already visible in editor or on load
    start();
  };

  $(window).on('elementor/frontend/init', function () {
    elementorFrontend.hooks.addAction('frontend/element_ready/elematic-counter.default', widgetCounter);
  });
})(jQuery);