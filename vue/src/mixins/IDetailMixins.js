import ISubmitMixins from './iSubmitMixins'
import IComponentMixins from "./iComponentMixins";

export default {
    mixins: [ISubmitMixins, IComponentMixins],
    name: 'IViewMixins',
    props: {
        value: {
            type: Boolean,
            default: false
        },
        props: {
            default: null
        }
    },
    methods: {
        getData() {},
        onExit(){
            this.$emit('input', false);
        }
    }
}
