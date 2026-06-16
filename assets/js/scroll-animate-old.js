!( function ( $ ) {

    'use strict';

    $( window ).on( 'elementor/frontend/init', function () {

        gsap.registerPlugin( ScrollTrigger );

        elementorFrontend.hooks.addAction(
            'frontend/element_ready/global',
            function ( $scope ) {

                // Never animate inside the Elementor editor
                if ( window.elementorFrontend && elementorFrontend.isEditMode() ) {
                    return;
                }

                // Only target widget wrappers, not sections/columns/containers
                if ( ! $scope.hasClass( 'elementor-widget' ) ) {
                    return;
                }

                var el    = $scope[0];
                var delay = $scope.parent().index() * 0.15;

                gsap.from( el, {
                    opacity: 0,
                    y: 50,
                    duration: 0.7,
                    delay: delay,
                    ease: 'power2.out',
                    clearProps: 'all',  // clean up inline styles after animation completes
                    scrollTrigger: {
                        trigger: el,
                        start: 'top 85%',
                        once: true,
                    },
                } );
            }
        );

    } );

} )( jQuery );