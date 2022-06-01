<template>
  <div>
    <div class="demo-upload-list" v-for="(item, index) in defaultValue">
      <img :src="item.url"/>
      <div class="demo-upload-list-cover">
        <Icon type="ios-eye-outline" @click.native="handleView(item)"></Icon>
        <Icon type="ios-trash-outline" @click.native="handleRemove(index)"></Icon>
      </div>
    </div>
    <Upload
        ref="upload"
        :show-upload-list="false"
        :on-success="handleSuccess"
        :on-error="handleError"
        :format="format"
        :max-size="maxSize"
        :on-format-error="handleFormatError"
        :on-exceeded-size="handleMaxSize"
        :before-upload="handleBeforeUpload"
        multiple
        :headers="headers"
        type="drag"
        :action="action"
        class="upload-list-input">
      <div class="upload-list-cover">
        <Icon type="ios-camera" size="20"></Icon>
        <Spin fix v-if="loading" style="line-height: 1.5;">
          <Icon type="ios-loading" size=18 class="demo-spin-icon-load"></Icon>
          <div>Loading</div>
        </Spin>
      </div>
    </Upload>
  </div>
</template>
<script>
import ModalCarousel from "../layout/ModalCarousel";
import IUpload from "../iUpload";

export default {
  name: "UploadImages",
  components: {ModalCarousel},
  mixins: [IUpload],
  methods: {
    handleRemove(index) {
      let value = JSON.parse(JSON.stringify(this.defaultValue));
      value.splice(index, 1);
      this.defaultValue = value;
    },
    handleSuccess(res, file) {
      let value = JSON.parse(JSON.stringify(this.defaultValue));
      value.push(res);
      this.defaultValue = value;
      this.handleEnd();
    }
  }
}
</script>
<style>
.demo-spin-icon-load {
  animation: ani-demo-spin 1s linear infinite;
}

@keyframes ani-demo-spin {
  from {
    transform: rotate(0deg);
  }
  50% {
    transform: rotate(180deg);
  }
  to {
    transform: rotate(360deg);
  }
}

.demo-upload-list {
  display: inline-block;
  width: 120px;
  height: 120px;
  text-align: center;
  line-height: 120px;
  border: 1px solid transparent;
  border-radius: 4px;
  overflow: hidden;
  background: #fff;
  position: relative;
  box-shadow: 0 1px 1px rgba(0, 0, 0, .2);
  margin-right: 4px;
}

.demo-upload-list img {
  max-width: 100%;
  max-height: 100%;
  vertical-align: middle;
}

.demo-upload-list-cover {
  display: none;
  position: absolute;
  top: 0;
  bottom: 0;
  left: 0;
  right: 0;
  background: rgba(0, 0, 0, .6);
}

.demo-upload-list:hover .demo-upload-list-cover {
  display: block;
}

.demo-upload-list-cover i {
  color: #fff;
  font-size: 20px;
  cursor: pointer;
  margin: 0 2px;
}

.upload-list-cover {
  width: 118px;
  height: 118px;
  line-height: 118px;
}

.upload-list-input {
  display: inline-block;
  width: 118px;
}
</style>
