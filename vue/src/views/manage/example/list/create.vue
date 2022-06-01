<template>
  <IDrawer v-model="defaultValue" :loading="loading">

  </IDrawer>
</template>

<script>
import IDrawerMixins from "@/mixins/iDrawerMixins";
import IDrawer from "@/components/layout/IDrawer";

export default {
  name: "create",
  components: {IDrawer},
  mixins: [IDrawerMixins]
}
</script>

<style scoped>

</style>
