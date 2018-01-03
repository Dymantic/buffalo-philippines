<template>
    <div class="relative menu-container w-100">
        <div class="mainmenu w6 pa4 col-w-bg" :class="{'covered': level == 2}">
            <div v-for="subcategory in menuStructure.children"
                 :key="subcategory.id"
                 @click.stop.prevent="showSub(subcategory)"
                 class="flex justify-between items-center pv2 hv-bg-grey"
            >
                <a :href="subcategory.link"
                   class="link col-d hv-col-p">{{ subcategory.title }}</a>
                <span v-if="subcategory.children.length" class="strong-type b f4">&raquo;</span>
            </div>
        </div>
        <div class="absolute submenu pa4 w6 col-w-bg"
             :class="{'exposed': level === 2}">
            <div class="ff-subsub-headline flex items-center mb3">
                <span @click="returnToBase"
                      class="mr4 col-p hv-col-pd b cursor-point">&larr;</span>
                <span @click="resetToSubcategory" class="hv-col-p cursor-point">{{ selected_subcategory.title }}</span>
            </div>
            <div v-for="toolgroup in selected_subcategory.children"
                 :key="toolgroup.id"
                 class="flex justify-between items-center pv2 hv-bg-grey"
                 @click.stop.prevent="showToolGroup(toolgroup)"
            >
                <a :href="toolgroup.link"
                   class="link col-d hv-col-p">{{ toolgroup.title }}</a>
            </div>
        </div>
    </div>

</template>

<script type="text/babel">
    export default {

        props: ['menu-structure', 'starting-subcategory'],

        data() {
            return {
                level: 1,
                selected_subcategory: {id: null, title: '', tool_groups: []}
            };
        },

        computed: {
            formatted_subcat() {
                return {
                    id: this.selected_subcategory.id,
                    title: this.selected_subcategory.title,
                    tool_groups: this.selected_subcategory.children.map(c => c.id)
                }
            }
        },

        mounted() {
            eventHub.$on('reset-category-menu', this.returnToBase);

            if(this.startingSubcategory) {
                const subcategory = this.menuStructure.children.find(s => s.id === this.startingSubcategory);

                this.selected_subcategory = subcategory;

                if (subcategory.children.length) {
                    this.exposeSubmenu(subcategory);
                }
            }
        },

        methods: {
            showSub(subcategory) {
                this.selected_subcategory = subcategory;

                if (subcategory.children.length) {
                    this.exposeSubmenu(subcategory);
                }

                this.$emit('subcategory-selected', this.formatted_subcat);
            },

            clearSelectedSubcategory() {
                this.selected_subcategory = {id: null, title: '', tool_groups: []};
            },

            showToolGroup(toolGroup) {
                this.$emit('toolgroup-selected', {id: toolGroup.id, title: toolGroup.title});
            },

            returnToBase() {
                this.level = 1;
                this.clearSelectedSubcategory();
                this.$emit('reset-category-list');
            },

            resetToSubcategory() {
                this.$emit('hide-menu');
                this.$emit('subcategory-selected', this.formatted_subcat);
            },

            exposeSubmenu(category) {
                this.sub_children = category.children;
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
        min-height: 100vh;
    }

    .mainmenu {
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
        position: absolute;
    }

    .mainmenu.covered {
        background-color: #eeeeee;
    }

    .submenu {
        top: 0;
        bottom: 0;
        overflow-y: auto;
        width: 100%;
        left: 0;
        transition: .5s ease-in-out;
        transform: translate3d(110%, 0, 0);

        &.exposed {
            transform: translate3d(0, 0, 0);
        }
    }
</style>