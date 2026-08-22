import YouTubeIframeLoader from 'youtube-iframe';

export const YouTube = (id) => ({
    id,
    state: 'waiting',
    player: null,
    play() {
        if (!this.player) {
            return this.embed();
        }

        this.player.playVideo();
    },
    embed() {
        YouTubeIframeLoader.load((YT) => {
            this.youtube = YT;

            const player = new YT.Player(this.$refs.player, {
                height: '100%',
                width: '100%',
                videoId: this.id,
                events: {
                    onReady: this.onPlayerReady.bind(this),
                    onStateChange: this.onPlayerStateChange.bind(this),
                },
                playerVars: {
                    'playsinline': 1,
                    'rel': 0,
                    autoplay: true,
                    // 'start': this.start,
                    // 'controls': this.controls,
                },
                host: 'https://www.youtube-nocookie.com',
            })

            this.player = player;
        });
    },
    onPlayerReady() {
        this.state = 'ready';
    },
    onPlayerStateChange() {
        const {
            BUFFERING,
            ENDED,
            PLAYING,
            PAUSED
        } = this.youtube.PlayerState;

        const state = this.player.getPlayerState();

        switch (state) {
            case BUFFERING:
            case ENDED:
            case PAUSED:
                this.state = 'pause';
                break;
            case PLAYING:
                this.state = 'playing';
                break;
        }
    },
})
