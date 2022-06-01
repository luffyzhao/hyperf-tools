<template>
  <IContent v-model="componentProps" @on-change="getLists">

    <ISearch v-model="search">
      <FormItem label="简称名称">
        <Input v-model="search.name" placeholder="简称名称" size="small"></Input>
      </FormItem>
      <FormItem :label-width="1">
        <ButtonGroup>
          <Button type="primary" icon="ios-search" size="small" @click="getLists">搜索</Button>
          <Button type="success" icon="ios-add" size="small" @click="openComponent(ICreate)">添加</Button>
        </ButtonGroup>
      </FormItem>
    </ISearch>
    <ITable :current="page.current" :table="table" :total="page.total" @on-page-change="pageChange" :loading="loading"
            show-radio ref="table">
    </ITable>
  </IContent>
</template>

<script>
import IContent from "@/components/layout/IContent";
import ISearch from "@/components/layout/ISearch";
import ITable from "@/components/layout/ITable";
import IContentMixins from "@/mixins/iContentMixins"
import IOperate from "@/components/layout/IOperate";

export default {
  components: {
    IOperate,
    ITable, ISearch, IContent
  },
  mixins: [IContentMixins],
  data() {
    return {
      ICreate: () => import('./create'),
      IUpdate: () => import('./update'),
      search: {},
      table: {
        columns: [
          {
            title: '客户代码',
            key: 'code'
          },
          {
            title: '简称',
            key: 'short_name'
          },
          {
            title: '客户名称',
            key: 'name'
          }
        ]
      }
    }
  },
  methods:{
    getLists(page = 1){
      this.loading = true;
      this._lists(`customer/index`, page);
    }
  }
}
</script>

<style>
</style>
