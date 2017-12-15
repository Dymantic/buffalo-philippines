<template>
    <div>
        <div class="ml4 mv4">
            <span class="ff-sub-headline cursor-point hv-col-p"
                  @click="requestReset">{{ categoryTitle }}</span>
            <span class="ff-sub-headline cursor-point hv-col-p"
                  v-if="subcategory.id"
                  @click="clearToolGroup"><span class="mh3 col-p"> >> </span>{{ subcategory.title }}</span>
            <span class="ff-sub-headline cursor-def"
                  v-if="tool_group.title"><span class="mh3 col-p"> >> </span>{{ tool_group.title }}</span>
        </div>
        <div class="flex">
            <div class="w-25">
                <nested-menu class="min-h-100 col-w-bg"
                             :menu-structure="menuStructure"
                             @subcategory-selected="setSubcategory"
                             @toolgroup-selected="setToolGroup"
                             @reset-category-list="resetToCategory"
                             :starting-subcategory="menuSubcategory"
                ></nested-menu>
            </div>
            <div class="w-75">
                <products-list :fetch-url="productsFetchUrl"
                               :parent-type="filter_type"
                               :subcategory-id="subcategory.id"
                               :tool-groups="combined_toolgroups"
                               :link-to-admin="forAdmin"
                ></products-list>
            </div>
        </div>
    </div>

</template>

<script type="text/babel">
    export default {

        props: ['menu-structure', 'products-fetch-url', 'category-title', 'for-admin', 'showing-type', 'show-subcategory', 'show-tool-group', 'menu-subcategory'],

        data() {
            return {
                filter_type: this.showingType || 'Category',
                subcategory: this.showSubcategory || {id: null, title: null, tool_groups: []},
                tool_group: this.showToolGroup || {id: null, title: null}
            };
        },

        computed: {
            combined_toolgroups() {
                if (this.filter_type === 'Subcategory') {
                    return this.subcategory.tool_groups;
                }

                return [this.tool_group.id];
            }
        },

        methods: {
            setSubcategory(subcategory) {
                this.filter_type = 'Subcategory';
                this.subcategory = subcategory;
                this.tool_group = {id: null, title: null}
            },

            setToolGroup(toolgroup) {
                this.filter_type = 'Tool Group';
                this.tool_group = toolgroup;
            },

            resetToCategory() {
                this.filter_type = 'Category';
                this.subcategory = {id: null, title: null, tool_groups: []};
                this.tool_group = {id: null, title: null}
            },

            clearToolGroup() {
                this.tool_group = {id: null, title: null};
                this.filter_type = 'Subcategory';
            },

            requestReset() {
                eventHub.$emit('reset-category-menu');
            }
        }
    }
</script>

<style scoped
       lang="scss"
       type="text/scss">

</style>