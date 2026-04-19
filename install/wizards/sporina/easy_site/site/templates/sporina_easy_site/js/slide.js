var bgImages = [/*'bg_slider-main-1', */'bg_slider-main-2', 'bg_slider-main-3'];
var randomIndex = Math.floor(Math.random() * bgImages.length);
var bgElement = document.querySelector('.bg-element');
bgElement.classList.add(bgImages[randomIndex]);