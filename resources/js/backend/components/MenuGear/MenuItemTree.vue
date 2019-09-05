<style lang="scss" scoped>
.list-group-children {
    margin-top: 0.75rem;
    margin-bottom: -0.75rem;
    margin-right: -1.25rem;
    margin-left: -0.75rem;

    > .list-group-item {
        border-right: none;

        &:first-child {
            border-top-right-radius: 0;
        }

        &:last-child {
            border-bottom-left-radius: 0;
            border-bottom-right-radius: 0;
            border-bottom: none;
        }
    }
}
</style>

<template>
<div class="list-group" :class="elClass">
    <a v-if="!parent" class="list-group-item list-group-item-action list-group-item-success" href="#" @click.prevent="createOn(parent)"><i class="fas fa-plus"></i></a>
    <div v-for="(item, index) in nodeData" :key="item.id" class="list-group-item list-group-item-action">
        <div class="d-flex w-100 justify-content-between">
            <a href="#" class="text-decoration-none" @click.prevent="show({item, index})">{{ item.name }}</a>
            <div class="item-actions">
                <a v-if="index > 0" href="#" class="text-warning" @click.prevent="swap({item, index, parent, direction: 'up'})"><i class="fas fa-arrow-circle-up"></i></a>
                <a v-if="index < nodeData.length - 1" href="#" class="text-warning" @click.prevent="swap({item, index, parent, direction: 'down'})"><i class="fas fa-arrow-circle-down"></i></a>
                <a href="#" class="text-danger" @click.prevent="remove({item, index, parent})"><i class="fas fa-minus-circle"></i></a>
                <a v-if="depth < maxDepth" href="#" class="text-info" @click.prevent="createOn(item.id)"><i class="fas fa-plus-circle"></i></a>
            </div>
        </div>

        <menu-item-tree
            v-if="item.children.length > 0"
            :node-data="item.children"
            :parent="item.id"
            el-class="list-group-children"
            @show="show"
            @remove="remove"
            @create-on="createOn"
            @swap="swap"
            :max-depth="maxDepth"
            :depth="depth + 1"
        ></menu-item-tree>
    </div>
</div>
</template>

<script>
export default {
    props: {
        elClass: {
            type: [String, Object]
        },

        nodeData: {
            type: Array,
            default() {
                return []
            }
        },

        parent: {
            default() {
                return null
            }
        },

        maxDepth: {
            type: Number,
            default: 1
        },

        depth: {
            type: Number,
            default: 1
        }
    },

    data() {
        return {
            treeData: this.nodeData
        }
    },

    beforeCreate() {
        this.$options.components.MenuItemTree = require('./MenuItemTree.vue').default
    },

    mounted() {

    },

    methods: {
        show(data) {
            this.$emit('show', data);
        },

        remove(data) {
            this.$emit('remove', data);
        },

        createOn(parent) {
            this.$emit('create-on', parent);
        },

        swap(data) {
            this.$emit('swap', data);
        }
    }
}
</script>
