import './bootstrap';

const menuToggle = document.querySelector('[data-menu-toggle]');
const mobileMenu = document.querySelector('[data-mobile-menu]');

menuToggle?.addEventListener('click', () => {
    const isOpen = menuToggle.getAttribute('aria-expanded') === 'true';

    menuToggle.setAttribute('aria-expanded', String(!isOpen));
    menuToggle.querySelector('.sr-only').textContent = isOpen ? 'Abrir menu' : 'Fechar menu';
    mobileMenu.hidden = isOpen;
});

mobileMenu?.querySelectorAll('a').forEach((link) => {
    link.addEventListener('click', () => {
        menuToggle?.setAttribute('aria-expanded', 'false');
        if (menuToggle) menuToggle.querySelector('.sr-only').textContent = 'Abrir menu';
        mobileMenu.hidden = true;
    });
});

const filters = document.querySelectorAll('[data-filter]');
const cards = document.querySelectorAll('[data-category]');
const emptyState = document.querySelector('[data-filter-empty]');

filters.forEach((filter) => {
    filter.addEventListener('click', () => {
        const selected = filter.dataset.filter;
        let visibleCount = 0;

        filters.forEach((item) => item.classList.toggle('is-active', item === filter));
        cards.forEach((card) => {
            const shouldShow = selected === 'all' || card.dataset.category === selected;
            card.hidden = !shouldShow;
            if (shouldShow) visibleCount += 1;
        });
        emptyState.hidden = visibleCount !== 0;
    });
});

const contactForm = document.querySelector('[data-contact-form]');
const formFeedback = document.querySelector('[data-form-feedback]');

contactForm?.addEventListener('submit', (event) => {
    event.preventDefault();
    formFeedback.hidden = false;
    contactForm.reset();
});

document.querySelectorAll('[data-current-year]').forEach((element) => {
    element.textContent = new Date().getFullYear();
});

const revealItems = document.querySelectorAll('[data-reveal]');
const reveal = (item) => item.classList.add('is-visible');

if ('IntersectionObserver' in window && !window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
    const observer = new IntersectionObserver((entries, observerInstance) => {
        entries.forEach((entry) => {
            if (!entry.isIntersecting) return;
            window.setTimeout(() => reveal(entry.target), Number(entry.target.dataset.revealDelay || 0));
            observerInstance.unobserve(entry.target);
        });
    }, { threshold: 0.12 });

    revealItems.forEach((item) => observer.observe(item));
} else {
    revealItems.forEach(reveal);
}
