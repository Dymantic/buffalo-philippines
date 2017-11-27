<template>
    <div>
        <form class="card flex items-center justify-between" action="" @submit.stop.prevent="submit">
            <span>Search by product name or code:</span>
            <input type="text" v-model="search_term" @input="getResults" class="w-30 h2 dib ba b-solid b--black-30 pl3">
        </form>
        <p class="card"><span class="col-p b">{{ results.length }}</span> search results for "<span class="col-p b">{{ search_term }}</span>"</p>
        <div class="card" v-show="results.length">
            <div v-for="product in results" :key="product.id" class="flex justify-between items-center bb b--black-20">
                <div class="w4 pv2">
                    <img :src="product.main_image.thumb" height="50px"
                         alt="">
                </div>

                <a :href="`/admin/products/${product.id}`" class="flex-auto link col-d">{{ product.title }}</a>
                <span class="col-p">{{ product.code }}</span>
            </div>
        </div>

    </div>
</template>

<script type="text/babel">

    import { debounce } from "lodash";

    export default {

        props: ['search-url'],

        data() {
            return {
                search_term: '',
                results: []
            };
        },

        methods: {
            submit() {

            },

            getResults: debounce(
                function() {
                    axios.get(`${this.searchUrl}?q=${this.search_term}`)
                        .then(({data}) => this.results = data)
                        .catch(err =>console.log(err));
                }, 400
            )
        }
    }
</script>

<style scoped lang="scss" type="text/scss">

</style>