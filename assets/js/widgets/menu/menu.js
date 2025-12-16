!(function($){
  'use strict';

  function initTxMenu($scope){
    var $wrap  = $scope.find('.elematic-menu-wrap');
    var $nav   = $wrap.find('.elematic-navbar');
    var $open  = $wrap.find('.elematic-mobile-nav-show');
    var $close = $wrap.find('.elematic-mobile-nav-hide');

    if (!$nav.length) return;

    // Check if arrows are disabled
    var arrowsDisabled = $wrap.hasClass('elematic-hide-arrows');

    // ------------ mobile dropdown icons (+ / −) ------------
    // Only add dropdown icons if arrows are enabled
    if (!arrowsDisabled) {
      $nav.find('li.menu-item-has-children').each(function(){
        var $li = $(this);
        if (!$li.find('> .elematic--mb-dropdown-icon').length) {
          var $tpl = $wrap.find('.elematic--mb-dropdown-template').first();
          
          // Only proceed if template exists
          if ($tpl.length) {
            $tpl = $tpl.clone().removeAttr('style')
              .removeClass('elematic--mb-dropdown-template')
              .addClass('elematic--mb-dropdown-icon');

            $li.children('a').after($tpl);

            $tpl.on('click', function(e){
              e.preventDefault();
              $li.toggleClass('sub-open');

              // swap closed/opened icons when using dual-state template
              $tpl.find('.icon-closed').toggle(!$li.hasClass('sub-open'));
              $tpl.find('.icon-opened').toggle($li.hasClass('sub-open'));
            });
          }
        }
      });
    }

    // ------------ off-canvas helpers ------------
    // create overlay once
    var $overlay = $wrap.find('.elematic-menu-overlay');
    if(!$overlay.length){
      $overlay = $('<div class="elematic-menu-overlay" aria-hidden="true"></div>');
      // place after nav so z-index stack is correct
      $nav.after($overlay);
    }

    function lockScroll(lock){
      $('html, body').toggleClass('elematic-no-scroll', !!lock);
    }
    function openMenu(){
      $nav.addClass('is-open');
      $overlay.addClass('is-visible');
      $open.hide();
      $close.show().attr('aria-expanded','true').focus();
      $open.attr('aria-expanded','true');
      lockScroll(true);
    }
    function closeMenu(){
      $nav.removeClass('is-open');
      $overlay.removeClass('is-visible');
      $close.hide().attr('aria-expanded','false');
      $open.show().attr('aria-expanded','false').focus();
      $nav.find('.sub-open').removeClass('sub-open');
      lockScroll(false);
    }

    // buttons & overlay
    $open.on('click', function(e){ e.preventDefault(); openMenu(); });
    $close.on('click', function(e){ e.preventDefault(); closeMenu(); });
    $overlay.on('click', closeMenu);

    // esc closes
    $(document).on('keydown.txMenu', function(e){
      if(e.key === 'Escape' && $nav.hasClass('is-open')) closeMenu();
    });

    // auto-close if resizing to desktop
    var mq = window.matchMedia('(min-width: 992px)');
    function handleMQ(ev){ if(ev.matches) closeMenu(); }
    if(mq.addEventListener){ mq.addEventListener('change', handleMQ); }
    else { mq.addListener(handleMQ); } // older browsers
  }

  $(window).on('elementor/frontend/init', function(){
    elementorFrontend.hooks.addAction('frontend/element_ready/elematic-menu.default', initTxMenu);
  });

})(jQuery);