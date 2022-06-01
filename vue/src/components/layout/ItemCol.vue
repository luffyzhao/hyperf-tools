<template>
    <Col :span="span" class="item-col item-col-has-title" >
        <span class="item-col-title">{{title}}:</span>
        <div class="item-col-desc" ref="desc">
            <slot></slot>
        </div>
    </Col>
</template>

<script>
    export default {
        name: "ItemCol",
        props: {
            span: {
                type: Number,
                required: true
            },
            title: {
                type: String,
                required: true
            }
        }
    }
</script>

<style scoped>
    .item-col-has-title{
        padding-left: 100px;
    }
    .item-col {
        position: relative;
        min-height: 30px;
        line-height: 30px;
    }

    .item-col-title {
        position: absolute;
        display: block;
        text-align: right;
        width: 100px;
        left: 0;
        top: 0;
        padding-right: 10px;
    }

</style>
