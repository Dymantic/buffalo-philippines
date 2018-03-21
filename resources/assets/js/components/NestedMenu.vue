<template>
    <div class="relative menu-container w-100">
        <div class="mainmenu w6 pa4 col-w-bg" :class="{'covered': menuType === 'tool_group'}">
            <div v-for="subcategory in subcategories"
                 :key="subcategory.id"
                 @click.stop.prevent="showSub(subcategory)"
                 class="flex justify-between items-center pv2 hv-bg-grey"
            >
                <a :href="subcategory.link"
                   class="link col-d hv-col-p">{{ subcategory.title }}</a>
                <span v-if="subcategory.has_toolgroups" class="strong-type b f4">&raquo;</span>
            </div>
        </div>
        <div class="absolute submenu pa4 w6 col-w-bg"
             :class="{'exposed': menuType === 'tool_group'}">
            <div class="ff-subsub-headline flex items-center mb3">
                <span @click="$emit('reset-category-list')"
                      class="mr4 col-p hv-col-pd b cursor-point">&larr;</span>
                <span @click="showSub(subcategory)" class="hv-col-p cursor-point">{{ subcategory && subcategory.title }}</span>
            </div>
            <div v-for="toolgroup in toolgroups"
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

        props: ['menu-type', 'subcategories', 'toolgroups', 'subcategory'],

        methods: {
            showSub(subcategory) {
                this.$emit('subcategory-selected', {id: subcategory.id});
            },

            showToolGroup(toolGroup) {
                this.$emit('toolgroup-selected', {id: toolGroup.id, title: toolGroup.title});
            },
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