<template>
  <div class="veu-create">
    <div class="header">
      <Spin v-if="loading" fix></Spin>
      <Form ref="formCreate" :model="data" label-position="top" :rules="ruleValidate">
        <Row :gutter="10">
          <Col span="12">
            <FormItem label="上级菜单">
              <Input :value="props.title" disabled></Input>
            </FormItem>
          </Col>
          <Col span="12">
            <FormItem label="菜单标题" prop="title">
              <Input v-model="data.title"></Input>
            </FormItem>
          </Col>
          <Col span="12">
            <FormItem label="菜单名称" prop="name">
              <Input v-model="data.name"></Input>
            </FormItem>
          </Col>
          <Col span="12">
            <FormItem label="菜单图标" prop="icon">
              <Input v-model="data.icon"></Input>
            </FormItem>
          </Col>
        </Row>
        <FormItem label="排序" prop="sort">
          <Input v-model="data.sort" number></Input>
        </FormItem>
        <FormItem label="菜单描述" prop="description">
          <Input v-model="data.description" type="textarea" :rows="4"></Input>
        </FormItem>
        <FormItem label="分配权限">
          <Transfer
              :titles="['可分配权限', '已有权限']"
              :list-style="{width: '300px',height: '500px'}"
              :data="authorities.data"
              :target-keys="data.authorities"
              @on-change="handleChange"></Transfer>
        </FormItem>
      </Form>
    </div>
    <div class="footer">
      <Button type="primary" icon="ios-add" @click="submit('formCreate')">提交</Button>
    </div>
  </div>
</template>

<script>

import iContentMixins from "@/mixins/iContentMixins";
import Menu from './menu';

export default {
  name: "create",
  mixins: [iContentMixins, Menu],
  mounted() {
    this.loading = true;
    this.$http.get(`authorities/menu/create`).then((res) => {
      this.authorities.data = res
    }).finally(() => {
      this.loading = false
    });
  },
  methods: {
    submit(name) {
      this.validate(name).then(() => {
        this.loading = true;
        this.data.parent_id = this.props.id;
        this.$http.post(`authorities/menu`, this.data).then(() => {
          this.$Message.success('添加成功')
        }).finally(() => {
          this.loading = false;
          this.$emit('on-refresh');
        });
      }).catch(() => {

      });
    }
  }
}
</script>

<style scoped lang="less">
.veu-create {
  height: 100%;

  position: relative;

  .header {
    height: calc(100% - 40px);
    overflow-y: scroll;
    padding: 0 5px;
    border-bottom: 1px solid #e8eaec;
  }

  .footer {
    text-align: right;
    height: 50px;
    padding: 15px 15px 0 0;
  }
}

</style>
