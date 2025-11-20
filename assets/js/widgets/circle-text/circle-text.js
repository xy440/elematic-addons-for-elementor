(function($) {
    function applyCircleText(textEl) {
        if (!textEl || textEl.dataset.processed === "1") return;

        const rawText = textEl.textContent;
        const radius = textEl.offsetWidth / 2;

        if (radius < 10) return; // Wait until element is visible

        textEl.innerHTML = rawText
            .split("")
            .map((char, i) =>
                `<span style="
                    position: absolute;
                    left: 50%;
                    transform-origin: 0 ${radius}px;
                    transform: rotate(${i * 10.3}deg);
                ">${char}</span>`
            )
            .join("");

        textEl.dataset.processed = "1";
    }

    function initWidget($scope) {
        const textEl = $scope.find('.elematic-circle-text-txt')[0];

        if (!textEl) return;

        const waitUntilVisible = () => {
            const width = textEl.offsetWidth;
            if (width < 10) {
                setTimeout(waitUntilVisible, 100);
            } else {
                applyCircleText(textEl);
            }
        };

        waitUntilVisible();
    }

    $(window).on('elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction('frontend/element_ready/elematic-circle-text.default', initWidget);
    });
})(jQuery);