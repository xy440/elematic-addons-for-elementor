!(function($){
  'use strict';

  function initializeAccordion($scope) {
    const $acc = $scope.find('.elematic-accordion');
    if (!$acc.length) return;

    const initialState = $acc.data('initial-state') || 'first'; // default

    const $titles  = $acc.find('.elematic-accordion-tab-title');
    const $panels  = $acc.find('.elematic-accordion-tab-content');

    // Start collapsed
    $titles.removeClass('elematic-accordion-active');
    $panels.hide();

    if (initialState === 'first' && $titles.length) {
      // Open first only
      $titles.first().addClass('elematic-accordion-active');
      $panels.first().show();
    } else if (initialState === 'all') {
      // Open all
      $titles.addClass('elematic-accordion-active');
      $panels.show();
    }
    // else "none" → all remain closed

    // Click handler
    $acc.on('click', '.elematic-accordion-tab-title', function () {
      const $this = $(this);
      const $content = $this.next('.elematic-accordion-tab-content');

      if ($this.hasClass('elematic-accordion-active')) {
        $this.removeClass('elematic-accordion-active');
        $content.slideUp(400);
      } else {
        // Normal accordion behavior: close others
        $acc.find('.elematic-accordion-tab-title.elematic-accordion-active').removeClass('elematic-accordion-active');
        $acc.find('.elematic-accordion-tab-content').slideUp(400);

        $this.addClass('elematic-accordion-active');
        $content.slideDown(400);
      }
    });
  }

  $(window).on('elementor/frontend/init', function () {
    elementorFrontend.hooks.addAction('frontend/element_ready/elematic-accordion.default', initializeAccordion);
  });
})(jQuery);