<template>
    <div class="i-operate">
        <slot></slot>
    </div>
</template>

<script>
export default {
    name: "IOperate"
}
</script>

<style lang="less">
.i-operate{
    padding: 5px;
    &>button{
        margin-right: 2px;
    }
}
</style>
