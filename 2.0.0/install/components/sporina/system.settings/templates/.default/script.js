(function () {
    function init(root) {
        var form = root.querySelector('.system-settings-form');
        var actionName = root.getAttribute('data-action-variable');
        var status = root.querySelector('[data-role="status"]');
        var panel = root.querySelector('[data-role="panel"]');
        var open = root.querySelector('[data-role="open"]');
        var logoInput = root.querySelector('[data-role="logo.input"]');
        var logoPreview = root.querySelector('[data-role="logo.preview"]');
        var logoReset = root.querySelector('[data-role="logo.reset"]');
        var widthInput = root.querySelector('[name="settings[template-width]"]');

        function toggle(isOpen) {
            root.classList.toggle('is-open', isOpen);
            panel.setAttribute('aria-hidden', isOpen ? 'false' : 'true');
            open.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
        }

        function post(data) {
            return fetch(form.action || window.location.href, { method: 'POST', body: data, credentials: 'same-origin' })
                .then(function (response) { return response.json(); });
        }

        function omitUntouchedSettings(data) {
            root.querySelectorAll('.system-settings-field').forEach(function (field) {
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

        if (widthInput) {
            var siteWidth = getComputedStyle(document.documentElement).getPropertyValue('--site-max-width').trim().replace(/px$/, '');
            if (siteWidth === '1600' || siteWidth === '1920' || siteWidth === '2560') widthInput.value = siteWidth;
        }

        root.querySelectorAll('[data-role="category"]').forEach(function (tab) {
            tab.addEventListener('click', function () {
                var category = tab.getAttribute('data-category');
                root.querySelectorAll('[data-role="category"]').forEach(function (item) { item.classList.toggle('is-active', item === tab); });
                root.querySelectorAll('[data-role="category.panel"]').forEach(function (section) { section.classList.toggle('is-active', section.getAttribute('data-category') === category); });
            });
        });

        root.querySelectorAll('[name^="settings["]').forEach(function (input) {
            function markDirty() {
                var field = input.closest('.system-settings-field');
                if (field) field.setAttribute('data-dirty', 'Y');
            }

            input.addEventListener('input', markDirty);
            input.addEventListener('change', markDirty);
        });

        if (logoInput) {
            logoInput.addEventListener('change', function () {
                if (!logoInput.files || !logoInput.files[0] || !logoPreview) return;
                logoPreview.src = URL.createObjectURL(logoInput.files[0]);
            });
        }

        form.addEventListener('submit', function (event) {
            event.preventDefault();
            var data = omitUntouchedSettings(new FormData(form));
            var upload = logoInput && logoInput.files && logoInput.files.length;
            if (upload) data.set(actionName, 'upload-logo');
            post(data).then(function (response) {
                if (response.success) {
                    if (upload && logoPreview && response.logoUrl) logoPreview.src = response.logoUrl;
                    if (upload) {
                        logoInput.value = '';
                        var settingsData = omitUntouchedSettings(new FormData(form));
                        settingsData.delete('settings[template-logo]');
                        settingsData.set(actionName, 'apply');
                        post(settingsData).then(function (settingsResponse) {
                            if (settingsResponse.success) window.location.reload();
                            else status.textContent = settingsResponse.error || 'Ошибка сохранения';
                        }).catch(function () { status.textContent = 'Ошибка соединения'; });
                        return;
                    }
                    window.location.reload();
                    return;
                }

                status.textContent = response.error || 'Ошибка сохранения';
            }).catch(function () { status.textContent = 'Ошибка соединения'; });
        });

        if (logoReset) {
            logoReset.addEventListener('click', function () {
                var data = new FormData(form);
                data.set(actionName, 'reset-logo');
                post(data).then(function (response) {
                    if (response.success) {
                        if (logoInput) logoInput.value = '';
                        if (logoPreview && response.logoUrl) logoPreview.src = response.logoUrl;
                        return;
                    }
                    status.textContent = response.error || 'Ошибка сброса логотипа';
                }).catch(function () { status.textContent = 'Ошибка соединения'; });
            });
        }

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
