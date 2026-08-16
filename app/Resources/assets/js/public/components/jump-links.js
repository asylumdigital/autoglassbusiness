export const ScrollSpy = () => ({
    activeId: '',
    init() {
        this.update();
        window.addEventListener('scroll', () => this.update(), { passive: true });
    },

    update() {
        const headings = document.querySelectorAll('h2[id], h3[id]');
        let current = '';
        headings.forEach((h) => {
            if (window.scrollY >= h.offsetTop - 140) current = h.id;
        });
        this.activeId = current;
    },

    isActive(id) {
        return this.activeId === id;
    },
})
