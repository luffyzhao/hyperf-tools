<template>
  <IDrawer v-model="defaultValue" :loading="loading" width="350">
    <Form ref="formCreate" :model="data" label-position="top" :rules="ruleValidate">
      <FormItem label="简称" prop="short_name">
        <Input v-model="data.short_name"></Input>
      </FormItem>
      <FormItem label="公司名称" prop="name">
        <Input v-model="data.name"></Input>
      </FormItem>
    </Form>
    <div slot="footer">
      <Button type="primary" icon="ios-add" @click="submit('formCreate')">提交</Button>
      <Button type="warning" icon="md-log-out" @click="defaultValue = false">返回</Button>
    </div>
  </IDrawer>
</template>

<script>
import IDrawerMixins from "@/mixins/iDrawerMixins";
import IDrawer from "@/components/layout/IDrawer";
import IData from "./data";

export default {
  name: "create",
  components: {IDrawer},
  mixins: [IDrawerMixins, IData],
  methods: {
    submit(name){
      this.validate(name).then(() => {
        this.$http.post(`customer/index`, this.data).then(() => {
          this.defaultValue = false;
        });
      });
    }
  }
}
</script>

<style scoped>

</style>
