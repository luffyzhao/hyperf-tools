<template>
    <div class="i-content">
        <div class="transition">
            <slot></slot>
            <template v-if="value.value">
                <IDetail v-if="value.type==='detail'" v-model="value.value">
                    <component  :is="value.view" v-model="value.value"
                                :props="value.props"
                                @input="onChange"></component>
                </IDetail>
                <component v-else :is="value.view" v-model="value.value"
                           :props="value.props"
                           @input="onChange"></component>
            </template>
        </div>
        <Spin size="large" fix v-if="loading"></Spin>
    </div>
</template>

<script>
    import IDetail from "@/components/layout/IDetail";
    export default {
        name: "IContent",
        components: {IDetail},
        props: {
            value: {
                type: Object,
                default: () => {
                    return {
                        value: false
                    }
                }
            },
            loading: {
                type: Boolean,
                default: false
            }
        },
        mounted() {

        },
        methods: {
            onChange(){
                this.$emit('on-change');
            }
        }
    }
</script>

<style scoped>
    .i-content {
        height: 100%;
        position: relative;
    }

    .transition {
        height: 100%;
        display: flex;
        flex-flow: column;
    }
</style>
