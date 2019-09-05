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
                    <a href="#modal-create-menu" class="btn btn-success btn-sm" data-toggle="modal"><i class="fas fa-plus"></i></a>
                </div>
                <div class="list-group mt-2">
                    <div v-for="menu in menus" :key="menu.id" class="list-group-item list-group-item-action flex-column align-items-start">
                        <div class="d-flex w-100 justify-content-between">
                            <a href="#" class="text-decoration-none" @click.prevent="choose(menu)">{{ menu.name }}</a>
                            <small>{{ menu.items_count }}</small>
                        </div>
                        <div class="list-group-item-actions">
                            <a href="#" class="text-info" @click.prevent="edit(menu)"><i class="fas fa-pen-square"></i></a>
                            <a href="#" class="text-danger" @click.prevent="remove(menu)"><i class="fas fa-minus-square"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <menu-item-gear v-if="currentMenu" :menu="currentMenu" el-class="col-sm-9"></menu-item-gear>
        </div>

        <!-- Create Client Modal -->
        <div class="modal fade" id="modal-create-menu" tabindex="-1" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">创建菜单</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>

                    <div class="modal-body">
                        <!-- Form Errors -->
                        <div class="alert alert-danger" v-if="Object.keys(createMenuForm.errors).length > 0">
                            <p class="mb-0"><strong>Whoops!</strong> Something went wrong!</p>
                            <br>
                            <ul>
                                <li v-for="(error, index) in createMenuForm.errors" :key="index">
                                    {{ error }}
                                </li>
                            </ul>
                        </div>

                        <!-- Create Client Form -->
                        <form role="form">
                            <!-- Name -->
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">菜单名称</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" v-model="createMenuForm.name">
                                </div>
                            </div>

                            <!-- Slug -->
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">标识</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" v-model="createMenuForm.nickname">
                                    <small class="form-text text-muted">
                                        菜单的唯一识别码，程序用. 最好使用A-Za-z-0-9
                                    </small>
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
        <div class="modal fade" id="modal-edit-menu" tabindex="-1" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">编辑菜单</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>

                    <div class="modal-body">
                        <!-- Form Errors -->
                        <div class="alert alert-danger" v-if="Object.keys(editMenuForm.errors).length > 0">
                            <p class="mb-0"><strong>Whoops!</strong> Something went wrong!</p>
                            <br>
                            <ul>
                                <li v-for="(error, index) in editMenuForm.errors" :key="index">
                                    {{ error }}
                                </li>
                            </ul>
                        </div>

                        <!-- Edit Menu Form -->
                        <form role="form">
                            <!-- Name -->
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">菜单名称</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" v-model="editMenuForm.name">
                                </div>
                            </div>

                            <!-- Slug -->
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">标识</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" v-model="editMenuForm.nickname">
                                    <small class="form-text text-muted">
                                        菜单的唯一识别码，程序用. 最好使用A-Za-z-0-9
                                    </small>
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
import MenuService from "../services/menu-service";
import MenuItemGear from "./MenuGear/MenuItemGear";

export default {
    props: {
        elClass: {
            type: [String, Object]
        }
    },

    /*
        * The component's data.
        */
    data() {
        return {
            menuService: null,
            menus: [],
            currentMenu: null,
            createMenuForm: {
                name: null,
                nickname: null,
                errors: []
            },
            editMenuForm: {
                name: null,
                nickname: null,
                errors: []
            }
        };
    },

    /**
     * Prepare the component (Vue 2.x).
     */
    mounted() {
        this.menuService = new MenuService();

        this.prepareComponent();
    },

    methods: {
        /**
         * Prepare the component (Vue 2.x).
         */
        prepareComponent() {
            this.getMenus();
        },

        /**
         * Get all of the menus.
         */
        getMenus() {
            this.menuService.menus().then(data => {
                this.menus = data.data;
            })
        },

        /**
         * remove menu
         *
         * @param {Object} menu
         */
        remove(menu) {
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
                result.value && this.menuService.remove(menu.id).then(data => {
                    toastr.success(data.message);

                    if (this.currentMenu && this.currentMenu.id == menu.id) {
                        this.currentMenu = null;
                    }

                    this.getMenus();
                });
            })
        },

        store() {
            this.persistMenu('post', '/admin/menu', this.createMenuForm, '#modal-create-menu');
        },

        /**
         * Edit the given menu.
         */
        edit(menu) {
            this.editMenuForm.id = menu.id;
            this.editMenuForm.name = menu.name;
            this.editMenuForm.nickname = menu.nickname;

            $('#modal-edit-menu').modal('show');
        },

        update() {
            this.persistMenu('put', '/admin/menu/' + this.editMenuForm.id, this.editMenuForm, '#modal-edit-menu');
        },

        /**
         * Persist the client to storage using the given form.
         */
        persistMenu(method, uri, form, modal) {
            form.errors = [];

            this.menuService[method](uri, form)
                .then(resp => {
                    this.getMenus();

                    form.name = '';
                    form.nickname = '';
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

        choose(menu) {
            this.menuService.get(`/admin/menu/${menu.id}`).then(data => {
                this.currentMenu = data.data;
            });
        }
    },

    components: {
        MenuItemGear
    }
}
</script>
