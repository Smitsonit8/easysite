(function () {
    'use strict';

    function initCards() {
        var cards = document.querySelectorAll(
            '.sporina-service-card--reveal:not(.is-visible)'
        );

        if (!cards.length) return;

        if (!('IntersectionObserver' in window) ||
            window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
            cards.forEach(function (card) {
                card.classList.add('is-visible');
            });
            return;
        }

        var observer = new IntersectionObserver(function (entries, instance) {
            entries.forEach(function (entry) {
                if (!entry.isIntersecting) return;
                entry.target.classList.add('is-visible');
                instance.unobserve(entry.target);
            });
        }, {
            threshold: 0.15,
            rootMargin: '0px 0px -35px 0px'
        });

        cards.forEach(function (card) {
            observer.observe(card);
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initCards);
    } else {
        initCards();
    }

    if (window.BX && typeof window.BX.addCustomEvent === 'function') {
        window.BX.addCustomEvent('onAjaxSuccess', initCards);
    }
})();
