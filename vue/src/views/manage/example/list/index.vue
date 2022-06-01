<template>
  <IContent v-model="componentProps" @on-change="getLists">

    <ISearch v-model="search">
      <FormItem label="姓名">
        <Input v-model="search.name" placeholder="姓名" size="small"></Input>
      </FormItem>
      <FormItem :label-width="1">
        <ButtonGroup>
          <Button type="primary" icon="ios-search" size="small">搜索</Button>
          <Button type="success" icon="ios-add" size="small" @click="openComponent(ICreate)">添加</Button>
        </ButtonGroup>
      </FormItem>
    </ISearch>

    <ITable :current="page.current" :table="table" :total="page.total" @on-page-change="pageChange" :loading="loading"
            show-radio @on-current-change="currentChange" ref="table">
    </ITable>
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
      search: {}
    }
  }
}
</script>

<style>
</style>
