<template>
    <div class="h-100">
        <Table :columns="columns" :data="value" :height="height" ref="table" size="small">
            <template slot-scope="{ row, index }" slot="foreign">
                <RemoteSpan url="common/select/dictionaries/LOG_FOREIGN" v-model="row.foreign"></RemoteSpan>
            </template>
            <template slot-scope="{ row, index }" slot="user">
                {{row.user.name}}
            </template>
        </Table>
    </div>
</template>

<script>
    import RemoteSpan from "./RemoteSpan";
    import ResizeObserver from "resize-observer-polyfill";
    export default {
        name: "ILogs",
        components: {RemoteSpan},
        props: {
            value: {
                type: Array,
                default: () => []
            }
        },
        mounted() {
            this.handleResize()
        },
        data(){
            return {
                height: 200,
                columns: [{
                    title: '序号',
                    width: 80,
                    render: (h, {row, column, index}) => {
                        return h('div', index + 1);
                    },
                    sortable: true
                },{
                    title: '操作系统',
                    slot: 'foreign'
                },{
                    title: '操作人',
                    slot: 'user'
                }, {
                    title: '操作备注',
                    key: 'remark'
                }, {
                    title: '操作时间',
                    key: 'created_at',
                    sortable: true
                }]
            }
        },
        methods:{
            handleResize(){
                const robserver = new ResizeObserver((entries) => {
                    const entry = entries[0];
                    const {height} = entry.contentRect;
                    this.height = height;
                });
                robserver.observe(this.$el);
            }
        }
    }
</script>

<style scoped>

</style>
