<template>
  <IContent v-model="componentProps">
    <Alert>面板自定义</Alert>
  </IContent>
</template>

<script>
import IContent from "../../../components/layout/IContent";
import IContentMixins from "../../../mixins/iContentMixins"

export default {
  components: {
    IContent
  },
  mixins: [IContentMixins],
  mounted() {
    this.test();
  },
  data() {
    return {}
  },
  methods: {
    test(){

    }
  }
}
</script>

<style>
</style>
