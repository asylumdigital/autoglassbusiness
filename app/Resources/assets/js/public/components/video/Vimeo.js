import Vimeo from '@vimeo/player';
export const VimeoPlayer = (id) => ({
    id,
    state: 'playing',
    // state: 'waiting',
    player: null,
    init() {
        this.embed()
    },
    embed() {
        const options = {
            id: this.id,
            width: 640,
            loop: false
        };

        this.player = new Vimeo(this.$refs.player, options);

        // player.setVolume(0);

        // player.on('play', function () {
        //     console.log('played the video!');
        // });
    },
    play() {},
})
