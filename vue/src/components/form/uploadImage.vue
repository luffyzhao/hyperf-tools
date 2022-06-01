<template>
  <Upload
      :multiple="false"
      type="drag"
      :on-success="handlesuccess"
      :show-upload-list="false"
      :format="format"
      :on-format-error="handleFormatError"
      :on-error="handleError"
      :before-upload="handleBeforeUpload"
      :max-size="maxSize"
      :action="action"
      :headers="headers"
      ref="upload"
  >
    <div style="padding: 20px; width: 340px; height: 240px;text-align: center;line-height: 240px;margin: 0 auto;">
      <Icon type="ios-cloud-upload" size="200" style="color: #3399ff" v-show="value === ''"></Icon>
      <img :src="value" v-show="value !== ''" style="max-width: 300px; max-height: 200px"/>
    </div>
  </Upload>
</template>

<script>
import IUpload from "../iUpload";

export default {
  name: "UploadImage",
  mixins: [IUpload],
  methods: {
    handleUpload(file) {
      this.defaultValue = file.url;
      this.$refs.upload.clearFiles();
      this.handleEnd();
    }
  }
}
</script>

<style scoped>

</style>
