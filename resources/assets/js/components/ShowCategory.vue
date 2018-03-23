<template>
    <div class="category-page">
        <div class="db dn-ns ph4 mv3">
            <p @click="show_menu = !show_menu"
               class="ff-subsub-headline col-mg">{{ show_menu_text }}</p>
        </div>
        <div class="ml4 mv4">
            <span class="ff-subsub-headline cursor-point hv-col-p"
                  @click="resetToCategory">{{ category_name }}</span>
            <span class="ff-subsub-headline cursor-point hv-col-p"
                  v-if="selected_subcategory"
                  @click="setSubcategory(selected_subcategory)"><span class="mh3 col-p"> >> </span>{{ selected_subcategory.title }}</span>
            <span class="ff-subsub-headline cursor-def"
                  v-if="selected_toolgroup"><span class="mh3 col-p"> >> </span>{{ selected_toolgroup.title }}</span>
        </div>
        <div class="flex relative">
            <div class="menu-bar absolute relative-ns w-90 w-25-ns"
                 :class="{'expose': show_menu}">
                <nested-menu class="min-h-100 col-w-bg"
                             :subcategories="subcategories"
                             :subcategory="selected_subcategory"
                             :toolgroups="menu_tool_groups"
                             @subcategory-selected="setSubcategory"
                             @toolgroup-selected="setToolGroup"
                             @reset-category-list="resetToCategory"
                             @hide-menu="show_menu = false"
                             :menu-type="menu_type"
                ></nested-menu>
            </div>
            <div class="w-100 w-75-ns">
                <products-list :fetch-url="productsFetchUrl"
                               :filter-type="filter_type"
                               :subcategory="selected_subcategory"
                               :tool-groups="combined_toolgroups"
                               :link-to-admin="forAdmin"
                               @page-selected="handlePageChange"
                ></products-list>
            </div>
        </div>
    </div>

</template>

<script type="text/babel">
    export default {

        props: ['menu-structure', 'products-fetch-url', 'for-admin', 'showing-type', 'show-subcategory', 'show-tool-group'],

        data() {
            return {
                filter_type: this.showingType || 'category',
                show_menu: false,
                selected_subcategory: null,
                selected_toolgroup: null,
            };
        },

        mounted() {
            window.addEventListener('popstate', (ev) => this.setFromState(ev.state));
            const parsedUrl = new URL(window.location.href);
            const subcategory = parsedUrl.searchParams.get("subcategory");
            const toolgroup = parsedUrl.searchParams.get("toolgroup");
            const page = (parsedUrl.searchParams.get("page") || 1) - 1;

            if (subcategory) {
                return this.setFromState({filter_type: 'subcategory', group_id: parseInt(subcategory), page});
            }

            if (toolgroup) {
                return this.setFromState({filter_type: 'tool_group', group_id: parseInt(toolgroup), page});
            }

            this.setFromState({filter_type: 'category', group_id: null, page});
        },

        computed: {
            combined_toolgroups() {
                if (this.filter_type === 'subcategory') {
                    return this.selected_subcategory.children.map(tool_group => ({
                        id: tool_group.id,
                        title: tool_group.title
                    }));
                }

                return [this.selected_toolgroup];
            },

            show_menu_text() {
                return this.show_menu ? 'Hide menu' : 'Browse categories';
            },

            menu_type() {
                if (!this.selected_subcategory && !this.selected_toolgroup) {
                    return 'subcategory';
                }

                return (this.selected_toolgroup || this.selected_subcategory.children.length) ? 'tool_group' : 'subcategory';
            },

            subcategories() {
                return this.menuStructure.children.map(subcategory => ({
                    id: subcategory.id,
                    title: subcategory.title,
                    has_toolgroups: subcategory.children.length > 0
                }));
            },

            menu_tool_groups() {
                if (this.selected_subcategory) {
                    return this.selected_subcategory.children;
                }
                return [];
            },

            category_name() {
                return this.menuStructure.title;
            },

            category_slug() {
                return this.menuStructure.slug;
            }
        },

        methods: {
            getSubcategoryById(id) {
                return this.menuStructure.children.find(subcategory => subcategory.id === id);
            },

            getToolGroupById(id) {
                let toolgroups = [];

                this.menuStructure.children.forEach(subcategory => toolgroups = toolgroups.concat(subcategory.children));

                return toolgroups.find(tg => tg.id === id);
            },

            setSubcategory({id: subcategory_id}) {
                const subcategory = this.getSubcategoryById(subcategory_id);
                this.showSelectedSubcategory(subcategory);

                this.pushHistoryState(
                    'subcategory',
                    subcategory_id,
                    this.makeUrlPath('subcategory')
                );

            },

            showSelectedSubcategory(subcategory) {
                this.filter_type = 'subcategory';
                this.selected_subcategory = subcategory;
                this.selected_toolgroup = null;

                if (!subcategory.children.length) {
                    this.show_menu = false;
                }
            },

            setToolGroup(toolgroup) {
                this.showSelectedToolGroup(toolgroup);
                this.pushHistoryState(
                    'tool_group',
                    toolgroup.id,
                    this.makeUrlPath('tool_group')
                );
            },

            showSelectedToolGroup(toolgroup) {
                this.show_menu = false;
                this.filter_type = 'tool_group';
                this.selected_toolgroup = toolgroup;
                if (!this.selected_subcategory) {
                    this.selected_subcategory = this.menuStructure.children.find(subcategory => subcategory.children.find(tg => tg.id === toolgroup.id));
                }
            },

            resetToCategory() {
                this.pushHistoryState('category', null, this.makeUrlPath('category'));
                this.showCategory();
            },

            showCategory() {
                this.selected_subcategory = null;
                this.selected_toolgroup = null;
                this.filter_type = 'category';
            },

            pushHistoryState(filter_type, group_id, path, page = 0) {
                window.history.pushState({filter_type, group_id, page}, null, path);
            },

            setFromState(state) {
                if (state === null) {
                    return this.showCategory();
                }

                if (state.page !== null) {
                    eventHub.$emit('request-product-page', state.page);
                }

                if (state.filter_type === 'subcategory') {
                    return this.showSelectedSubcategory(this.getSubcategoryById(state.group_id));
                }

                if (state.filter_type === 'tool_group') {
                    return this.showSelectedToolGroup(this.getToolGroupById(state.group_id));
                }

                this.showCategory();
            },

            handlePageChange(page_number) {
                const group = this.filter_type === 'subcategory' ? this.selected_subcategory.id : (this.selected_toolgroup && this.selected_toolgroup.id);
                this.pushHistoryState(this.filter_type, group, this.makeUrlPath(this.filter_type, page_number + 1), page_number);
            },

            makeUrlPath(filter_type, page_number = 1) {
                const base = this.forAdmin ? 'admin/categories' : 'categories';
                const category_identitifier = this.forAdmin ? `${this.menuStructure.id}/products` : this.menuStructure.slug;

                switch (filter_type) {
                    case 'subcategory':
                        return this.withPage(`/${base}/${category_identitifier}?subcategory=${this.selected_subcategory.id}`, page_number);
                        break;
                    case 'tool_group':
                        return this.withPage(`/${base}/${category_identitifier}?toolgroup=${this.selected_toolgroup.id}`, page_number);
                        break;
                    default:
                        return this.withPage(`/${base}/${category_identitifier}`, page_number);
                }
            },

            withPage(path, page_number) {
                if (page_number < 2) {
                    return path;
                }

                if (path.indexOf('?') === -1) {
                    return `${path}?page=${page_number}`;
                }

                return `${path}&page=${page_number}`;
            },
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
            transform: translate3d(-100%, 0, 0);

            &.expose {
                transform: translate3d(0, 0, 0);
            }
        }
    }

</style>