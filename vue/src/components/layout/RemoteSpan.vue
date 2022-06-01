<template>
    <span>{{defaultValue}}</span>
</template>

<script>
    import Emitter from 'view-design/src/mixins/emitter';
    import iJson from '../iJson'

    export default {
        name: "RemoteSpan",
        mixins: [Emitter, iJson],
    }
</script>

<style scoped>

</style>
