<template>
    <IModal v-model="defaultValue" :transfer="transfer">
        <Carousel loop radius-dot ref="carousel">
            <CarouselItem v-for="(item,index) in props.lists" :key="index">
                <div class="image-box"><img :src="Boolean(item.url) ? item.url : item" class="item-image"/></div>
            </CarouselItem>
        </Carousel>
    </IModal>
</template>

<script>
    import IDrawerMixins from "../../mixins/iDrawerMixins";
    import IModal from "./IModal";

    export default {
        name: "ModalCarousel",
        components: {IModal},
        mixins: [IDrawerMixins],
        computed: {
            defaultValue: {
                get() {
                    return this.value;
                }, set(v) {
                    return this.$emit('input', v);
                }
            }
        },
        props: {
            value: {
                type: Boolean,
                default: false
            },
            props: {
                default: Array
            },
            transfer: {
                type: Boolean,
                default: false
            }
        },
        watch:{
            value(v){
                this.$refs['carousel'].handleResize();
            }
        }
    }
</script>


<style scoped>
    .image-box {
        height: 400px;
    }
    .ivu-carousel-item{
        text-align: center;
    }
    .image-box {
        max-width: 688px;
        max-height: 400px;
        vertical-align: middle;
        display: inline;
    }

    .item-image {
        max-width: 688px;
        max-height: 400px;
        display: inline;
    }
</style>
