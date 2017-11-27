import Flickity from "flickity-imagesloaded";

export default class SuperHero {

    constructor(el, autoplay = false) {
        this.el = document.querySelector(el);
        this.videos = this.el.querySelectorAll('video');
        this.flickity = new Flickity(el, {
            autoPlay: autoplay,
            wrapAround: true
        });
    }

    fly() {
        this.flickity.on('settle', () => this.handleSlideChange());
        this.playCurrentVideo();
    }

    handleSlideChange() {
        this.stopVideos();
        this.playCurrentVideo();
    }

    stopVideos() {
        for(let i = 0; i < this.videos.length; i++) {
            this.videos[i].pause();
            this.videos[i].currentTime = 0;
        }
    }

    playCurrentVideo() {
        const el = this.flickity.selectedElement;
        const video = el.querySelector('video');
        if(!video) {
            return;
        }
        video.play();
    }
}