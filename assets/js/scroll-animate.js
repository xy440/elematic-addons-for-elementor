!( function ( $ ) {

    'use strict';

    // ─────────────────────────────────────────────────────────────────────────
    // Entrance animation: map type → GSAP "from" vars
    // ─────────────────────────────────────────────────────────────────────────
    function getEntranceVars( type ) {
        switch ( type ) {
            case 'fade-up':    return { opacity: 0, y: 60 };
            case 'fade-down':  return { opacity: 0, y: -60 };
            case 'fade-left':  return { opacity: 0, x: 60 };
            case 'fade-right': return { opacity: 0, x: -60 };
            case 'zoom-in':    return { opacity: 0, scale: 0.6 };
            case 'zoom-out':   return { opacity: 0, scale: 1.4 };
            case 'flip-up':    return { opacity: 0, rotationX: 90, transformOrigin: 'top center', transformPerspective: 800 };
            case 'flip-left':  return { opacity: 0, rotationY: 90, transformOrigin: 'left center', transformPerspective: 800 };
            case 'slide-up':   return { opacity: 0, y: '100%' };
            case 'slide-left': return { opacity: 0, x: 100 };
            case 'slide-right':return { opacity: 0, x: -100 };
            case 'bounce-in':  return { opacity: 0, scale: 0.2 };
            case 'rotate-in':  return { opacity: 0, rotation: -180, transformOrigin: 'center center' };
            case 'skew-in':    return { opacity: 0, skewX: 30 };
            default:           return { opacity: 0, y: 50 };
        }
    }

    // ─────────────────────────────────────────────────────────────────────────
    // Init entrance animation for one element
    // ─────────────────────────────────────────────────────────────────────────
    function initEntrance( el, settings ) {
        var fromVars       = getEntranceVars( settings.type );
        var duration       = settings.duration      || 0.7;
        var delay          = settings.delay         || 0;
        var ease           = settings.ease          || 'power2.out';
        var offset         = settings.offset        || 85;
        var useStagger     = settings.stagger       === 'yes';
        var staggerDelay   = settings.stagger_delay || 0.15;

        var triggerConfig = {
            trigger : el,
            start   : 'top ' + offset + '%',
            once    : true,
        };

        if ( useStagger ) {
            // Animate direct children with a stagger
            var children = Array.from( el.children );
            if ( children.length > 1 ) {
                gsap.from( children, Object.assign( {}, fromVars, {
                    duration    : duration,
                    delay       : delay,
                    ease        : ease,
                    stagger     : staggerDelay,
                    clearProps  : 'all',
                    scrollTrigger: triggerConfig,
                } ) );
                return;
            }
        }

        gsap.from( el, Object.assign( {}, fromVars, {
            duration   : duration,
            delay      : delay,
            ease       : ease,
            clearProps : 'all',
            scrollTrigger: triggerConfig,
        } ) );
    }

    // ─────────────────────────────────────────────────────────────────────────
    // Init while-scrolling effect for one element
    // ─────────────────────────────────────────────────────────────────────────
    function initScrollEffect( el, settings ) {
        var effect   = settings.effect;
        var startVal = parseFloat( settings.start_val );
        var endVal   = parseFloat( settings.end_val );
        var scrub    = settings.scrub === 'true' ? true : parseFloat( settings.scrub ) || 1;

        var scrollTriggerConfig = {
            trigger : el,
            start   : 'top bottom',
            end     : 'bottom top',
            scrub   : scrub,
        };

        switch ( effect ) {
            case 'parallax-y':
                gsap.fromTo( el, { y: startVal }, { y: endVal, ease: 'none', scrollTrigger: scrollTriggerConfig } );
                break;

            case 'parallax-x':
                gsap.fromTo( el, { x: startVal }, { x: endVal, ease: 'none', scrollTrigger: scrollTriggerConfig } );
                break;

            case 'fade':
                gsap.fromTo( el,
                    { opacity: Math.max( 0, Math.min( 1, startVal ) ) },
                    { opacity: Math.max( 0, Math.min( 1, endVal ) ), ease: 'none', scrollTrigger: scrollTriggerConfig }
                );
                break;

            case 'scale':
                gsap.fromTo( el,
                    { scale: startVal || 0.8 },
                    { scale: endVal   || 1.2, ease: 'none', scrollTrigger: scrollTriggerConfig }
                );
                break;

            case 'rotate':
                gsap.fromTo( el,
                    { rotation: startVal },
                    { rotation: endVal, ease: 'none', scrollTrigger: scrollTriggerConfig }
                );
                break;

            case 'skew':
                gsap.fromTo( el,
                    { skewY: startVal },
                    { skewY: endVal, ease: 'none', scrollTrigger: scrollTriggerConfig }
                );
                break;

            case 'blur':
                gsap.fromTo( el,
                    { filter: 'blur(' + Math.abs( startVal ) + 'px)' },
                    { filter: 'blur(' + Math.abs( endVal ) + 'px)', ease: 'none', scrollTrigger: scrollTriggerConfig }
                );
                break;
        }
    }

    // ─────────────────────────────────────────────────────────────────────────
    // Default animation for widgets that have no custom settings
    // ─────────────────────────────────────────────────────────────────────────
    function initDefaultAnimation( el, $scope ) {
        var delay = $scope.parent().index() * 0.12;

        gsap.from( el, {
            opacity   : 0,
            y         : 50,
            duration  : 0.7,
            delay     : delay,
            ease      : 'power2.out',
            clearProps: 'all',
            scrollTrigger: {
                trigger : el,
                start   : 'top 88%',
                once    : true,
            },
        } );
    }

    // ─────────────────────────────────────────────────────────────────────────
    // Boot on Elementor frontend init
    // ─────────────────────────────────────────────────────────────────────────
    $( window ).on( 'elementor/frontend/init', function () {

        gsap.registerPlugin( ScrollTrigger );

        elementorFrontend.hooks.addAction(
            'frontend/element_ready/global',
            function ( $scope ) {

                // Never animate inside the Elementor editor
                if ( window.elementorFrontend && elementorFrontend.isEditMode() ) {
                    return;
                }

                var el           = $scope[0];
                var entranceData = $scope.data( 'elematic-sa-entrance' ); // auto-parsed JSON by jQuery
                var scrollData   = $scope.data( 'elematic-sa-scroll' );   // auto-parsed JSON by jQuery

                // ── Custom While-Scrolling effect ─────────────────────────
                if ( scrollData && scrollData.effect ) {
                    initScrollEffect( el, scrollData );
                }

                // ── Custom Entrance animation ─────────────────────────────
                if ( entranceData && entranceData.type ) {
                    initEntrance( el, entranceData );
                    return; // skip default
                }

                // ── Default fade-up for widgets only (no custom settings) ─
                if ( $scope.hasClass( 'elementor-widget' ) && ! scrollData ) {
                    initDefaultAnimation( el, $scope );
                }
            }
        );

    } );

} )( jQuery );
