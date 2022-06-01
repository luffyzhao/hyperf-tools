<template>
    <Modal v-model="defaultValue" :transfer="transfer" :footer-hide="footerHide" :mask-closable="false"
            :width="width">
        <p slot="header" style="color:#f60;text-align:center">
            <slot name="title"><span>{{title}}</span></slot>
        </p>
        <div class="modal-body">
            <slot></slot>
        </div>
        <div slot="footer" v-if="!footerHide">
            <slot name="footer"></slot>
        </div>
        <Spin size="large" fix v-if="loading"></Spin>
    </Modal>
</template>

<script>
    export default {
        name: "iModal",
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
            },
            footerHide: {
                type: Boolean,
                default: false
            },
            transfer: {
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
        max-height: calc(100vh - 350px);
        overflow-y: auto;
        margin-right: -16px;
        padding-right: 16px;
        display: flex;
        flex-direction: column;
    }
    .compon-drawer-footer{
        border-top: 1px solid #e8e8e8;
        padding: 10px 16px;
        text-align: right;
        background: #fff;
    }
    .compon-drawer-footer *{
        text-align: right;
    }
</style>
