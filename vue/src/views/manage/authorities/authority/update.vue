<template>
  <IDrawer v-model="defaultValue" :loading="loading">
    <Form ref="formCreate" :model="data" label-position="top" :rules="ruleValidate">
      <Row :gutter="10">
        <Col :span="24">
          <FormItem label="权限名称" prop="name">
            <Input v-model="data.name"></Input>
          </FormItem>
        </Col>
        <Col :span="24">
          <FormItem label="请求类型" prop="method">
            <RadioGroup v-model="data.method">
              <Radio label="GET"></Radio>
              <Radio label="POST"></Radio>
              <Radio label="PUT"></Radio>
              <Radio label="DELETE"></Radio>
            </RadioGroup>
          </FormItem>
        </Col>
        <Col :span="24">
          <FormItem label="请求URI" prop="uri">
            <Input v-model="data.uri"></Input>
          </FormItem>
        </Col>
      </Row>
      <FormItem label="请求描述" prop="description">
        <Input v-model="data.description" type="textarea" :rows="3"></Input>
      </FormItem>
      <FormItem label="分配菜单">
        <div class="menu-box">
          <div class="box-body">
            <Tree :data="menus.data" show-checkbox multiple></Tree>
          </div>
        </div>
      </FormItem>
    </Form>
    <div slot="footer">
      <Button type="primary" icon="ios-add" @click="submit('formCreate')">提交</Button>
      <Button type="warning" icon="md-log-out" @click="defaultValue = false">返回</Button>
    </div>
  </IDrawer>
</template>

<script>
import IView from "@/components/layout/IView";
import iDrawerMixins from "@/mixins/iDrawerMixins";
import IData from './data'
import IDrawer from "@/components/layout/IDrawer";

export default {
  name: "update",
  mixins: [iDrawerMixins, IData],
  components: {IDrawer, IView},
  computed: {
    checkedMenus() {
      return this.toChecked(JSON.parse(JSON.stringify(this.menus.data)))
    }
  }, mounted() {
    this.$http.get(`authorities/authority/${this.props.id}/edit`).then((res) => {
      this.data = res.row
      this.menus.data = res.menus
      let data = [];
      JSON.parse(JSON.stringify(this.menus.data)).forEach((item) => {
        data.push({
          id: item.id,
          parent_id: item.parent_id,
          title: item.title,
          expand: true,
          indeterminate: this.indeterminate(item),
          checked: this.checked(item)
        })
      });
      this.menus.data = this.setTreeData(data)
    }).finally(() => {
      this.loading = false
    })
  }, methods: {
    submit(name) {
      this.validate(name).then(() => {
        this.loading = true;
        this.$http.put(`authorities/authority/${this.props.id}`,
            Object.assign({}, this.data, {menus: this.checkedMenus})
        ).then(() => {
          this.$Message.success('修改成功')
          this.defaultValue = false;
        }).finally(() => {
          this.loading = false;
        });
      }).catch(() => {
      });
    }
  }
}
</script>

<style lang="less">
.ivu-steps {
  margin-bottom: 15px;
}

.menu-box {
  border: 1px solid #dcdee2;
  border-radius: 5px;

  .box-body {
    height: 500px;
    margin: 10px;
    overflow: auto;

    .ivu-tree ul li {
      margin: 0;
    }
  }
}

</style>
