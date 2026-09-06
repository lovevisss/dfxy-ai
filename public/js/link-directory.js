(() => {
    const search = document.querySelector('#link-search');
    if (!search) return;
    const cards = [...document.querySelectorAll('[data-link-card]')];
    const groups = [...document.querySelectorAll('[data-link-group]')];
    const status = document.querySelector('[data-search-status]');
    const filter = () => {
        const query = search.value.trim().toLocaleLowerCase();
        let visible = 0;
        cards.forEach(card => {
            card.hidden = !card.dataset.search.toLocaleLowerCase().includes(query);
            if (!card.hidden) visible++;
        });
        groups.forEach(group => {
            group.hidden = !!query && ![...group.querySelectorAll('[data-link-card]')].some(card => !card.hidden);
        });
        document.querySelector('[data-empty]').hidden = visible > 0;
        status.hidden = !query;
        status.textContent = `找到 ${visible} 个匹配链接`;
    };
    search.addEventListener('input', filter);
    document.querySelector('[data-search-form]').addEventListener('submit', event => { event.preventDefault(); filter(); });
    document.querySelector('[data-clear-search]')?.addEventListener('click', () => { search.value = ''; filter(); search.focus(); });
    document.querySelectorAll('[data-category-nav]').forEach(link => link.addEventListener('click', () => { search.value = ''; filter(); }));
    document.addEventListener('keydown', event => {
        if (event.key === '/' && !event.ctrlKey && !event.metaKey && !event.altKey && !event.target.closest('input, textarea, select, [contenteditable]')) {
            event.preventDefault();
            search.focus();
        }
    });
    const categoryLinks = [...document.querySelectorAll('.sidebar [data-category-nav]')];
    const syncCategory = () => {
        categoryLinks.forEach(link => {
            const active = link.hash === window.location.hash;
            link.classList.toggle('is-active', active);
            if (active) link.setAttribute('aria-current', 'location');
            else link.removeAttribute('aria-current');
        });
    };
    window.addEventListener('hashchange', syncCategory);
    syncCategory();
})();
