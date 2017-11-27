<template>
    <div class="dib">
        <span @click="toggleSearch" class="col-w">
            <svg xmlns="http://www.w3.org/2000/svg"
                 viewBox="0 0 24 24" height="34px">
    <path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/>
</svg>
        </span>
        <div class="h5 col-d-bg w-100 search-box"
             :class="{'open': open}">
            <form method="GET"
                  action=""
                  class="h5 flex justify-center items-center"
                  @submit.stop.prevent="submit">
                <input v-model="search_term"
                       type="text"
                       class="pl3 f-headline strong-type col-w col-d-bg"
                       ref="searchinput"
                       placeholder="Search our products"
                >
            </form>
        </div>
    </div>
</template>

<script type="text/babel">
    export default {

        data() {
            return {
                open: false,
                search_term: ''
            };
        },

        mounted() {
            eventHub.$on('KEY_SEARCH', this.toggleSearch);
            eventHub.$on('KEY_ESC', () => this.open = false);
        },

        methods: {
            toggleSearch() {
                if (this.open) {
                    return this.open = false;
                }

                return this.expose();
            },

            expose() {
                this.open = true;
                this.$refs.searchinput.focus();
            },

            submit() {
                window.location = `/search/products?q=${this.search_term}`;
            }
        }
    }
</script>

<style scoped
       lang="scss"
       type="text/scss">

    .search-box {
        position: fixed;
        top: 60px;
        right: 0;
        transform: scale(0);
        transform-origin: right top;
        transition: .3s;

        &.open {
            transform: scale(1);
        }

        input {
            outline: none;
            width: 95%;
            border: none;
            border-bottom: 4px solid white;
        }
    }
</style>