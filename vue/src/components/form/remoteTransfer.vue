<template>
    <Transfer
            :data="lists"
            :target-keys="defaultValue"
            @on-change="handleChange"></Transfer>
</template>

<script>
    import Emitter from 'view-design/src/mixins/emitter';
    import iJson from '../iJson'

    export default {
        name: "remoteTransfer",
        props: {
            value: {
                type: [Array],
                default: () => []
            }
        },
        mixins: [Emitter, iJson],
        computed: {
            defaultValue: {
                get() {
                    return this.value;
                },
                set(value) {
                    this.$emit('input', value);
                    this.dispatch('FormItem', 'on-form-change', value);
                }
            }
        },
        methods:{
            setData(res) {
                this.lists = this.toTransfer(res);
                this.loading = false;
                this.$cache.set(this.url, res);
            },
            toTransfer(res){
                let data = [];
                res.forEach((item) => {
                    data.push({
                        key: item.code,
                        label: item.name
                    });
                });
                return data;
            },
            handleChange(value){
                this.defaultValue = value;
                this.$emit('on-change', value)
            }
        }
    }
</script>

<style scoped>

</style>
