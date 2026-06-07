$(function () {
    var escapeHtml = function (text) {
        return String(text)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');
    };

    $('.js-sporina-news-slider').each(function () {
        var $slider = $(this);

        if ($slider.hasClass('owl-loaded')) {
            return;
        }

        var showNav = String($slider.attr('data-nav') || 'Y').toUpperCase() === 'Y';
        var autoplay = String($slider.attr('data-autoplay') || 'N').toUpperCase() === 'Y';
        var autoplayTimeout = parseInt($slider.attr('data-autoplay-timeout'), 10);
        var prevLabel = escapeHtml($slider.attr('data-nav-prev-label') || 'Previous');
        var nextLabel = escapeHtml($slider.attr('data-nav-next-label') || 'Next');

        if (!autoplayTimeout || autoplayTimeout < 1000) {
            autoplayTimeout = 5000;
        }

        $slider.owlCarousel({
            items: 3,
            loop: autoplay,
            rewind: !autoplay,
            responsiveClass: true,
            margin: 20,
            mouseDrag: true,
            touchDrag: true,
            pullDrag: true,
            dots: false,
            nav: showNav,
            navText: [
                '<span class="sporina-news-slider__nav-icon" aria-hidden="true"><img src="/bitrix/templates/sporina_easy_site/img/arrow.svg" alt="" class="svg_color rotate"></span><span class="sporina-news-slider__sr-only">' + prevLabel + '</span>',
                '<span class="sporina-news-slider__nav-icon" aria-hidden="true"><img src="/bitrix/templates/sporina_easy_site/img/arrow.svg" alt="" class="svg_color"></span><span class="sporina-news-slider__sr-only">' + nextLabel + '</span>'
            ],
            autoplay: autoplay,
            autoplayTimeout: autoplayTimeout,
            autoplayHoverPause: true,
            smartSpeed: 600,
            responsive: {
                0: {
                    items: 1
                },
                577: {
                    items: 2
                },
                993: {
                    items: 3
                }
            }
        });
    });
});
