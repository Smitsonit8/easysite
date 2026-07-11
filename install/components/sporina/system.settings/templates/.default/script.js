(function () {
    function init(root) {
        var form = root.querySelector('.system-settings-form');
        var actionName = root.getAttribute('data-action-variable');
        var status = root.querySelector('[data-role="status"]');
        var panel = root.querySelector('[data-role="panel"]');
        var open = root.querySelector('[data-role="open"]');

        function toggle(isOpen) {
            root.classList.toggle('is-open', isOpen);
            panel.setAttribute('aria-hidden', isOpen ? 'false' : 'true');
            open.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
        }

        function post(data) {
            return fetch(form.action || window.location.href, { method: 'POST', body: data, credentials: 'same-origin' })
                .then(function (response) { return response.json(); });
        }

        function omitUntouchedFallbackSettings(data) {
            root.querySelectorAll('[data-component-fallback="Y"][data-stored="N"]').forEach(function (field) {
                if (field.getAttribute('data-dirty') === 'Y') {
                    return;
                }

                field.querySelectorAll('[name]').forEach(function (input) { data.delete(input.name); });
            });

            return data;
        }

        open.addEventListener('click', function () { toggle(true); });
        root.querySelector('[data-role="close"]').addEventListener('click', function () { toggle(false); });
        root.querySelector('[data-role="overlay"]').addEventListener('click', function () { toggle(false); });

        root.querySelectorAll('[data-role="category"]').forEach(function (tab) {
            tab.addEventListener('click', function () {
                var category = tab.getAttribute('data-category');
                root.querySelectorAll('[data-role="category"]').forEach(function (item) { item.classList.toggle('is-active', item === tab); });
                root.querySelectorAll('[data-role="category.panel"]').forEach(function (section) { section.classList.toggle('is-active', section.getAttribute('data-category') === category); });
            });
        });

        root.querySelectorAll('[data-component-fallback="Y"] input').forEach(function (input) {
            input.addEventListener('input', function () { input.closest('[data-component-fallback]').setAttribute('data-dirty', 'Y'); });
            input.addEventListener('change', function () { input.closest('[data-component-fallback]').setAttribute('data-dirty', 'Y'); });
        });

        form.addEventListener('submit', function (event) {
            event.preventDefault();
            post(omitUntouchedFallbackSettings(new FormData(form))).then(function (response) {
                status.textContent = response.success ? 'Сохранено' : (response.error || 'Ошибка сохранения');
            }).catch(function () { status.textContent = 'Ошибка соединения'; });
        });

        root.querySelector('[data-role="reset"]').addEventListener('click', function () {
            var data = new FormData(form);
            data.set(actionName, 'reset');
            post(data).then(function (response) {
                if (response.success) window.location.reload();
                else status.textContent = response.error || 'Ошибка сброса';
            }).catch(function () { status.textContent = 'Ошибка соединения'; });
        });
    }

    function bootstrap() {
        document.querySelectorAll('.js-system-settings').forEach(init);
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', bootstrap);
    } else {
        bootstrap();
    }
}());
