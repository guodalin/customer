<style lang="scss" scoped>
.list-group-item {
    .list-group-item-actions {
        display: none;
        text-align: right;
    }

    &:hover {
        .list-group-item-actions {
            display: block;
        }
    }
}
</style>

<template>
    <div>
        <div class="row" :class="elClass">
            <div class="col-sm-3">
                <div class="text-right">
                    <a href="#modal-create-category" class="btn btn-success btn-sm" data-toggle="modal"><i class="fas fa-plus"></i></a>
                </div>
                <div class="list-group mt-2">
                    <div v-for="category in categories" :key="category.id" class="list-group-item list-group-item-action flex-column align-items-start">
                        <div class="d-flex w-100 justify-content-between">
                            <a href="#" class="text-decoration-none" @click.prevent="choose(category)">{{ category.name }}</a>
                            <small>{{ category.items_count }}</small>
                        </div>
                        <div class="list-group-item-actions">
                            <a href="#" class="text-info" @click.prevent="edit(category)"><i class="fas fa-pen-square"></i></a>
                            <a href="#" class="text-danger" @click.prevent="remove(category)"><i class="fas fa-minus-square"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <category-children v-if="currentCategory" :category="currentCategory" el-class="col-sm-9"></category-children>
        </div>

        <!-- Create Client Modal -->
        <div class="modal fade" id="modal-create-category" tabindex="-1" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">创建栏目</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>

                    <div class="modal-body">
                        <!-- Form Errors -->
                        <div class="alert alert-danger" v-if="Object.keys(createCategoryForm.errors).length > 0">
                            <p class="mb-0"><strong>Whoops!</strong> Something went wrong!</p>
                            <br>
                            <ul>
                                <li v-for="(error, index) in createCategoryForm.errors" :key="index">
                                    {{ error }}
                                </li>
                            </ul>
                        </div>

                        <!-- Create Client Form -->
                        <form role="form">
                            <!-- Name -->
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">分类名称</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" v-model="createCategoryForm.name" required>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Modal Actions -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">关闭</button>
                        <button type="button" class="btn btn-primary" @click="store">创建</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit Menu Modal -->
        <div class="modal fade" id="modal-edit-category" tabindex="-1" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">编辑分类</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>

                    <div class="modal-body">
                        <!-- Form Errors -->
                        <div class="alert alert-danger" v-if="Object.keys(editCategoryForm.errors).length > 0">
                            <p class="mb-0"><strong>Whoops!</strong> Something went wrong!</p>
                            <br>
                            <ul>
                                <li v-for="(error, index) in editCategoryForm.errors" :key="index">
                                    {{ error }}
                                </li>
                            </ul>
                        </div>

                        <!-- Edit Menu Form -->
                        <form role="form">
                            <!-- Name -->
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">分类名称</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" v-model="editCategoryForm.name">
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Modal Actions -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">关闭</button>
                        <button type="button" class="btn btn-primary" @click="update">更新</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import CategoryService from "../services/category-service";
import CategoryChildren from "./CategoryGear/CategoryChildren";

export default {
    props: {
        elClass: {
            type: [String, Object]
        }
    },

    data() {
        return {
            categoryService: null,
            categories: [],
            currentCategory: null,
            createCategoryForm: {
                name: null,
                errors: []
            },
            editCategoryForm: {
                name: null,
                errors: []
            }
        };
    },

    mounted() {
        this.categoryService = new CategoryService();
        this.prepareComponent();
    },

    methods: {
        /**
         * Prepare the component (Vue 2.x).
         */
        prepareComponent() {
            this.getCategories();
        },

        /**
         * Get all of the categories.
         */
        getCategories() {
            this.categoryService.categories().then(data => {
                this.categories = data.data;
            });
        },

        /**
         * remove category
         *
         * @param {Object} category
         */
        remove(category) {
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
                result.value && this.categoryService.remove(category.id).then(data => {
                    toastr.success(data.message);

                    if (this.currentCategory && this.currentCategory.id == category.id) {
                        this.currentCategory = null;
                    }

                    this.getCategories();
                });
            })
        },

        store() {
            this.persistCategory('post', '/admin/category', this.createCategoryForm, '#modal-create-category');
        },

        /**
         * Edit the given category.
         */
        edit(category) {
            this.editCategoryForm.id = category.id;
            this.editCategoryForm.name = category.name;

            $('#modal-edit-category').modal('show');
        },

        update() {
            this.persistCategory('put', '/admin/category/' + this.editCategoryForm.id, this.editCategoryForm, '#modal-edit-category');
        },

        /**
         * Persist the client to storage using the given form.
         */
        persistCategory(method, uri, form, modal) {
            form.errors = [];

            this.categoryService[method](uri, form)
                .then(resp => {
                    this.getCategories();

                    form.name = '';
                    form.errors = [];

                    $(modal).modal('hide');
                })
                .catch(resp => {
                    if (typeof resp.data === 'object') {
                        form.errors = _.flatten(_.toArray(resp.data.errors));
                        toastr.error(resp.data.message);
                    }
                });
        },

        choose(category) {
            this.categoryService.get(`/admin/category/${category.id}`).then(data => {
                this.currentCategory = data.data;
            });
        }
    },

    components: {
        CategoryChildren
    }
}
</script>
