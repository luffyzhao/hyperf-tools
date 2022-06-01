<style lang="less">
.login-bg {
  position: absolute;
  width: 100%;
  height: 100%;
  background-image: linear-gradient(to bottom, rgba(97, 176, 233), rgba(53, 131, 203));
  background-repeat: no-repeat;
  background-size: cover;
  background-position: 50% 50%;

  .login {
    position: absolute;
    right: 50%;
    top: 50%;
    transform: translateY(-50%);
    width: 400px;
    margin-right: -200px;
    margin-bottom: -300px;

    .ivu-card-head {
      border-bottom: none;
      padding: 50px 16px 30px;
    }

    .card-title {
      text-align: center;
      font-size: 23px;
    }

    .login-body {
      padding: 0 40px;

      .ivu-input-group-append, .ivu-input-group-prepend {
        padding: 0;

        .captcha {
          width: 125px;
          height: 30px;
          position: relative;

          .captcha-bg {
            cursor: pointer;
            width: 100%;
            height: 100%;
          }
        }
      }

      .forget_password {
        text-align: right;
      }
    }

    .footer {
      text-align: center;
      margin-top: 20px;
      color: white;
    }
  }
}
</style>

<template>
  <div class="login-bg">
    <div class="login">
      <Card :bordered="false" :dis-hover="true">
        <div slot="title" class="card-title">欢迎登录</div>
        <div class="login-body">
          <Form ref="formData" :model="login" :rules="rules" @keydown.enter.native="handleSubmit">
            <FormItem prop="email">
              <Input prefix="md-mail" v-model="login.email" placeholder="请输入邮箱"/>
            </FormItem>
            <FormItem prop="password">
              <Input prefix="md-lock" type="password" v-model="login.password" placeholder="请输入密码"/>
            </FormItem>
            <FormItem prop="captcha" class="captcha-img">
              <Input v-model="login.captcha" placeholder="请输入验证码">
                <div slot="append" class="captcha">
                  <div class="captcha-bg" @click="getCaptchaExcute()" :style="captchaHandle"></div>
                  <Spin fix v-if="captchaLoading"></Spin>
                </div>
              </Input>
            </FormItem>
            <FormItem>
              <Button type="primary" :loading="loading" long @click="handleSubmit">
                <span v-if="!loading">登录</span>
                <span v-else>正在登录...</span>
              </Button>
            </FormItem>
            <FormItem class="forget_password">
              <Button type="text">忘记密码？</Button>
            </FormItem>
          </Form>
        </div>
      </Card>
      <div class="footer">
        <p>Copyright 2019-{{ copyright }} 长沙伊佳网络科技有限公司 All rights reserved.</p>
      </div>
    </div>
  </div>
</template>

<script>
import {mapMutations} from 'vuex'
import iSubmitMixins from "../../../mixins/iSubmitMixins";

export default {
  mixins: [iSubmitMixins],
  data() {
    return {
      loading: false,
      captchaLoading: false,
      login: {
        email: '',
        password: ''
      },
      captcha: {
        image: ''
      },
      rules: {
        email: [{
          required: true,
          message: '邮箱不能为空',
          trigger: 'blur'
        }],
        password: [{
          required: true,
          message: '密码不能为空',
          trigger: 'blur'
        }],
        captcha: [{
          required: true,
          message: '验证码不能为空',
          trigger: 'blur'
        }]
      }
    }
  },
  computed: {
    captchaHandle() {
      let capt = this.captcha.image;
      return {
        "backgroundImage": `url(${capt})`
      };
    },
    copyright() {
      let date = new Date;
      return date.getFullYear();
    }
  },
  created() {
    this.getCaptchaExcute()
  },
  methods: {
    ...mapMutations({
      setToken: 'common/setToken', setMenus: 'common/setMenus'
    }),
    handleSubmit() {
      this.validate('formData').then(() => {
        this.loading = true;
        this.$http.post(`login`, Object.assign({}, this.login, {
          key: this.captcha.key
        })).then(({access_token, menus}) => {
          this.setToken(access_token);
          this.setMenus(menus);
        }).finally(() => {
          this.getCaptchaExcute();
          this.loading = false;
        });
      });
    },
    getCaptchaExcute() {
      this.captchaLoading = true;
      this.$http.get(`captcha`).then((res) => {
        this.captcha = res;
      }).finally(() => {
        this.captchaLoading = false;
      });
    }
  }
}
</script>
