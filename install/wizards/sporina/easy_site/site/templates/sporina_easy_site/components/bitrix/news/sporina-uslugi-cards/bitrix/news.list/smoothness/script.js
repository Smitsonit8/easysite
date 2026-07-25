(function () {
    'use strict';

    function initServicesReveal(root) {
        if (root.dataset.sporinaServicesRevealInitialized === 'Y') {
            return;
        }

        root.dataset.sporinaServicesRevealInitialized = 'Y';

        var cards = root.querySelectorAll('.sporina-services__card--reveal');

        if (!cards.length) {
            return;
        }

        if (
            !('IntersectionObserver' in window) ||
            window.matchMedia('(prefers-reduced-motion: reduce)').matches
        ) {
            cards.forEach(function (card) {
                card.classList.add('is-visible');
            });

            return;
        }

        var observer = new IntersectionObserver(function (entries, currentObserver) {
            entries.forEach(function (entry) {
                if (!entry.isIntersecting) {
                    return;
                }

                entry.target.classList.add('is-visible');
                currentObserver.unobserve(entry.target);
            });
        }, {
            threshold: 0.15,
            rootMargin: '0px 0px -40px 0px'
        });

        cards.forEach(function (card) {
            observer.observe(card);
        });
    }

    function initAllServices() {
        document.querySelectorAll('.sporina-services').forEach(initServicesReveal);
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initAllServices);
    } else {
        initAllServices();
    }

    /*
     * Повторная инициализация после AJAX-обновления Bitrix.
     */
    if (window.BX && typeof window.BX.addCustomEvent === 'function') {
        window.BX.addCustomEvent('onAjaxSuccess', initAllServices);
    }
})();
