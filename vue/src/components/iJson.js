import url from "url";

export default {
    name: 'iJson',
    props: {
        value: {
            type: [Number, String],
            default: ''
        },
        url: {
            type: String,
            required: true,
            default: ''
        },
        showCode: {
            type: Boolean,
            default: false
        },
        cache: {
            type: Boolean,
            default: true
        }
    },
    data() {
        return {
            lists: []
        }
    },
    computed: {
        defaultValue() {
            let value = '';
            this.lists.forEach((val) => {
                if (val.code === this.value) {
                    value = this.showCode ? `${val.code} - ${val.name}` : val.name;
                }
            });
            return value;
        }, action() {
            return url.resolve(this.$http.defaults.baseURL, this.url);
        }
    },
    mounted() {
        this.getData();
    },
    methods: {
        request() {
            return this.$http.get(this.action).then(this.setData).finally(this.getFinally);;
        },
        setData(res) {
            this.lists = res;
            this.loading = false;
            this.$cache.set(this.action, res);
        },
        getData() {
            if (this.cache === false) {
                this.request();
            } else {
                let list = this.$cache.get(this.action) || [];
                let remote = this.$cache.get(`remote:` + this.action) || false;

                if (list.length === 0 && remote === false) {
                    this.$cache.set(`remote:` + this.action, true);
                    this.request();
                } else if (remote === true) {
                    setTimeout(() => {
                        this.getData();
                    }, 1000);
                } else {
                    this.setData(list)
                }

            }
        },
        getFinally() {
            if(this.cache === true){
                this.$cache.set(`remote:` + this.action, false);
            }
        }
    }
}
