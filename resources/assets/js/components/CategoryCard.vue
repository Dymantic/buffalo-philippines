<template>
    <div class="card mv3">
        <p class="col-p ttu f3"><a :href="`/admin/categories/${itemAttributes.id}`"
                                   class="link col-p">{{ title }}</a></p>
        <p class="f4">{{ description }}</p>
        <div class="flex justify-end">
            <category-form :url="`/admin/categories/${itemAttributes.id}`"
                           :form-attributes="itemAttributes"
                           form-type="update"
                           button-text="Edit"
                           @updated-category="updateCategory"
            ></category-form>
        </div>
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
        },

        methods: {
            updateCategory({title, description}) {
                this.title = title;
                this.description = description
            }
        }
    }
</script>

<style scoped lang="scss" type="text/scss">

</style>