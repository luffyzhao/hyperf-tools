<template>
    <div class="i-view" v-if="value">
        <div class="i-view-scroll">
            <div class="header">
                <slot name="header"></slot>
            </div>

            <Row :gutter="40" class="body">
                <Col span="6">
                    <slot name="left"></slot>
                </Col>
                <Col span="18" class="right">
                    <slot></slot>
                </Col>
            </Row>

        </div>
        <slot name="footer">
            <div class="i-view-footer">
                <ButtonGroup>
                    <Button class="i-view-exit" @click="exit" type="error">返回</Button>
                </ButtonGroup>
            </div>
        </slot>
        <Spin fix v-if="loading"></Spin>
    </div>
</template>

<script>
    export default {
        name: "IIView",
        props: {
            value: {
                type: Boolean
            },
            loading: {
                type: Boolean,
                default: false
            }
        },
        methods: {
            exit() {
                this.$emit('input', false);
            }
        }
    }
</script>

<style scoped>
    .i-view {
        height: 100%;
        position: relative;
    }

    .i-view .i-view-scroll {
        height: calc(100% - 40px);
        overflow-y: auto;
        padding-right: 24px;
    }

    .i-view .i-view-footer {
        height: 40px;
        line-height: 40px;
        padding-right: 24px;
        text-align: right;
    }

    .header {
        margin-bottom: 15px;
    }

    .body {
        height: calc(100% - 96px);
    }

    .body .right {
        height: 100%;
    }

    .body .right > div {
        height: 100%;
    }
</style>
