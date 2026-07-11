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
                '<svg width="24" height="17" viewBox="0 0 24 17" fill="none" xmlns="http://www.w3.org/2000/svg" class="svg_arrow-slider rotate"><path d="M15.7113 0.237988C15.4731 0.0661272 15.1784 -0.0173099 14.8814 0.00299519C14.5843 0.0233003 14.3049 0.145985 14.0943 0.348524C13.8837 0.551064 13.7562 0.819866 13.7351 1.10558C13.714 1.39129 13.8007 1.67474 13.9794 1.90389L19.299 7.0206H1.23711C0.909011 7.0206 0.594346 7.14596 0.362342 7.36912C0.130338 7.59227 0 7.89494 0 8.21053C0 8.52612 0.130338 8.82878 0.362342 9.05194C0.594346 9.27509 0.909011 9.40046 1.23711 9.40046H19.299L13.9794 14.5172C13.8007 14.7463 13.714 15.0298 13.7351 15.3155C13.7562 15.6012 13.8837 15.87 14.0943 16.0725C14.3049 16.2751 14.5843 16.3978 14.8814 16.4181C15.1784 16.4384 15.4731 16.3549 15.7113 16.1831L23.134 9.04348L24 8.21053L23.134 7.37758"></path></svg><span class="sporina-news-slider__sr-only">' + prevLabel + '</span>',
                '<svg width="24" height="17" viewBox="0 0 24 17" fill="none" xmlns="http://www.w3.org/2000/svg" class="svg_arrow-slider"><path d="M15.7113 0.237988C15.4731 0.0661272 15.1784 -0.0173099 14.8814 0.00299519C14.5843 0.0233003 14.3049 0.145985 14.0943 0.348524C13.8837 0.551064 13.7562 0.819866 13.7351 1.10558C13.714 1.39129 13.8007 1.67474 13.9794 1.90389L19.299 7.0206H1.23711C0.909011 7.0206 0.594346 7.14596 0.362342 7.36912C0.130338 7.59227 0 7.89494 0 8.21053C0 8.52612 0.130338 8.82878 0.362342 9.05194C0.594346 9.27509 0.909011 9.40046 1.23711 9.40046H19.299L13.9794 14.5172C13.8007 14.7463 13.714 15.0298 13.7351 15.3155C13.7562 15.6012 13.8837 15.87 14.0943 16.0725C14.3049 16.2751 14.5843 16.3978 14.8814 16.4181C15.1784 16.4384 15.4731 16.3549 15.7113 16.1831L23.134 9.04348L24 8.21053L23.134 7.37758"></path></svg><span class="sporina-news-slider__sr-only">' + nextLabel + '</span>'
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
