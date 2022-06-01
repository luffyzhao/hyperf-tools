<template>
  <IContent v-model="componentProps" :loading="loading">
    <Card shadow class="header">
      <div>
        <h3 style="margin-bottom: 4px;">个人中心</h3>
        <p>给自己时间，不要焦急，一步一步来，一日一日过，请相信生命的韧性是惊人的，跟自己向上的心去合作，不要放弃对自己的爱护。加油吧！打工人！！</p>
      </div>
    </Card>

    <Row :gutter="40" class="body">
      <Col span="6">
        <Card class="profile">
          <div slot="title">个人资料</div>
          <div class="center">
            <Avatar icon="ios-person" style="background-color: #87d068" :size="80"/>
            <h3 class="ivu-m-8">{{ data.name }}</h3>
          </div>
          <div class="line-profile">
            <p>
              <Icon type="ios-mail-outline"/>
              {{ data.email }}
            </p>
            <p>
              <Icon type="md-contact" />
              {{ data.name }}
            </p>
          </div>
        </Card>

        <Card>
          <div slot="title">密码修改</div>
          <div class="update-password">
            <Form ref="formCreate" :model="updateData" label-position="top" :rules="ruleValidate">
              <FormItem label="更新密码" prop="password">
                <Input v-model="updateData.password" type="password" password></Input>
              </FormItem>
              <FormItem label="确认密码" prop="password_confirmation">
                <Input v-model="updateData.password_confirmation" type="password" password></Input>
              </FormItem>
              <FormItem>
                <Button type="primary" long @click="submitForPassword('formCreate')">提交</Button>
              </FormItem>
            </Form>
          </div>
        </Card>
      </Col>
      <Col span="18" style="height: 100%;">
        <Card class="card-bordered h-100">
          <div slot="title">操作日志</div>
          <ISearch v-model="search">
            <FormItem label="操作权限">
              <Input v-model="search.name" placeholder="操作权限" size="small"></Input>
            </FormItem>
            <FormItem label="请求类型">
              <Input v-model="search.method" placeholder="请求类型" size="small"></Input>
            </FormItem>
            <FormItem :label-width="1">
              <ButtonGroup>
                <Button type="primary" icon="ios-search" size="small" @click="getLists(1)">搜索</Button>
              </ButtonGroup>
            </FormItem>
          </ISearch>

          <ITable :current="page.current" :table="table" :total="page.total"
                  @on-page-change="pageChange"></ITable>
        </Card>
      </Col>
    </Row>

  </IContent>
</template>

<script>
import IContent from "../../../components/layout/IContent";
import IContentMixins from "../../../mixins/iContentMixins";
import ISearch from "../../../components/layout/ISearch";
import ITable from "../../../components/layout/ITable";

export default {
  components: {IContent, ITable, ISearch},
  mixins: [IContentMixins],
  data() {
    return {
      data: {},
      updateData: {},
      table: {
        columns: [{
          title: '操作权限',
          key: 'name'
        }, {
          title: '请求类型',
          key: 'method'
        }, {
          title: '请求时间',
          key: 'created_at'
        }]
      },
      ruleValidate: {
        password: [{required: true, message: '密码不能为空！'}],
        password_confirmation: [{required: true, message: '密码不能为空！'}],
      },
    }
  },
  mounted() {
    this.getData();
  },
  methods: {
    getData() {
      this.$http.get(`profile`).then((res) => {
        this.data = res;
      }).finally(() => {
        this.loading = false
      });
    },
    getLists(page) {
      this.loading = true;
      this._lists(`profile/logs`, page);
    },
    submitForPassword(name) {
      this.validate(name).then(() => {
        this.loading = true;
        this.$http.put(`profile/password`, this.updateData).finally(() => {
          this.loading = false;
        });
      });
    }
  }
}
</script>

<style scoped>
.header {
  margin-bottom: 15px;
}

.card-bordered {
  border-right: none;
  height: 100%;
}

.center {
  text-align: center;
}

.line-profile .ivu-icon {
  margin-right: 10px;
}

.line-profile .ivu-tag-color-primary {
  cursor: pointer;
}

.profile {
  margin-bottom: 15px;
}

.body {
  height: calc(100% - 96px);
}

.update-password {

}
</style>
