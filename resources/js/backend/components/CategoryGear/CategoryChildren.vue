<style lang="scss" scoped>

</style>

<template>
    <div :class="elClass">
        <div class="row">
            <div class="col-sm-4">
                <category-tree
                    :node-data="category.tree"
                    @show="editForm"
                    @remove="removeItem"
                    @create-on="createForm"
                    @swap="swap"
                    :max-depth="2"
                ></category-tree>
            </div>
            <div class="col-sm-8">
                <!-- Edit Menu Item Form -->
                <category-form
                    v-if="editItemForm"
                    :form="editItemForm"
                    :errors="validatorErrors"
                    @save="update"
                ></category-form>
                <category-form
                    v-else-if="createItemForm"
                    :form="createItemForm"
                    :errors="validatorErrors"
                    @save="store"
                ></category-form>
            </div>
        </div>
    </div>
</template>

<script>
import CategoryTree from './CategoryTree';
import CategoryForm from './CategoryForm';
import CategoryService from '../../services/category-service';

export default {
    props: {
        elClass: {
            type: [String, Object]
        },

        category: {
            type: Object,
            required: true
        }
    },

    data() {
        return {
            categoryService: null,
            validatorErrors: [],
            editItemForm: null,
            editIndex: null,
            createItemForm: null
        }
    },

    mounted() {
        this.categoryService = new CategoryService();
    },

    methods: {
        createForm(parent) {
            this.clean();

            this.createItemForm = {
                category_id: this.category.id,
                parent_id: parent || this.category.id,
                name: ''
            };
        },

        editForm(data) {
            this.clean();

            this.editItemForm = data.item;
            this.editIndex = data.index;
        },

        store(form) {
            this.validatorErrors = [];

            this.categoryService.post(`/admin/category`, form)
                .then(data => {
                    toastr.success(data.message);
                    this.clean();

                    this.findAndAddToTree(data.data, form.parent_id);

                    this.$emit('storeCategoryChildren', this.category);
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

            this.categoryService.put(`/admin/category/${form.id}`, form)
                .then(data => {
                    toastr.success(data.message);
                    this.clean();
                    this.$emit('updateCategoryChildren', this.category);
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
                result.value && this.categoryService.delete(`/admin/category/${data.item.id}`).then(resp => {
                    toastr.success(resp.message);
                    this.findAndRemoveFromTree(data.index, data.parent);
                });
            })
        },

        findAndRemoveFromTree(index, parent) {
            if (!parent) { // top
                this.$delete(this.category.tree, index);
            } else { // 仅支持2层 TODO: 递归
                this.$delete(this.category.tree.find(t => t.id == parent).children, index);
            }

            // 如果索引一致, 清空表单
            if (index == this.editIndex) {
                this.clean();
            }
        },

        findAndSwapFromTree(index, parent, direction) {
            let tree = parent ? this.category.tree.find(t => t.id == parent).children : this.category.tree;

            if (direction == 'up') {
                tree.splice(index - 1, 2, tree[index], tree[index - 1]);
            } else {
                tree.splice(index, 2, tree[index + 1], tree[index]);
            }
        },

        findAndAddToTree(item, parent) {
            if (parent == this.category.id) {
                this.category.tree.push(item);
            } else {
                this.category.tree.find(t => t.id == parent).children.push(item);
            }
        },

        clean() {
            this.editItemForm = null;
            this.createItemForm = null;
            this.validatorErrors = [];
        },

        swap(data) {
            this.categoryService.put(`/admin/category/${data.item.id}/swap/${data.direction}`).then(resp => {
                this.findAndSwapFromTree(data.index, data.parent, data.direction);
            });
        }
    },

    components: {
        CategoryTree,
        CategoryForm
    }
}
</script>
