<template>
    <Modal v-model="defaultValue" :transfer="false" :mask-closable="false" :width="690">
        <p slot="header" style="color:#f60;text-align:center">
            <slot name="title">回执</slot>
        </p>
        <Table :columns="columns"  size="small" :data="data" ref="Table" :height="400" :stripe="true">
        </Table>
    </Modal>
</template>

<script>
    export default {
        name: "IReturnModal",
        props: {
            value: {
                type: Boolean,
                default: false
            },
            data: {
                type: Array,
                default: () => []
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
        },
        data(){
            return {
                columns:[{
                    title: '海关时间',
                    key: 'last_time',
                    width: 200
                },{
                    title: '说明',
                    key: 'info',
                    width: 250,
                    tooltip: true
                },{
                    title: '入库时间',
                    key: 'created_at',
                    width: 200
                },]
            }
        }
    }
</script>

<style scoped>

</style>
