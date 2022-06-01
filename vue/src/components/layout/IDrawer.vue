<template>
    <Drawer :title="title" v-model="defaultValue" :transfer="false" :mask-closable="false"
            :width="width" draggable>
        <div class="modal-body">
            <slot></slot>
        </div>
        <div class="compon-drawer-footer">
            <slot name="footer"></slot>
        </div>
        <Spin size="large" fix v-if="loading"></Spin>
    </Drawer>
</template>

<script>
    export default {
        name: "iDrawer",
        props: {
            value: {
                type: Boolean,
                default: false
            },
            title: {
                type: String,
                default: '弹窗'
            },
            width: {
                type: [Number, String],
                default: 720
            },
            loading: {
                type: Boolean,
                default: false
            }
        },
        computed: {
            defaultValue: {
                get() {
                    return this.value;
                }, set(status) {
                    this.$emit('input', status)
                }
            }
        }
    }
</script>

<style scoped>
    .modal-body {
        height: calc(100% - 53px);
        overflow-y: auto;
        margin-right: -16px;
        padding-right: 16px;
        display: flex;
        flex-direction: column;
    }

    .compon-drawer-footer {
        border-top: 1px solid #e8e8e8;
        padding: 10px 16px;
        text-align: right;
        background: #fff;
    }

    .compon-drawer-footer * {
        text-align: left;
    }
</style>
