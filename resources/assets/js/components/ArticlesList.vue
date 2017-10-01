<template>
    <div class="articles-list-component">
        <div class="card">
            <table>
                <thead>
                <tr>
                    <th>Date</th>
                    <th>Title</th>
                    <th>Published Status</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="article in articles" :key="article.id">
                    <td>{{ article.created_at }}</td>
                    <td><a class="link col-p" :href="`/admin/articles/${article.id}`">{{ article.title }}</a></td>
                    <td>{{ article.published_status }}</td>
                </tr>
                </tbody>
            </table>
        </div>
        <div class="list-pagination card" v-if="page_links.length > 1">
            <p class="label">Pages</p>
            <span class="page-link" v-for="(page_link, page_number) in page_links" @click="fetchArticles(page_number)">{{ page_number }}</span>
        </div>
    </div>
</template>

<script type="text/babel">
    export default {

        props: ['initial-list'],

        data() {
            return {
                articles: this.initialList || [],
                page_links: [],
                current_page: 1
            };
        },

        mounted() {
            eventHub.$on('created-article', () => this.fetchArticles());
            this.fetchArticles();
        },

        methods: {

            fetchArticles(page_number = 1) {
                axios.get(`/admin/services/articles?page=${page_number}`)
                    .then(({data}) => this.setFetchedData(data))
                    .catch(err => console.log(err));
            },

            setFetchedData(fetched_data) {
                this.articles = fetched_data.articles;
                this.page_links = fetched_data.page_links;
                this.current_page = fetched_data.current_page;
            }
        }
    }
</script>

<style scoped lang="scss" type="text/scss">
    table {
        width: 100%;
    }

    thead th {
        padding-bottom: 20px;
        padding-left: 10px;
        text-align: left;
    }

    tbody td {
        padding: 5px 0 5px 10px;
    }

    .list-pagination {
        .page-link {
            display: inline-block;
            margin: 0 1em;
            cursor: pointer;

            &:hover {
                color: #1b6d85;
            }
        }
    }
</style>