<template>
  <IContent v-model="componentProps" @on-change="getLists">

    <ISearch v-model="search">
      <FormItem label="部门名称">
        <Input v-model="search.name" placeholder="部门名称" size="small"></Input>
      </FormItem>
      <FormItem :label-width="1">
        <ButtonGroup>
          <Button type="primary" icon="ios-search" size="small" @click="getLists(1)">搜索</Button>
          <Button type="success" icon="ios-add" size="small" @click="openComponent(ICreate)">添加</Button>
        </ButtonGroup>
      </FormItem>
    </ISearch>

    <IOperate>
      <Button type="warning" size="small" @click="openComponentSelection(IUpdate, `table`)">编辑</Button>
      <Button type="error" size="small" @click="submitForRemove(`table`)">删除</Button>
    </IOperate>

    <ITable :current="page.current" :table="table" :total="page.total" @on-page-change="pageChange" :loading="loading"
            show-radio ref="table">

      <template slot-scope="{ row, index }" slot="name">
        <span>{{ row.name }}</span>
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
            title: '部门',
            slot: 'name'
          },
          {
            title: '部门描述',
            slot: 'description'
          }
        ]
      },
      search: {},
      loading: false
    }
  },
  methods: {
    getLists(page = 1) {
      this.loading = true;
      this.$http.get(`authorities/role`, {
        params: Object.assign({}, this.search, {page: page})
      }).then((data) => {
        this.table.data = data.data
        this.page.total = data.total
        this.page.current = data.current_page
      }).finally(() => {
        this.loading = false;
      });
    },
    submitForRemove(data) {
      this._selectionOne(data).then((row) => {
        this._confirm().then(() => {
          this.loading = true;
          this.$http.delete(`authorities/role/${row.id}`)
              .then(() => {
                this.getLists(this.page.current)
              }).finally(() => {
            this.loading = false;
          });
        });
      });
    }
  }
}
</script>

<style>
</style>
