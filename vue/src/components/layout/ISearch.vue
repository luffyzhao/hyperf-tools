<template>
    <div class="i-search">
        <Form ref="formSearch" :model="value" inline :label-width="80">
            <slot></slot>
        </Form>
    </div>
</template>

<script>
    export default {
        name: "ISearch",
        props: {
            value: {
                type: Object
            }
        }
    }
</script>

<style scoped>
    .i-search {
        padding: 5px;
        /*border-bottom: #e8eaec 1px solid;*/
    }
</style>
<style lang="less">
    .search-panel {
        background-color: #fff;
        .ivu-form-item{
            margin-bottom: 0px;
        }
        .ivu-cascader{
            display: inline-block;
        }
    }
</style>
