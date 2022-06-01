<template>
    <IContent v-model="componentProps" @on-change="getLists">
        <ISearch v-model="search">
            <FormItem label="代码">
                <Input v-model="search.code" placeholder="代码" size="small"></Input>
            </FormItem>
            <FormItem :label-width="1">
                <ButtonGroup>
                    <Button type="primary" icon="ios-search" size="small" @click="getLists(1)">搜索</Button>
                    <Button type="success" icon="ios-add" size="small" @click="openComponent(ICreate)">添加</Button>
                </ButtonGroup>
            </FormItem>
        </ISearch>

        <ITable :current="page.current" :table="table" :total="page.total" @on-page-change="pageChange" :loading="loading">
            <template slot-scope="{ row, index }" slot="action">
                <Button type="warning" size="small"
                        @click="openComponent(IUpdate, {code: row.code})">编辑
                </Button>
            </template>
        </ITable>

        <component slot="component" v-if="componentProps.value" :is="componentProps.view" v-model="componentProps.value"
                   :props="componentProps.props"
                   @input="getLists(page.current)"></component>
    </IContent>
</template>

<script>
    import IContent from "@/components/layout/IContent";
    import ISearch from "@/components/layout/ISearch";
    import ITable from "@/components/layout/ITable";
    import IContentMixins from "@/mixins/iContentMixins"

    export default {
        components: {

            ITable, ISearch, IContent
        },
        mixins: [IContentMixins],
        data() {
            return {
                ICreate: () => import('./create'),
                IUpdate: () => import('./update'),
                table: {
                    columns: [
                        {
                            title: '代码',
                            key: 'code'
                        },
                        {
                            title: '名称',
                            key: 'name'
                        },
                        {
                            title: '操作',
                            slot: 'action'
                        }
                    ]
                },
                search: {}
            }
        },
        methods: {
            getLists(page) {
                this._lists(`system/dictionary`, page);
            }
        }
    }
</script>

<style>
</style>
