(function () {
  const header = document.querySelector('[data-site-header]');
  const toggle = document.querySelector('[data-menu-toggle]');
  const nav = document.querySelector('[data-primary-nav]');
  const mobile = window.matchMedia('(max-width: 1100px)');

  if (toggle && nav) {
    const branches = [];
    nav.querySelectorAll('li').forEach(function (item, index) {
      const submenu = item.querySelector(':scope > .sub-menu');
      const link = item.querySelector(':scope > a');
      if (!submenu || !link) return;
      submenu.id = submenu.id || 'primary-submenu-' + index;
      const button = document.createElement('button');
      button.type = 'button';
      button.className = 'submenu-toggle';
      button.setAttribute('aria-controls', submenu.id);
      button.setAttribute('aria-expanded', 'false');
      button.setAttribute('aria-label', 'Toggle ' + link.textContent.trim() + ' submenu');
      button.textContent = '+';
      link.after(button);
      branches.push({ item, submenu, button });
      button.addEventListener('click', function () {
        const open = button.getAttribute('aria-expanded') !== 'true';
        branches.filter(branch => branch.item.parentElement === item.parentElement || item.contains(branch.item))
          .forEach(branch => setBranch(branch, false));
        setBranch({ item, submenu, button }, open);
      });
    });
    function setBranch(branch, open) {
      branch.button.setAttribute('aria-expanded', String(open));
      branch.button.textContent = open ? '−' : '+';
      branch.submenu.hidden = mobile.matches && !open;
    }
    function resetBranches() { branches.forEach(branch => setBranch(branch, false)); }
    function measureMenu() {
      // Measure the actual header; the logo and WordPress admin bar can change its height.
      nav.style.setProperty('--nav-top', Math.max(0, header.getBoundingClientRect().bottom) + 'px');
    }
    function closeMenu(restoreFocus) {
      toggle.setAttribute('aria-expanded', 'false');
      nav.classList.remove('is-open');
      resetBranches();
      if (restoreFocus) toggle.focus();
    }
    toggle.addEventListener('click', function () {
      const open = toggle.getAttribute('aria-expanded') !== 'true';
      closeMenu(false);
      if (open) {
        measureMenu();
        toggle.setAttribute('aria-expanded', 'true');
        nav.classList.add('is-open');
        nav.scrollTop = 0;
      }
    });
    document.addEventListener('click', function (event) {
      if (!nav.contains(event.target) && !toggle.contains(event.target)) closeMenu(false);
    });
    document.addEventListener('keydown', function (event) {
      if (event.key !== 'Escape') return;
      const branch = branches.slice().reverse().find(branch => branch.item.contains(document.activeElement) && branch.button.getAttribute('aria-expanded') === 'true');
      if (branch) {
        branches.filter(child => branch.item.contains(child.item)).forEach(child => setBranch(child, false));
        branch.button.focus();
      } else if (toggle.getAttribute('aria-expanded') === 'true') closeMenu(true);
    });
    nav.addEventListener('click', function (event) { if (event.target.closest('a')) closeMenu(false); });
    // This is a nonmodal disclosure: keyboard users can tab out and page scrolling stays available.
    document.addEventListener('focusin', function (event) {
      if (!header.contains(event.target)) closeMenu(false);
    });
    mobile.addEventListener('change', function () { closeMenu(false); });
    window.addEventListener('resize', measureMenu, { passive: true });
    window.addEventListener('scroll', measureMenu, { passive: true });
    if (window.visualViewport) window.visualViewport.addEventListener('resize', measureMenu, { passive: true });
    resetBranches();
  }

  const updateHeader = function () {
    if (!header) return;
    header.classList.toggle('is-scrolled', window.scrollY > 12);
  };
  updateHeader();
  window.addEventListener('scroll', updateHeader, { passive: true });
})();
