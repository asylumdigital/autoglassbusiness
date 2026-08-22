export const Local = () => ({
    state: 'waiting',
    init() {
        this.$refs.player.addEventListener('canplay', (e) => this.state = 'ready');
        this.$refs.player.addEventListener('pause', (e) => this.state = 'paused');
        this.$refs.player.addEventListener('ended', (e) => this.state = 'ended');
    },
    play() {
        if (this.state === 'waiting') {
            return;
        }
        this.state = 'playing';
        this.$refs.player.play();
    }
})
