(function () {
  const header = document.querySelector('[data-site-header]');
  const toggle = document.querySelector('[data-menu-toggle]');
  const nav = document.querySelector('[data-primary-nav]');

  if (toggle && nav) {
    toggle.addEventListener('click', function () {
      const isOpen = toggle.getAttribute('aria-expanded') === 'true';
      toggle.setAttribute('aria-expanded', String(!isOpen));
      nav.classList.toggle('is-open', !isOpen);
      document.body.classList.toggle('menu-open', !isOpen);
    });
  }

  const updateHeader = function () {
    if (!header) return;
    header.classList.toggle('is-scrolled', window.scrollY > 12);
  };

  updateHeader();
  window.addEventListener('scroll', updateHeader, { passive: true });

  const switcher = document.querySelector('[data-style-switcher]');
  const switcherToggle = document.querySelector('[data-style-switcher-toggle]');
  const paletteButtons = document.querySelectorAll('[data-palette-choice]');
  const paletteStorageKey = 'wswaPalette';

  const setPalette = function (palette) {
    if (!palette || palette === 'logo') {
      document.documentElement.removeAttribute('data-palette');
      try {
        localStorage.removeItem(paletteStorageKey);
      } catch (error) {}
    } else {
      document.documentElement.setAttribute('data-palette', palette);
      try {
        localStorage.setItem(paletteStorageKey, palette);
      } catch (error) {}
    }

    paletteButtons.forEach(function (button) {
      button.classList.toggle('is-active', button.getAttribute('data-palette-choice') === (palette || 'logo'));
    });
  };

  if (switcher && switcherToggle && paletteButtons.length) {
    let savedPalette = 'logo';

    try {
      savedPalette = localStorage.getItem(paletteStorageKey) || 'logo';
    } catch (error) {}

    setPalette(savedPalette);

    switcherToggle.addEventListener('click', function () {
      const isOpen = switcher.classList.toggle('is-open');
      switcherToggle.setAttribute('aria-expanded', String(isOpen));
    });

    paletteButtons.forEach(function (button) {
      button.addEventListener('click', function () {
        setPalette(button.getAttribute('data-palette-choice'));
      });
    });
  }
})();
