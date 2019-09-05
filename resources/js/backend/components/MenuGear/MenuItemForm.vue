<template>
    <form role="form">
        <!-- Form Errors -->
        <div class="alert alert-danger" v-if="Object.keys(errors).length > 0">
            <p class="mb-0"><strong>Whoops!</strong> Something went wrong!</p>
            <br>
            <ul>
                <li v-for="(error, index) in errors" :key="index">
                    {{ error }}
                </li>
            </ul>
        </div>

        <!-- Name -->
        <div class="form-row">
            <div class="col-md-9">
                <input type="text" class="form-control" placeholder="标题" v-model="form.name">
            </div>
            <div class="col-md-3 align-items-center d-flex">
                <div class="custom-control custom-checkbox">
                    <input v-model="form.show" type="checkbox" class="custom-control-input" id="show-in-fore">
                    <label class="custom-control-label" for="show-in-fore">显示</label>
                </div>
            </div>
        </div>

        <!-- URL -->
        <div class="form-row mt-3">
            <div class="col-md-3">
                <select class="form-control" v-model="form.type" required>
                    <option>请选择链接类型</option>
                    <option value="url">URL</option>
                    <option value="raw">无</option>
                    <option value="route">具名路由</option>
                    <option value="action">控制器动作</option>
                    <option value="divide">分割线</option>
                </select>
            </div>
            <div class="col-md-9">
                <input type="text" class="form-control" v-model="form.link" placeholder="输入链接">
                <small class="form-text text-muted">根据链接类型，输入合适的链接</small>
            </div>
        </div>

        <!-- icon -->
        <div class="form-row mt-3">
            <div class="col-md-9">
                <input type="text" class="form-control" placeholder="图标或图像" v-model="form.icon">
            </div>
            <div class="col-md-3 align-items-center d-flex">
                <div class="custom-control custom-checkbox">
                    <input v-model="form.just_icon" type="checkbox" class="custom-control-input" id="just_icon">
                    <label class="custom-control-label" for="just_icon">仅图标</label>
                </div>
            </div>
            <div class="col-md-12">
                <small class="form-text text-muted">比较灵活，具体场景下，可以是图标链接，fontawesome图标等</small>
            </div>
        </div>

        <!-- html -->
        <div class="form-row mt-3">
            <div class="col-md-4">
                <input type="text" class="form-control" placeholder="样式表" v-model="form.html_attributes['class']">
            </div>
            <div class="col-md-4">
                <input type="text" class="form-control" placeholder="行内样式" v-model="form.html_attributes['styles']">
            </div>
            <div class="col-md-4">
                <input type="text" class="form-control" placeholder="高亮激活" v-model="form.active">
            </div>
            <small class="col-md-8 form-text text-muted">目前仅支持`class`</small>
            <small class="col-md-4 form-text text-muted">高亮的URI匹配模式</small>
        </div>

        <!-- meta -->
        <div class="form-row mt-3">
            <div class="col-md-4">
                <input type="text" class="form-control" placeholder="绑定数据" v-model="form.meta['data']">
            </div>
            <div class="col-md-4">
                <input type="text" class="form-control" placeholder="额外1" v-model="form.meta['other1']">
            </div>
            <div class="col-md-4">
                <input type="text" class="form-control" placeholder="额外2" v-model="form.meta['other2']">
            </div>
            <small class="col-md-12 form-text text-muted">目前仅提供录入元数据，暂不支持</small>
        </div>

        <div class="form-group mt-3 text-right">
            <button type="button" class="btn btn-success" @click="save">保存</button>
        </div>
    </form>
</template>

<script>
export default {
    props: {
        form: {
            type: Object,
            required: true
        },

        errors: {
            type: Array,
            default() {
                return [];
            }
        }
    },

    methods: {
        save() {
            this.$emit('save', this.form);
        }
    }
}
</script>
