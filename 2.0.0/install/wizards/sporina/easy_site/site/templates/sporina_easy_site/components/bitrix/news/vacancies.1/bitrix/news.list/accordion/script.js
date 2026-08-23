document.addEventListener('DOMContentLoaded', function () {
    document
        .querySelectorAll('.sporina-vacancies')
        .forEach(function (root) {
            if (root.dataset.accordionInitialized === 'true') {
                return;
            }

            root.dataset.accordionInitialized = 'true';

            root
                .querySelectorAll('.sporina-vacancies__toggle')
                .forEach(function (button) {
                    button.addEventListener('click', function () {
                        var item = button.closest(
                            '.sporina-vacancies__item'
                        );

                        var description = item.querySelector(
                            '.sporina-vacancies__description'
                        );

                        if (!description) {
                            return;
                        }

                        var isOpen = item.classList.contains('is-open');

                        if (isOpen) {
                            description.style.maxHeight =
                                description.scrollHeight + 'px';

                            requestAnimationFrame(function () {
                                item.classList.remove('is-open');
                                description.style.maxHeight = '0px';
                            });

                            button.setAttribute('aria-expanded', 'false');
                            description.setAttribute('aria-hidden', 'true');
                        } else {
                            item.classList.add('is-open');

                            description.style.maxHeight =
                                description.scrollHeight + 'px';

                            button.setAttribute('aria-expanded', 'true');
                            description.setAttribute('aria-hidden', 'false');
                        }
                    });
                });
        });
});

window.addEventListener('resize', function () {
    document
        .querySelectorAll(
            '.sporina-vacancies__item.is-open .sporina-vacancies__description'
        )
        .forEach(function (description) {
            description.style.maxHeight =
                description.scrollHeight + 'px';
        });
});