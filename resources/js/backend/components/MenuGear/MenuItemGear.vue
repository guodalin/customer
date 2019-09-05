<style lang="scss" scoped>

</style>

<template>
    <div :class="elClass">
        <div class="row">
            <div class="col-sm-4">
                <menu-item-tree
                    :node-data="menu.tree"
                    @show="editForm"
                    @remove="removeItem"
                    @create-on="createForm"
                    @swap="swap"
                    :max-depth="2"
                ></menu-item-tree>
            </div>
            <div class="col-sm-8">
                <!-- Edit Menu Item Form -->
                <menu-item-form
                    v-if="editItemForm"
                    :form="editItemForm"
                    :errors="validatorErrors"
                    @save="update"
                ></menu-item-form>
                <menu-item-form
                    v-else-if="createItemForm"
                    :form="createItemForm"
                    :errors="validatorErrors"
                    @save="store"
                ></menu-item-form>
            </div>
        </div>
    </div>
</template>

<script>
import MenuItemTree from './MenuItemTree';
import MenuItemForm from './MenuItemForm';
import MenuService from '../../services/menu-service';

export default {
    props: {
        elClass: {
            type: [String, Object]
        },

        menu: {
            type: Object,
            required: true
        }
    },

    data() {
        return {
            menuService: null,
            validatorErrors: [],
            editItemForm: null,
            editIndex: null,
            createItemForm: null
        }
    },

    mounted() {
        this.menuService = new MenuService();
    },

    methods: {
        createForm(parent) {
            this.clean();

            this.createItemForm = {
                menu_id: this.menu.id,
                parent_id: parent,
                name: '',
                icon: '',
                just_icon: false,
                show: true,
                html_attributes: {
                    class: '',
                    styles: ''
                },
                meta: {
                    data: '',
                    other1: '',
                    other2: ''
                },
                type: 'url',
                link: '',
                active: ''
            };
        },

        editForm(data) {
            this.clean();
            if (!Object.keys(data.item.html_attributes).length) {
                data.item.html_attributes = {
                    class: '',
                    styles: ''
                };
            }

            if (!Object.keys(data.item.meta).length) {
                data.item.meta = {
                    data: '',
                    other1: '',
                    other2: ''
                };
            }

            this.editItemForm = data.item;
            this.editIndex = data.index;
        },

        store(form) {
            this.validatorErrors = [];

            this.menuService.post(`/admin/menu/item`, form)
                .then(data => {
                    toastr.success(data.message);
                    this.clean();

                    this.findAndAddToTree(data.data, form.parent_id);

                    this.$emit('storeMenuItems', this.menu);
                }).catch(resp => {
                    if (typeof resp.data === 'object') {
                        this.validatorErrors = _.flatten(_.toArray(resp.data.errors));
                        toastr.error(resp.data.message);
                    } else {
                        console.log(resp);
                    }
                });
        },

        update(form) {
            this.validatorErrors = [];

            this.menuService.put(`/admin/menu/item/${form.id}`, form)
                .then(data => {
                    toastr.success(data.message);
                    this.clean();
                    this.$emit('updateMenuItems', this.menu);
                }).catch(resp => {
                    if (typeof resp.data === 'object') {
                        this.validatorErrors = _.flatten(_.toArray(resp.data.errors));
                        toastr.error(resp.data.message);
                    } else {
                        console.log(resp);
                    }
                });
        },

        removeItem(data) {
            Swal.fire({
                title: '确定删除吗？',
                text: '你将无法恢复它！',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: '确定删除！',
                cancelButtonText: '我再想想',
            }).then((result) => {
                result.value && this.menuService.delete(`/admin/menu/item/${data.item.id}`).then(resp => {
                    toastr.success(resp.message);
                    this.findAndRemoveFromTree(data.index, data.parent);
                });
            })
        },

        findAndRemoveFromTree(index, parent) {
            if (!parent) { // top
                this.$delete(this.menu.tree, index);
            } else { // 仅支持2层 TODO: 递归
                this.$delete(this.menu.tree.find(t => t.id == parent).children, index);
            }

            // 如果索引一致, 清空表单
            if (index == this.editIndex) {
                this.clean();
            }
        },

        findAndSwapFromTree(index, parent, direction) {
            let tree = parent ? this.menu.tree.find(t => t.id == parent).children : this.menu.tree;

            if (direction == 'up') {
                tree.splice(index - 1, 2, tree[index], tree[index - 1]);
            } else {
                tree.splice(index, 2, tree[index + 1], tree[index]);
            }
        },

        findAndAddToTree(item, parent) {
            if (!parent) {
                this.menu.tree.push(item);
            } else {
                this.menu.tree.find(t => t.id == parent).children.push(item);
            }
        },

        clean() {
            this.editItemForm = null;
            this.createItemForm = null;
            this.validatorErrors = [];
        },

        swap(data) {
            this.menuService.put(`/admin/menu/item/${data.item.id}/swap/${data.direction}`).then(resp => {
                this.findAndSwapFromTree(data.index, data.parent, data.direction);
            });
        }
    },

    components: {
        MenuItemTree,
        MenuItemForm
    }
}
</script>
