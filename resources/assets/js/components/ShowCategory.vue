<template>
    <div class="category-page">
        <div class="db dn-ns ph4 mv3">
            <p @click="show_menu = !show_menu" class="ff-subsub-headline col-mg">{{ show_menu_text }}</p>
        </div>
        <div class="ml4 mv4">
            <span class="ff-subsub-headline cursor-point hv-col-p"
                  @click="requestReset">{{ categoryTitle }}</span>
            <span class="ff-subsub-headline cursor-point hv-col-p"
                  v-if="subcategory.id"
                  @click="clearToolGroup"><span class="mh3 col-p"> >> </span>{{ subcategory.title }}</span>
            <span class="ff-subsub-headline cursor-def"
                  v-if="tool_group.title"><span class="mh3 col-p"> >> </span>{{ tool_group.title }}</span>
        </div>
        <div class="flex relative">
            <div class="menu-bar absolute relative-ns w-90 w-25-ns" :class="{'expose': show_menu}">
                <nested-menu class="min-h-100 col-w-bg"
                             :menu-structure="menuStructure"
                             @subcategory-selected="setSubcategory"
                             @toolgroup-selected="setToolGroup"
                             @reset-category-list="resetToCategory"
                             :starting-subcategory="menuSubcategory"
                             @hide-menu="show_menu = false"
                ></nested-menu>
            </div>
            <div class="w-100 w-75-ns">
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
                tool_group: this.showToolGroup || {id: null, title: null},
                show_menu: false
            };
        },

        computed: {
            combined_toolgroups() {
                if (this.filter_type === 'Subcategory') {
                    return this.subcategory.tool_groups;
                }

                return [this.tool_group.id];
            },

            show_menu_text() {
                return this.show_menu ? 'Hide menu' : 'Filter products';
            }
        },

        methods: {
            setSubcategory(subcategory) {
                this.filter_type = 'Subcategory';
                this.subcategory = subcategory;
                this.tool_group = {id: null, title: null}

                if(!subcategory.tool_groups.length) {
                    this.show_menu = false;
                }
            },

            setToolGroup(toolgroup) {
                this.show_menu = false;
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

    .category-page {
        min-height: 100vh;
    }



    @media only screen and (max-width: 30em) {
        .menu-bar {
            top: 0;
            bottom: 0;
            left: 0;
            transition: .3s;
            transform: translate3d(-100%,0,0);

            &.expose {
                transform: translate3d(0,0,0);
            }
        }
    }

</style>