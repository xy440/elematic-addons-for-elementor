!(function ($) {
  const init = ($scope) => {
    const root = $scope.find('.elematic-highlight-text')[0];
    if (!root || root.dataset.ready) return;
    root.dataset.ready = '1';

    // 1) Take original HTML including <br> separators
    const html = root.innerHTML;

    // 2) Build word spans so we can detect visual line breaks
    root.innerHTML = '';
    const segs = html.split(/<br\s*\/?>/i); // respect manual breaks if any
    const wordEls = [];
    segs.forEach((seg, sIdx) => {
      const text = seg.replace(/\s+/g, ' ').trim();
      if (text.length) {
        text.split(' ').forEach((w, i, arr) => {
          const span = document.createElement('span');
          span.className = 'elematic-word';
          span.textContent = w + (i < arr.length - 1 ? ' ' : '');
          root.appendChild(span);
          wordEls.push(span);
        });
      }
      if (sIdx < segs.length - 1) {
        const br = document.createElement('br');
        root.appendChild(br);
      }
    });

    // 3) Group words into visual lines by top offset
    const lines = [];
    let currentLine = [];
    let currentTop = null;

    wordEls.forEach((w) => {
      const top = Math.round(w.offsetTop);
      if (currentTop === null) currentTop = top;
      if (top !== currentTop) {
        lines.push(currentLine);
        currentLine = [];
        currentTop = top;
      }
      currentLine.push(w);
    });
    if (currentLine.length) lines.push(currentLine);

    // 4) Replace with per-line structure: base (muted) + fill overlay
    root.innerHTML = '';
    const lineEls = [];
    lines.forEach((words, idx) => {
      const line = document.createElement('span');
      line.className = 'elematic-highlight-text-line';

      const base = document.createElement('span');
      base.className = 'elematic-highlight-text-base';
      const fill = document.createElement('span');
      fill.className = 'elematic-highlight-text-fill';
      fill.setAttribute('aria-hidden', 'true');

      words.forEach(w => {
        base.appendChild(w.cloneNode(true));
        fill.appendChild(w.cloneNode(true));
      });

      line.appendChild(base);
      line.appendChild(fill);
      root.appendChild(line);
      if (idx < lines.length - 1 && segs.length > 1) {
        // visual gap is handled by natural wrapping, so no <br> here
      }
      lineEls.push(line);
    });

    const fills = Array.from(root.querySelectorAll('.elematic-highlight-text-line .elematic-highlight-text-fill'));

    // 5) Animate line-by-line using a narrow center band
    let band = 0;
    const calcBand = () => {
      const sample = lineEls[0];
      const h = sample ? sample.getBoundingClientRect().height : 60;
      band = Math.max(24, h * 0.9); // ~ one line height
    };

    const update = () => {
      const vh = window.innerHeight;
      const center = vh * 0.5;     // move up/down if you like
      const start  = center + band / 2;
      const end    = center - band / 2;
      const denom  = Math.max(1, start - end);

      fills.forEach((fill) => {
        const r = fill.parentElement.getBoundingClientRect();
        const mid = r.top + r.height / 2;
        let p = (start - mid) / denom; // 0..1 while within band
        if (p < 0) p = 0; else if (p > 1) p = 1;
        fill.style.backgroundSize = (p * 100).toFixed(1) + '% 100%';
      });
    };

    const onScroll = () => {
      if (!root._raf) root._raf = requestAnimationFrame(() => { root._raf = 0; update(); });
    };

    calcBand();
    update();
    window.addEventListener('scroll', onScroll, { passive: true });
    window.addEventListener('resize', () => { calcBand(); onScroll(); });
  };

  // IMPORTANT: hook to your widget name
  jQuery(window).on('elementor/frontend/init', function () {
    elementorFrontend.hooks.addAction('frontend/element_ready/elematic-highlight-text.default', init);
  });
})(jQuery);