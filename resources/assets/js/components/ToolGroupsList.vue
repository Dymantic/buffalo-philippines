<template>
    <div class="card mv3">
        <p class="ttu col-p f6">Tool Groups</p>
        <p v-if="!tool_groups.length">There are no tool groups in this subcategory yet.</p>
        <div v-for="group in tool_groups" :key="group.id">
            <a :href="`/admin/tool-groups/${group.id}`">{{ group.title }}</a>
        </div>
    </div>
</template>

<script type="text/babel">
    export default {

        props: ['fetch-url'],

        data() {
            return {
                tool_groups: []
            };
        },

        mounted() {
            this.fetchToolGroups();
            eventHub.$on('created-tool-group', this.fetchToolGroups);
        },

        methods: {
            fetchToolGroups() {
                axios.get(this.fetchUrl)
                    .then(({data}) => this.tool_groups = data)
                    .catch(err => console.log(err));
            }
        }

    }
</script>

<style scoped lang="scss" type="text/scss">

</style>