<template>
    <div>
        <CheckboxGroup v-if="lists.length > 0" v-model="defaultValue">
            <Checkbox border v-for="item in lists" :key="item.code" :label="item.code">{{item.name}}</Checkbox>
        </CheckboxGroup>
        <span v-else>没有对应的数据</span>
    </div>
</template>

<script>
    import Emitter from 'view-design/src/mixins/emitter';
    import iJson from '../iJson'

    export default {
        name: "remote-checkbox",
        mixins: [Emitter, iJson],
        props: {
            value: {
                type: [Array],
                default: () => []
            },
            disabled: {
                type: Boolean,
                default: false
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
                    this.$emit('input', value);
                    this.dispatch('FormItem', 'on-form-change', value);
                }
            }
        },
        methods: {
            change(value) {
                this.$emit('on-change', value)
            }
        },
        watch: {
            value(value) {
                this.change(value)
            },
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
