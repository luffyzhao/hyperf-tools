<template>
  <div class="i-detail" v-show="value">
      <div class="extra">
          <Tooltip content="隐藏" transfer placement="top">
            <Icon type="md-close" class="ivu-tag" :color="color" size="18" @click.native="handleHide"/>
          </Tooltip>
          <slot name="extra"></slot>
      </div>
      <div v-if="value" class="i-detail-box">
          <slot></slot>
      </div>
  </div>
</template>

<script>
export default {
    name: "IDetail",
    props:{
        value:{
            type: Boolean,
            default: false
        }
    },
    data(){
        return {
            color: '#808695'
        }
    },
    methods: {
        handleHide(){
            this.$emit('input', false);
        }
    }
}
</script>

<style scoped lang="less">
.i-detail{
    position: relative;
    height: 250px;
    .i-detail-box{
        height: 250px;
    }
    .extra{
        position: absolute;
        right: 0px;
        z-index: 1;
        top:7px;
    }
}
</style>
