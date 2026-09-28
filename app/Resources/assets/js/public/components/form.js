export const Form = (path) => ({
    height: `50px`,
    offset: 65, // additional height if needed
    path,
    init() {
        window.addEventListener('message', e => {
            const { data: { k } } = e;

            console.log(e.data);
            if (!k || k !== 'contact_form') {
                return;
            }

            const {
                data: {
                    w,
                    h,
                    p,
                }
            } = e

            if (btoa(p) === this.path) {
                this.height = `${h + this.offset}px`;
                return;
            }

            console.log(p);
            // const key = e.message ? 'message' : 'data';
            // const data = e[key];

            // ...
        }, false);
    },
})
