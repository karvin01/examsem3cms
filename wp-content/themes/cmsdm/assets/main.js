document.addEventListener('DOMContentLoaded', function () {

    // JS for the hamburger menu
    const toggleBtn = document.getElementById('menu-toggle');
    const navMenu = document.getElementById('primary-menu');

    if (toggleBtn && navMenu) {
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
    }

    // closing of the promocode banner
    const promoBanner = document.querySelector('.shop-promo-banner');
    if (promoBanner) {
        const closeBtn = promoBanner.querySelector('.promo-close');
        if (closeBtn) {
            closeBtn.addEventListener('click', () => {
                promoBanner.style.display = 'none';
            });
        }
    }

    // category filter on webshop collapses when opened under 1024px width screen
    if (window.innerWidth <= 1024) {
        document.querySelectorAll('.category-collapsible').forEach(el => el.removeAttribute('open'));
    }

    // test drive page logic
    const form = document.getElementById('testRideForm');
    if (form) {
        const steps = Array.from(form.querySelectorAll('.form-step'));
        const indicators = Array.from(document.querySelectorAll('.step-indicator'));
        const progressFill = document.getElementById('progressFill');
        let currentStep = 1;

        function goToStep(targetStep) {
            steps.forEach((step) => {
                const isTarget = parseInt(step.dataset.step, 10) === targetStep;
                step.hidden = !isTarget;
                step.classList.toggle('active', isTarget);
            });

            indicators.forEach((indicator) => {
                const stepNum = parseInt(indicator.dataset.step, 10);
                indicator.classList.toggle('active', stepNum === targetStep);
                indicator.classList.toggle('completed', stepNum < targetStep);
            });

            if (progressFill) {
                progressFill.style.width = `${(targetStep / steps.length) * 100}%`;
            }

            // Accessibility focus: move focus to the first interactive input in new step
            const activeStep = steps.find(s => parseInt(s.dataset.step, 10) === targetStep);
            if (activeStep) {
                const firstControl = activeStep.querySelector('input:not([type="hidden"]), select, textarea');
                if (firstControl) firstControl.focus();
            }

            currentStep = targetStep;
        }

        function isStepValid(stepNumber) {
            const activeStep = steps.find(s => parseInt(s.dataset.step, 10) === stepNumber);
            if (!activeStep) return true;

            const inputs = Array.from(activeStep.querySelectorAll('input[required], select[required], textarea[required]'));
            for (const input of inputs) {
                if (!input.checkValidity()) {
                    input.reportValidity();
                    return false;
                }
            }
            return true;
        }

        // Next step button listeners
        form.querySelectorAll('.next-step').forEach((btn) => {
            btn.addEventListener('click', () => {
                if (isStepValid(currentStep) && currentStep < steps.length) {
                    goToStep(currentStep + 1);
                }
            });
        });

        // Previous step button listeners
        form.querySelectorAll('.prev-step').forEach((btn) => {
            btn.addEventListener('click', () => {
                if (currentStep > 1) {
                    goToStep(currentStep - 1);
                }
            });
        });
    }

    // checkout page fix for ARIA issue
    // WCAG Best Practice: Fix presentational Stripe iframes & invalid div aria-disabled
    (function() {
        function cleanCheckoutAccessibility() {
            // 1. Remove prohibited aria-disabled on generic divs
            document.querySelectorAll('div[aria-disabled]').forEach(function(el) {
                el.removeAttribute('aria-disabled');
            });

            // 2. Fix presentational iframe conflict:
            // Remove role="presentation" or role="none" if the iframe has ARIA attributes/title
            document.querySelectorAll('iframe[role="presentation"], iframe[role="none"]').forEach(function(frame) {
                frame.removeAttribute('role');
                if (!frame.getAttribute('title')) {
                    frame.setAttribute('title', 'Payment Provider Component');
                }
            });
        }

        if (document.body && document.body.classList.contains('woocommerce-checkout')) {
            cleanCheckoutAccessibility();

            const observer = new MutationObserver(function() {
                cleanCheckoutAccessibility();
            });

            observer.observe(document.body, {
                childList: true,
                subtree: true,
                attributes: true,
                attributeFilter: ['aria-disabled', 'role']
            });
        }
    })();

});