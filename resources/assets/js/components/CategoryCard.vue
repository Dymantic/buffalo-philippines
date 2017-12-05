<template>
    <div class="card mv3">
        <p class="col-p ttu f4 b mb0">
            <a :href="`/admin/categories/${itemAttributes.id}`"
               class="link col-p"
            >{{ title }}</a>
        </p>
        <p class="f4 mv1">{{ description }}</p>
    </div>
</template>

<script type="text/babel">
    export default {

        props: ['item-attributes'],

        data() {
            return {
                title: this.itemAttributes.title,
                description: this.itemAttributes.description
            };
        }
    }
</script>

<style scoped
       lang="scss"
       type="text/scss">

</style>