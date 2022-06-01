<template>
  <IModal v-model="defaultValue" :width="650" :loading="loading">
    <Form :model="data" :rules="ruleValidate" ref="formCreate" label-position="top">
      <FormItem label="模板文件" prop="file">
        <UploadFile v-model="data.file" url="common/upload"></UploadFile>
      </FormItem>
    </Form>

    <div class="error-box" v-if="error.length > 0">
      <Table :columns="columns" :data="error" border></Table>
    </div>


    <div slot="footer">
      <Button type="primary" icon="ios-add" @click="submit('formCreate')">提交</Button>
      <Button type="warning" icon="md-log-out" @click="defaultValue = false">返回</Button>
    </div>
  </IModal>
</template>

<script>
import IModal from "../../layout/IModal";
import IDrawerMixins from "../../../mixins/iDrawerMixins";
import UploadFile from '../uploadFile'

export default {
  name: "ProductImport",
  components: {IModal, UploadFile},
  mixins: [IDrawerMixins],
  data() {
    return {
      columns: [{
        key: 'sku',
        title: '商品货号'
      }, {
        key: 'quantity',
        title: '数量'
      }, {
        key: 'error',
        error: '错误原因',
      }],
      error: [],
      ruleValidate: {
        file: [{required: true, message: '文件必须上传'}]
      },
      data: {
        customer_id: this.props.customer_id
      }
    }
  },
  methods: {
    submit(name) {
      this.validate(name).then(() => {
        this.loading = true;
        this.error = [];
        this.$http.post(`product/index/template`, this.data).then((res) => {
          res = res || [];
          let error = res.filter((v) => v.error !== null);
          if (error.length === 0) {
            res.forEach((v) => {
              this.$emit('on-product-import-choose', v);
            });
            this.defaultValue = false;
          } else {
            this.error = error;
          }
        }).finally(() => {
          this.loading = false;
        });
      });
    }
  }
}
</script>

<style scoped>
.error-box{
  margin-top: 15px;
  margin-bottom: 15px;
}
</style>
