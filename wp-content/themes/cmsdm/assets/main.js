// JS for the hamburger menu
document.addEventListener('DOMContentLoaded', function () {
    const toggleBtn = document.getElementById('menu-toggle');
    const navMenu = document.getElementById('primary-menu');

    if (!toggleBtn || !navMenu) return;

    toggleBtn.addEventListener('click', function (e) {
        e.preventDefault();
        const isOpen = navMenu.classList.toggle('is-open');
        toggleBtn.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
        toggleBtn.setAttribute('aria-label', isOpen ? 'Close main menu' : 'Open main menu');
    });

    // Close on Escape key (WCAG Best Practice)
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && navMenu.classList.contains('is-open')) {
            navMenu.classList.remove('is-open');
            toggleBtn.setAttribute('aria-expanded', 'false');
            toggleBtn.setAttribute('aria-label', 'Open main menu');
            toggleBtn.focus();
        }
    });
});