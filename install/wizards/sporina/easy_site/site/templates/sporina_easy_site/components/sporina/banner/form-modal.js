(function () {
    if (window.SporinaBannerFormModalInitialized) {
        return;
    }

    window.SporinaBannerFormModalInitialized = true;

    function closeModal(modal) {
        modal.hidden = true;

        var trigger = document.querySelector('[data-banner-form-open="' + modal.id + '"]');
        if (trigger) {
            trigger.setAttribute('aria-expanded', 'false');
            trigger.focus();
        }
    }

    document.addEventListener('click', function (event) {
        var trigger = event.target.closest('[data-banner-form-open]');
        if (trigger) {
            var modal = document.getElementById(trigger.getAttribute('data-banner-form-open'));
            if (modal) {
                modal.hidden = false;
                trigger.setAttribute('aria-expanded', 'true');
                var focusTarget = modal.querySelector('input, textarea, select, button');
                if (focusTarget) {
                    focusTarget.focus();
                }
            }
            return;
        }

        var closeButton = event.target.closest('[data-banner-form-close]');
        if (closeButton) {
            var openModal = closeButton.closest('[data-banner-form-modal]');
            if (openModal) {
                closeModal(openModal);
            }
        }
    });

    document.addEventListener('keydown', function (event) {
        if (event.key !== 'Escape') {
            return;
        }

        var openModal = document.querySelector('[data-banner-form-modal]:not([hidden])');
        if (openModal) {
            closeModal(openModal);
        }
    });
}());
