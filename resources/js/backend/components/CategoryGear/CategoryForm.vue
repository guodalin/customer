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
            <div class="col-md-12">
                <input type="text" class="form-control" placeholder="名称" v-model="form.name" required>
            </div>
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
