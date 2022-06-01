<template>
    <ITable :current="page.current" :table="table" :total="page.total" @on-page-change="pageChange"
            :loading="loading">
        <template slot-scope="{row}" slot="user">
            {{ row.user.name }}
        </template>
    </ITable>
</template>

<script>
import RemoteSpan from "@/components/layout/RemoteSpan";
import IContentMixins from "@/mixins/iContentMixins"
import ITable from "@/components/layout/ITable";

export default {
    name: 'ILogPaginate',
    components: {
        ITable,
        RemoteSpan
    },
    mixins: [IContentMixins],
    props: {
        props: {
            required: true,
            type: String
        }
    },
    data() {
        return {
            table: {
                columns: [{
                    title: '序号',
                    width: 80,
                    render: (h, {row, column, index}) => {
                        return h('div', index + 1);
                    }
                }, {
                    title: '操作人',
                    slot: 'user',
                    width: 120
                }, {
                    title: '操作备注',
                    key: 'remark'
                }, {
                    title: 'IP地址',
                    key: 'ip',
                    width: 120
                }, {
                    title: '操作时间',
                    key: 'created_at',
                    width: 150
                }]
            }
        }
    },
    methods: {
        getLists(page) {
            this._lists(this.props, page);
        }
    },
    watch:{
        props(){
            this.getLists(1);
        }
    }
}
</script>

<style lang="less">
.distribution-table {
    .modal-body {
        height: calc(100vh - 350px) !important;
    }
}
</style>

