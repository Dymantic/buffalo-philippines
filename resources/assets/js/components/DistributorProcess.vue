<template>
    <div class="bb bw2 col-bb-d pb4 process-steps mb5" ref="container">
        <div class="flex flex-column items-center step-one">
            <img src="/images/distributors_process/step_1A.png"
                 alt="Step one in the distributor process cycle" class="dist-process-image">
            <p class="f5 f4-ns strong-type">Step 1</p>
            <p class="col-d mv2 tc ph4">We determine your requirements and local market information.</p>
        </div>
        <div class="flex flex-column items-center step-two">
            <img src="/images/distributors_process/step_2A.png"
                 alt="Step two in the distributor process cycle" class="dist-process-image">
            <p class="f5 f4-ns strong-type">Step 2</p>
            <p class="col-d mv2 tc ph4">We recommend suitable products for your market and provide pricing structure.</p>
        </div>
        <div class="flex flex-column items-center step-three">
            <img src="/images/distributors_process/step_4A.png"
                 alt="Step three in the distributor process cycle" class="dist-process-image">
            <p class="f5 f4-ns strong-type">Step 3</p>
            <p class="col-d mv2 tc ph4">Promotion support (Google Ads, Facebook, EDM, etc)</p>
        </div>
        <div class="flex flex-column items-center step-four">
            <img src="/images/distributors_process/step_3A.png"
                 alt="Step four in the distributor process cycle" class="dist-process-image">
            <p class="f5 f4-ns strong-type">Step 4</p>
            <p class="col-d mv2 tc ph4">Business growth and optimization.</p>
        </div>
        <div class="flex flex-column items-center step-five">
            <img src="/images/distributors_process/step_5A.png"
                 alt="Step one in the distributor process cycle" class="dist-process-image">
            <p class="f5 f4-ns strong-type">Step 5</p>
            <p class="col-d mv2 tc ph4">We continuously re-evaluate your needs and support your enterprise.</p>
        </div>
    </div>
</template>

<script type="text/babel">
    export default {
        data() {
            return {
                top: null
            }
        },

        mounted() {
            this.top = this.$refs.container.parentNode.getBoundingClientRect().top + window.scrollY - window.innerHeight;
            window.addEventListener('scroll', this.watchScroll)
        },

        methods: {
            watchScroll() {
                if(this.top && window.scrollY > this.top) {
                    this.$refs.container.classList.add("animate");
                    window.removeEventListener("scroll", this.watchScroll);
                }
            }
        }
    }
</script>

<style scoped lang="scss" type="text/scss">

</style>