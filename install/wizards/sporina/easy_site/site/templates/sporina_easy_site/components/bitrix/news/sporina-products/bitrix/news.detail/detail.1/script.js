(function () {
    'use strict';

    function initGallery(root) {
        if (root.dataset.galleryReady === 'Y') {
            return;
        }
        root.dataset.galleryReady = 'Y';

        var slides = root.querySelectorAll('[data-detail-slide]');
        var thumbs = root.querySelectorAll('[data-detail-thumb]');
        var modal = root.querySelector('[data-product-modal]');
        var modalImage = root.querySelector('[data-modal-image]');
        var index = 0;
        var lastTrigger = null;

        function show(nextIndex) {
            if (!slides.length) {
                return;
            }
            index = (nextIndex + slides.length) % slides.length;
            slides.forEach(function (slide, slideIndex) {
                slide.classList.toggle('is-active', slideIndex === index);
            });
            thumbs.forEach(function (thumb, thumbIndex) {
                var active = thumbIndex === index;
                thumb.classList.toggle('is-active', active);
                thumb.setAttribute('aria-current', active ? 'true' : 'false');
            });
            if (modalImage) {
                var image = slides[index].querySelector('img');
                modalImage.src = image.src;
                modalImage.alt = image.alt;
            }
        }

        function closeModal() {
            if (!modal) {
                return;
            }
            modal.hidden = true;
            document.body.classList.remove('sporina-stand-modal-open');
            if (lastTrigger) {
                lastTrigger.focus();
            }
        }

        function openModal(nextIndex, trigger) {
            if (!modal) {
                return;
            }
            lastTrigger = trigger;
            show(nextIndex);
            modal.hidden = false;
            document.body.classList.add('sporina-stand-modal-open');
            modal.querySelector('[data-modal-close]').focus();
        }

        root.querySelector('[data-detail-prev]')?.addEventListener('click', function () { show(index - 1); });
        root.querySelector('[data-detail-next]')?.addEventListener('click', function () { show(index + 1); });
        slides.forEach(function (slide, slideIndex) {
            slide.addEventListener('click', function () { openModal(slideIndex, slide); });
        });
        thumbs.forEach(function (thumb, thumbIndex) {
            thumb.addEventListener('click', function () { show(thumbIndex); });
        });

        if (modal) {
            modal.querySelectorAll('[data-modal-close]').forEach(function (button) {
                button.addEventListener('click', closeModal);
            });
            modal.querySelector('[data-modal-prev]')?.addEventListener('click', function () { show(index - 1); });
            modal.querySelector('[data-modal-next]')?.addEventListener('click', function () { show(index + 1); });
            document.addEventListener('keydown', function (event) {
                if (modal.hidden) {
                    return;
                }
                if (event.key === 'Escape') {
                    closeModal();
                } else if (event.key === 'ArrowLeft') {
                    show(index - 1);
                } else if (event.key === 'ArrowRight') {
                    show(index + 1);
                }
            });
        }
    }

    function initAll() {
        document.querySelectorAll('[data-detail-gallery]').forEach(initGallery);
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initAll);
    } else {
        initAll();
    }
    if (window.BX && BX.addCustomEvent) {
        BX.addCustomEvent('onAjaxSuccess', initAll);
    }
}());
