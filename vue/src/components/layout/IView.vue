<template>
    <div class="i-view">
        <slot></slot>
        <div class="i-view-exit" @click="exit">
            <Icon type="ios-arrow-back" :size="20"/>
        </div>
        <div class="i-view-repeat" @click="repeat">
            <Icon type="md-repeat" :size="20"/>
        </div>
    </div>
</template>

<script>
    export default {
        name: "IView",
        methods: {
            exit(){
                this.$emit('on-exit');
            },
            repeat(){
                this.$emit('on-repeat');
            }
        }
    }
</script>

<style scoped>
    .i-view {
        height: 100%;
        position: relative;
    }

    .i-view .i-view-exit {
        position: absolute;
        top: 0;
        left: 0;
        cursor: pointer;
    }

    .i-view .i-view-repeat {
        position: absolute;
        top: 0;
        right: 15px;
        cursor: pointer;
    }
</style>