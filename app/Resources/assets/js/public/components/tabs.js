export const Tabs = (selected = null) => ({
    tab: null,
    init() {
        this.setTab();
        addEventListener("popstate", this.setTab.bind(this));

        this.$watch('tab', (value) => {
            const params = new URLSearchParams(location.search);
            params.set('tab', value);
            window.history.pushState({}, "", decodeURIComponent(`${location.pathname}?${params}`));
        });
    },
    setTab() {
        const params = Object.fromEntries(new URLSearchParams(location.search));
        const { tab } = params;
        this.tab = tab || selected;
    },

});
