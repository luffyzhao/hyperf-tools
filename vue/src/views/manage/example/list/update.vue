<template>
  <IDrawer v-model="defaultValue" :loading="loading">

  </IDrawer>
</template>

<script>
import IDrawerMixins from "@/mixins/iDrawerMixins";
import IDrawer from "@/components/layout/IDrawer";

export default {
  name: "update",
  components: {IDrawer},
  mixins: [IDrawerMixins],
  mounted() {
    this.getData();
  },
  methods: {
    getData() {

    }
  }
}
</script>

<style scoped>

</style>
