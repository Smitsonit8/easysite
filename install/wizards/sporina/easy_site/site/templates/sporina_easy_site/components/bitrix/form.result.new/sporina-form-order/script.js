/**
 * Скрипт для работы popup сообщения об успешной отправке формы
 */
(function() {
	'use strict';
	
	// Функция для показа popup
	function showSuccessPopup(message) {
		var overlay = document.getElementById('form-success-popup');
		if (overlay) {
			overlay.style.display = 'flex';
			overlay.classList.add('show');
			
			// Закрытие по клику на крестик
			var closeBtn = overlay.querySelector('.form-popup-close');
			if (closeBtn) {
				closeBtn.addEventListener('click', function() {
					hideSuccessPopup();
				});
			}
			
			// Закрытие по клику вне popup
			overlay.addEventListener('click', function(e) {
				if (e.target === overlay) {
					hideSuccessPopup();
				}
			});
			
			// Закрытие по клавише Escape
			document.addEventListener('keydown', function(e) {
				if (e.key === 'Escape' && overlay.style.display === 'flex') {
					hideSuccessPopup();
				}
			});
			
			// Автоматическое закрытие через 5 секунд
			setTimeout(function() {
				hideSuccessPopup();
			}, 5000);
		}
	}
	
	// Функция для скрытия popup
	function hideSuccessPopup() {
		var overlay = document.getElementById('form-success-popup');
		if (overlay) {
			overlay.style.display = 'none';
			overlay.classList.remove('show');
		}
	}
	
	// Инициализация при загрузке DOM
	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', function() {
			var popup = document.getElementById('form-success-popup');
			if (popup && popup.style.display !== 'none') {
				showSuccessPopup();
			}
		});
	} else {
		var popup = document.getElementById('form-success-popup');
		if (popup && popup.style.display !== 'none') {
			showSuccessPopup();
		}
	}
})();

