<template>
  <IContent v-model="componentProps" @on-change="getLists">

    <ISearch v-model="search">
      <FormItem label="姓名">
        <Input v-model="search.name" placeholder="姓名" size="small"></Input>
      </FormItem>
      <FormItem :label-width="1">
        <ButtonGroup>
          <Button type="primary" icon="ios-search" size="small" @click="getLists(1)">搜索</Button>
          <Button type="success" icon="ios-add" size="small" @click="openComponent(ICreate)">添加</Button>
        </ButtonGroup>
      </FormItem>
    </ISearch>


    <IOperate>
      <Button size="small" type="info" icon="md-construct"
              @click="submitForUpdate(`table`)">修改
      </Button>
      <Button type="error" size="small" @click="submitForStatus(`table`)">更新状态</Button>
      <Button type="warning" size="small" @click="submitForPassword(`table`)">重置密码</Button>
    </IOperate>

    <ITable :current="page.current" :table="table" :total="page.total" @on-page-change="pageChange"
            :loading="loading"
            show-radio ref="table">
      <template slot-scope="{ row, index }" slot="role">
        <span v-if="Boolean(row.role)">{{ row.role.name }}</span>
        <span v-else>超级管理员</span>
      </template>
      <template slot-scope="{ row, index }" slot="status">
        {{ row.status === 0 ? '关闭' : '开启' }}
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
      search: {},
      table: {
        columns: [
          {
            title: '姓名',
            key: 'name'
          },
          {
            title: '邮箱',
            key: 'email'
          },
          {
            title: '所属部门',
            slot: 'role'
          },
          {
            title: '状态',
            slot: 'status'
          }
        ]
      },
      loading: true
    }
  },
  methods: {
    getLists(page = 1) {
      this.loading = true;
      this.$http.get(`authorities/user`, {
        params: Object.assign({}, this.search, {page: page})
      }).then((data) => {
        this.table.data = data.data
        this.page.total = data.total
        this.page.current = data.current_page
      }).finally(() => {
        this.loading = false;
      });
    },
    submitForUpdate(table){
      this._selectionOne(table).then((row) => {
        if (!Boolean(row.role_id)) {
          this.$Message.error(`超级管理员不能修改~！`)
        } else {
          this.openComponentSelection(this.IUpdate, table);
        }
      });
    },
    submitForPassword(table){
      this._selectionOne(table).then((row) => {
        this.loading = true;
        this.$http.put(`authorities/user/${row.id}/password`)
            .then(() => {
              this.getLists(this.page.current)
            }).finally(() => {
          this.loading = false;
        });
      });
    },
    submitForStatus(data) {
      this._selectionOne(data).then((row) => {
        if (!Boolean(row.role_id)) {
          this.$Message.error(`超级管理员不能修改~！`)
        } else {
          this.loading = true;
          this.$http.put(`authorities/user/${row.id}/status`, {status: row.status === 1 ? 0 : 1})
              .then(() => {
                this.getLists(this.page.current)
              }).finally(() => {
            this.loading = false;
          });
        }
      })

    }
  }
}
</script>

<style>
</style>
