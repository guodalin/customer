<script>
export default {
    props: {
        success: {
            type: Boolean,
            default: true
        },

        action: {
            type: String,
            required: true
        },

        elClass: {
            type: [String, Object]
        }
    },

    data() {
        return {
            on: this.success
        };
    },

    methods: {
        toggle() {
            axios.post(this.action).then(resp => {
                this.on = !this.on;
            });
        }
    },

    computed: {

        classes() {
            return this.on ? 'btn-success' : 'btn-danger';
        },

        tips() {
            return this.on ? '点击切换为否' : '点击切换为是'; 
        },

        text() {
            return this.on ? '是' : '否';
        }
    }
}
</script>

<template>
    <div :class="elClass">
        <slot></slot>
        <a href="javascript:;" class="btn btn-sm" 
            :class="classes" 
            :title="tips" 
            @click="toggle"
        >{{ text }}</a> 
    </div>
</template>

