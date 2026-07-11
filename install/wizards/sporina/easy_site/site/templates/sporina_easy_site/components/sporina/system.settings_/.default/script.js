(function () {
    'use strict';

    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.js-system-settings').forEach(function (root) {
            var panel = root.querySelector('[data-role="panel"]');
            var overlay = root.querySelector('[data-role="overlay"]');
            var errorEl = root.querySelector('[data-role="error"]');
            var form = root.querySelector('[data-role="form"]');
            var actionVariable = root.getAttribute('data-action-variable') || '';
            var sessid = root.getAttribute('data-sessid') || '';

            function setExpanded(expanded) {
                root.classList.toggle('is-expanded', expanded);
                document.body.classList.toggle('system-settings-lock', expanded);
                if (expanded) {
                    panel.setAttribute('aria-hidden', 'false');
                    var firstButton = panel.querySelector('button');
                    if (firstButton) firstButton.focus();
                } else {
                    root.querySelector('[data-role="open"]').focus();
                    panel.setAttribute('aria-hidden', 'true');
                }
            }

            function showError(message) {
                errorEl.textContent = message || 'Не удалось сохранить настройки.';
                errorEl.hidden = false;
            }

            function request(action, formData, reload) {
                formData = formData || new FormData();
                formData.set(actionVariable, action);
                formData.set('sessid', sessid);
                errorEl.hidden = true;
                errorEl.textContent = '';
                root.querySelectorAll('[data-role="submit"]').forEach(function (btn) {
                    btn.disabled = true;
                });

                var xhr = new XMLHttpRequest();
                xhr.open('POST', window.location.href, true);
                xhr.responseType = 'json';
                xhr.onload = function () {
                    if (xhr.status >= 200 && xhr.status < 300) {
                        var response = xhr.response;
                        if (!response || response.success !== true) {
                            showError(response && response.error);
                            return;
                        }
                        if (reload) {
                            window.location.reload();
                        }
                    } else {
                        var errResponse = xhr.response || {};
                        showError(errResponse.error);
                    }
                    root.querySelectorAll('[data-role="submit"]').forEach(function (btn) {
                        btn.disabled = false;
                    });
                };
                xhr.onerror = function () {
                    showError('Ошибка сети');
                    root.querySelectorAll('[data-role="submit"]').forEach(function (btn) {
                        btn.disabled = false;
                    });
                };
                xhr.send(formData);
            }

            root.addEventListener('click', function (e) {
                var target = e.target;

                // Open button
                if (target.closest('[data-role="open"]')) {
                    setExpanded(true);
                    e.preventDefault();
                    return;
                }

                // Close button or overlay
                if (target.closest('[data-role="close"]') || target.closest('[data-role="overlay"]')) {
                    setExpanded(false);
                    e.preventDefault();
                    return;
                }

                // Category switch
                var categoryBtn = target.closest('[data-role="category"]');
                if (categoryBtn) {
                    var category = categoryBtn.getAttribute('data-category') || '';
                    root.querySelectorAll('[data-role="category"]').forEach(function (el) {
                        el.classList.remove('is-active');
                    });
                    categoryBtn.classList.add('is-active');
                    root.querySelectorAll('[data-role="category.panel"]').forEach(function (el) {
                        el.classList.remove('is-active');
                        if (el.getAttribute('data-category') === category) {
                            el.classList.add('is-active');
                        }
                    });
                    var data = new FormData();
                    data.set('section', category);
                    request('remember-section', data, false);
                    e.preventDefault();
                    return;
                }

                // Submit buttons (apply / reset)
                var submitBtn = target.closest('[data-role="submit"]');
                if (submitBtn) {
                    var action = submitBtn.getAttribute('data-action') || '';
                    // Явно собираем все поля формы для гарантии отправки radio/checkbox
                    var data = new FormData(form);
                    form.querySelectorAll('input, select, textarea').forEach(function (field) {
                        if (field.type === 'radio' || field.type === 'checkbox') {
                            if (field.checked) {
                                data.set(field.name, field.value);
                            }
                        } else if (field.name && field.type !== 'submit' && field.type !== 'button') {
                            data.set(field.name, field.value);
                        }
                    });
                    request(action, data, true);
                    e.preventDefault();
                    return;
                }

                // Color swatches
                var colorSwatch = target.closest('[data-color]');
                if (colorSwatch) {
                    var colorContainer = colorSwatch.closest('[data-role="color"]');
                    if (colorContainer) {
                        var value = colorSwatch.getAttribute('data-color') || '';
                        var valueInput = colorContainer.querySelector('[data-role="color.value"]');
                        var pickerInput = colorContainer.querySelector('[data-role="color.picker"]');
                        if (valueInput) valueInput.value = value;
                        if (pickerInput) pickerInput.value = value;
                        colorContainer.querySelectorAll('[data-color]').forEach(function (el) {
                            el.classList.remove('is-active');
                        });
                        colorSwatch.classList.add('is-active');
                    }
                    e.preventDefault();
                    return;
                }
            });

            // Color picker change
            root.addEventListener('input', function (e) {
                var picker = e.target.closest('[data-role="color.picker"]');
                if (picker) {
                    var container = picker.closest('[data-role="color"]');
                    if (container) {
                        var valueInput = container.querySelector('[data-role="color.value"]');
                        if (valueInput) valueInput.value = picker.value;
                    }
                }
            });

            // Escape key
            document.addEventListener('keydown', function (event) {
                if (event.key === 'Escape' && root.classList.contains('is-expanded')) {
                    setExpanded(false);
                }
            });
        });
    });
})();
