<template>
    <div class="card">
        <p class="ttu col-p f6">Subcategories</p>
        <p v-if="!category.children.length">This category has no subcategories yet.</p>
        <div v-for="subcategory in category.children" :key="subcategory.id">
            <a class="link b col-d" :href="`/admin/subcategories/${subcategory.id}`">{{ subcategory.title }}</a>
            <ul class="list">
                <li v-for="tool_group in subcategory.children" :key="tool_group.id">
                    <a class="link b col-mg" :href="`/admin/tool-groups/${tool_group.id}`">{{ tool_group.title }}</a>
                </li>
            </ul>
        </div>
    </div>
</template>

<script type="text/babel">
    export default {

        props: ['category'],

        data() {
            return {
                subcategories: []
            };
        }
    }
</script>

<style scoped lang="scss" type="text/scss">

</style>