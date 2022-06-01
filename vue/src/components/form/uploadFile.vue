<template>
  <Input readonly v-model="value">
    <Upload :multiple="false"
            :on-success="handleSuccess"
            :on-error="handleError"
            :on-format-error="handleFormatError"
            :max-size="maxSize"
            :on-exceeded-size="handleMaxSize"
            :before-upload="handleBeforeUpload"
            :show-upload-list="false"
            :action="action" :headers="headers" ref="upload" slot="append">
      <Button icon="ios-cloud-upload-outline">上传</Button>
    </Upload>
    <Button slot="prepend" @click="handleView(this.value)">查看</Button>
  </Input>
</template>

<script>
import IUpload from "@/components/iUpload";

export default {
  name: "uploadFile",
  mixins: [IUpload],
  methods: {
    handleSuccess(file) {
      this.defaultValue = file.url;
      this.$refs.upload.clearFiles();
      this.handleEnd();
    }
  }
}
</script>

<style scoped>

</style>
