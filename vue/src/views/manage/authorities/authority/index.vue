<template>
  <IContent v-model="componentProps" @on-change="getLists">

    <ISearch v-model="search">
      <FormItem label="权限名称">
        <Input v-model="search.name" placeholder="权限名称" size="small"></Input>
      </FormItem>
      <FormItem label="请求URI">
        <Input v-model="search.uri" placeholder="URI" size="small"></Input>
      </FormItem>
      <FormItem :label-width="1">
        <ButtonGroup>
          <Button type="primary" icon="ios-search" size="small" @click="getLists(1)">搜索</Button>
          <Button type="success" icon="ios-add" size="small" @click="openComponent(ICreate)">添加</Button>
        </ButtonGroup>
      </FormItem>
    </ISearch>

    <IOperate>
      <Button type="warning" size="small" @click="openComponentSelection(IUpdate, `table`)">
        编辑
      </Button>
      <Button type="error" size="small" @click="submitForRemove(`table`)">删除</Button>
    </IOperate>

    <ITable :current="page.current" :table="table" :total="page.total" @on-page-change="pageChange" :loading="loading"
            show-radio ref="table">
      <template slot-scope="{ row, index }" slot="name">
        <span>{{ row.name }}</span>
      </template>
      <template slot-scope="{ row, index }" slot="uri">
        <span>{{ row.uri }}</span>
      </template>
      <template slot-scope="{ row, index }" slot="description">
        <span>{{ row.description }}</span>
      </template>
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
      table: {
        columns: [
          {
            title: '权限名称',
            slot: 'name'
          },
          {
            title: 'URI',
            slot: 'uri'
          },
          {
            title: '请求类型',
            key: 'method'
          },
          {
            title: '请求描述',
            slot: 'description'
          }
        ]
      },
      search: {}
    }
  },
  methods: {
    getLists(page = 1) {
      this.loading = true;
      this._lists(`authorities/authority`, page);
    },
    submitForRemove(table) {
      this._selectionOne(table).then((row) => {
        this._confirm().then(() => {
          this.loading = true;
          this.$http.delete(`authorities/authority/${row.id}`)
              .then(() => {
                this.getLists(this.page.current)
              });
        });
      });
    }
  }
}
</script>

<style>
</style>
