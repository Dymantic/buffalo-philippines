<template>
    <div class="relative menu-container w-100">
        <div class="mainmenu w6 pa4 col-w-bg">
            <p class="strong-type ttu"
               @click="returnToBase">{{ menuStructure.title }}</p>
            <div v-for="category in menuStructure.children"
                 :key="category.id"
                 @click.stop.prevent="showSub(category)"
                 class="flex justify-between items-center pv2 hv-bg-grey"
            >
                <a :href="category.link"
                   class="link col-d">{{ category.title }}</a>
                <span @click="showSub(category)"
                      v-if="category.children.length">&raquo;</span>
            </div>
        </div>
        <div class="absolute submenu pa4 w6 col-w-bg"
             :class="{'exposed': level === 2}">
            <p class="strong-type ttu">
                <span @click="returnToBase"
                      class="mr4 col-p">&larr;</span>
                <span @click="resetToSubcategory">{{ sub_title }}</span>
            </p>
            <div v-for="subcategory in sub_children"
                 :key="subcategory.id"
                 class="flex justify-between items-center pv2 hv-bg-grey"
                 @click.stop.prevent="showToolGroup(subcategory)"
            >
                <a :href="subcategory.link"
                   class="link col-d">{{ subcategory.title }}</a>
            </div>
        </div>
    </div>

</template>

<script type="text/babel">
    export default {

        props: ['menu-structure'],

        data() {
            return {
                selected_item: null,
                level: 1,
                sub_id: null,
                sub_title: '',
                sub_children: []
            };
        },

        computed: {
            nestedMenu() {
                const nested = this.selected_item;
                if (!nested.children) {
                    nested.children = [];
                }
                return nested;
            }
        },

        methods: {
            showSub(category) {
                if (category.children.length) {
                    this.exposeSubmenu(category);
                }

                eventHub.$emit('subcategory-chosen', {id: category.id, tool_groups: category.children.map(c => c.id)});

            },

            showToolGroup(toolGroup) {
                eventHub.$emit('toolgroup-chosen', {id: toolGroup.id});
            },

            returnToBase() {
                this.level = 1;
                this.sub_id = null;
                this.sub_children = null;
                eventHub.$emit('reset-category-list');
            },

            resetToSubcategory() {
                eventHub.$emit('subcategory-chosen', {id: this.sub_id, tool_groups: this.sub_children.map(c => c.id)});
            },

            exposeSubmenu(category) {
                this.sub_title = category.title;
                this.sub_children = category.children;
                this.sub_id = category.id;
                this.level = 2;
            }
        }
    }
</script>

<style scoped
       lang="scss"
       type="text/scss">
    .menu-container {
        overflow-x: hidden;
    }

    .submenu {
        top: 0;
        bottom: 0;
        overflow-y: auto;
        width: 100%;
        left: 0;
        transition: .5s;
        transform: translate3d(100%, 0, 0);

        &.exposed {
            transform: translate3d(0, 0, 0);
        }
    }
</style>