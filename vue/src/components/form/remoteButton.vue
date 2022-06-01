<template>
    <div>
        <ButtonGroup v-if="lists.length > 0">
            <Button :size="size" @click="change(``)"
                    :type="defaultValue === ``?`primary`:`default`">全部</Button>
            <Button :size="size" v-for="item in lists" :key="item.code" @click="change(item.code)"
                    :type="defaultValue === item.code?`primary`:`default`">
                {{item.name}}
            </Button>
        </ButtonGroup>
        <span v-else>加载中..</span>
    </div>
</template>

<script>
    import Emitter from 'view-design/src/mixins/emitter';
    import iJson from '../iJson'

    export default {
        name: "remote-button",
        mixins: [Emitter, iJson],
        props: {
            value: {
                type: [Number, String],
                default: ''
            },
            size: {
                type: String,
                default: 'default'
            }
        },
        data() {
            return {
                loading: true
            }
        },
        computed: {
            defaultValue: {
                get() {
                    return this.value;
                },
                set(value) {
                    this.change(value)
                }
            }
        },
        methods: {
            change(value) {
                this.$emit('input', value);
                this.dispatch('FormItem', 'on-form-change', value);
                this.$emit('on-change');
            }
        },
        watch: {
            loading(val) {
                if (val === false) {
                    this.$emit('on-ready')
                }
            }
        }
    }
</script>

<style scoped>

</style>
