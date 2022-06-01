import url from "url";

export default {
    name: 'iUpload',
    props: {
        url: {
            type: String,
            required: true
        },
        name: {
            type: String,
            default: 'file'
        },
        value: {
            type: [Array, String]
        },
        maxSize: {
            type: Number,
            default: 10240
        },
        format: {
            type: Array,
            default: () => []
        },
        data: {
            type: Object,
            default: () => {
                return {}
            }
        }
    },
    data() {
        return {
            loading: true
        }
    },
    computed: {
        action() {
            return url.resolve(this.$http.defaults.baseURL, this.url);
        },
        headers() {
            return {
                authorization: 'bearer ' + this.$store.state.common.token,
                Accept: 'application/json'
            }
        }, defaultValue: {
            get() {
                return this.value;
            },
            set(val) {
                this.$emit('input', val);
            }
        }
    },
    methods: {
        handleError() {
            this.handleEnd();
        },
        handleFormatError() {
            this.$Message.error('不能上传该文件文件格式');
            this.handleError();
        },
        handleMaxSize(file) {
            this.$Message.error(`文件起出最大限制 ${this.maxSize} kb`);
            this.handleError();
        },
        handleBeforeUpload() {
            this.loading = true;
            this.$emit('on-before-upload');
            return true;
        },
        handleEnd() {
            this.loading = false;
            this.$emit('on-end');
        },
        handleView(file) {
            window.open(file.url);
        }
    }
}
