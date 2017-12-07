import Flickity from "flickity-imagesloaded";

export default class SuperHero {

    constructor(el, autoplay = false) {
        this.el = document.querySelector(el);
        this.videos = this.el.querySelectorAll('video');
        this.flickity = new Flickity(el, {
            autoPlay: autoplay,
            wrapAround: true,
            arrowShape: 'M50,0a50,50,0,1,0,50,50A50,50,0,0,0,50,0ZM62.34,73.51H45.68a1.5,1.5,0,0,1-1.23-.64L28.59,52.77a4.48,4.48,0,0,1,0-5.54L44.45,27.12a1.52,1.52,0,0,1,1.23-.63H62.33a1.51,1.51,0,0,1,1.23,2.4L49.05,49.06a1.52,1.52,0,0,0,0,1.77L63.57,71.11A1.51,1.51,0,0,1,62.34,73.51Z'
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