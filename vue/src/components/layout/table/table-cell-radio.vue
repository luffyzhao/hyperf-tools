<template>
    <Radio size="small" :value="value" @click.native.stop="handleStop" @on-change="handleChange"></Radio>
</template>

<script>
export default {
    name: "table-cell-radio",
    props: {
        value: {
            type: Boolean,
            default: false
        }
    },
    methods: {
        handleStop(){

        },
        handleChange(v){
            this.$emit('on-change', v);
        }
    }
}
</script>

<style scoped>

</style>
