
function circleJs(elementId, autoRotate, rotationTime, mouseEvent) {
    // Select DOM elements
    const subCircles = document.querySelectorAll(`#${elementId} .elematic-circle-info-sub-circle`);
    const infoItems = document.querySelectorAll(`#${elementId} .elematic-circle-info-item`);
    const innerCircle = document.querySelector(`#${elementId} .elematic-circle-info-inner`);
    
    let currentIndex = 2;
    let intervalId = null;
    
    // Set default rotation time if invalid
    if (rotationTime <= 0) {
        rotationTime = "100000000000";
    }
    
    // Disable auto-rotation if autoRotate is false
    if (!autoRotate) {
        rotationTime = "100000000000";
    }
    
    // Setup auto-rotation interval
    if (autoRotate) {
        intervalId = setInterval(function() {
            const activeCircle = jQuery(`#${elementId} .elematic-circle-info-sub-circle.active`);
            let activeIndex = activeCircle.data("circle-index");
            const totalCircles = jQuery(`#${elementId} .elematic-circle-info-sub-circle`).length;
            
            // Reset index if it exceeds total circles
            if (activeIndex > totalCircles || currentIndex > totalCircles) {
                activeIndex = 1;
                currentIndex = 1;
            }
            
            // Remove active class from all circles
            jQuery(`#${elementId} .elematic-circle-info-sub-circle`).removeClass("active");
            jQuery(`#${elementId} .elematic-circle-info-sub-circle.active`).removeClass("active", this);
            
            // Add active class to current circle
            jQuery(`#${elementId} [data-circle-index='${currentIndex}']`).addClass("active");
            
            // Update info items
            jQuery(`#${elementId} .elematic-circle-info-item`).removeClass("active");
            jQuery(`#${elementId} .icci${currentIndex}`).addClass("active");
            
            currentIndex++;
            
            // Rotate icons/SVGs inside sub-circles
            jQuery(`#${elementId} .elematic-circle-info-sub-circle i, #${elementId} .elematic-circle-info-sub-circle svg`).css({
                transform: `rotate(${360 - (currentIndex - 2) * 36}deg)`,
                transition: "2s"
            });
            
            // Rotate inner circle
            jQuery(`#${elementId} .elematic-circle-info-inner`).css({
                transform: `rotate(${(currentIndex - 2) * 36}deg)`,
                transition: "1s"
            });
        }, rotationTime);
    }
    
    // Clear interval if auto-rotate is disabled
    if (!autoRotate) {
        clearInterval(intervalId);
    }
    
    /**
     * Remove a class from all elements in a NodeList
     */
    const removeClassFromAll = function(elements, className) {
        if (!elements) return false;
        
        elements.forEach(function(element) {
            if (element.classList.contains(className)) {
                element.classList.remove(className);
            }
        });
        
        return true;
    };
    
    /**
     * Add a class to a specific element at index
     */
    const addClassToIndex = function(elements, index, className) {
        if (!elements) return 0;
        elements[index].classList.add(className);
        return true;
    };
    
    // Circle initialization object
    const circleController = {
        initServicesCircle: function() {
            if (!innerCircle) return;
            
            let resizeTimeout;
            
            /**
             * Position sub-circles around the main circle
             */
            const positionSubCircles = function() {
                const innerRect = document.querySelector(`#${elementId} .elematic-circle-info-inner`).getBoundingClientRect();
                
                // Reverse array and position each circle
                Array.from(subCircles).reverse().forEach(function(circle, index) {
                    const angle = index * (360 / subCircles.length);
                    const x = 0 + (innerRect.width / 2) * Math.cos(angle * Math.PI / 180);
                    const y = 0 + (innerRect.height / 2) * Math.sin(angle * Math.PI / 180);
                    
                    circle.style.transform = `translate3d(${parseFloat(x).toFixed(5)}px, ${parseFloat(y).toFixed(5)}px, 0)`;
                });
            };
            
            // Initial positioning
            positionSubCircles();
            
            // Reposition on window resize with debounce
            window.addEventListener("resize", function() {
                clearTimeout(resizeTimeout);
                resizeTimeout = setTimeout(function() {
                    positionSubCircles();
                }, 50);
            });
            
            // Add event listeners to sub-circles
            subCircles.forEach(function(circle, index) {
                const handleInteraction = function() {
                    this.index = circle.dataset.circleIndex;
                    
                    // Only activate if not already active
                    if (!circle.classList.contains("active")) {
                        removeClassFromAll(subCircles, "active");
                        removeClassFromAll(infoItems, "active");
                        addClassToIndex(subCircles, index, "active");
                        addClassToIndex(infoItems, index, "active");
                    }
                };
                
                // Attach event based on mouseEvent parameter
                if (mouseEvent === "mouseover") {
                    circle.addEventListener("mouseover", handleInteraction, true);
                } else if (mouseEvent === "click") {
                    circle.addEventListener("click", handleInteraction, true);
                } else {
                    // Default to mouseover
                    circle.addEventListener("mouseover", handleInteraction, true);
                }
            });
        }
    };
    
    // Initialize the circle
    circleController.initServicesCircle();
}

/**
 * Elementor Frontend Integration
 */
(function($, elementorFrontend) {
    "use strict";
    
    /**
     * Initialize circle widget with Intersection Observer
     */
    const initCircleWidget = function(scope, $) {
        const circleElement = scope.find(".elematic-circle-info");
        
        if (!circleElement.length) return;
        
        // Use Intersection Observer to initialize when element is visible
        const observer = new IntersectionObserver(function(entries, observer) {
            entries.forEach(function(entry) {
                if (entry.isIntersecting) {
                    const settings = $(entry.target).data("settings");
                    circleJs(
                        settings.id,
                        settings.circleMoving,
                        settings.movingTime,
                        settings.mouseEvent
                    );
                }
            });
        }, {
            threshold: 0.8
        });
        
        // Observe each circle element
        circleElement.each(function() {
            observer.observe(this);
        });
    };
    
    // Hook into Elementor frontend initialization
    jQuery(window).on("elementor/frontend/init", function() {
        elementorFrontend.hooks.addAction(
            "frontend/element_ready/elematic-circle-info.default",
            initCircleWidget
        );
    });
    
})(jQuery, window.elementorFrontend);