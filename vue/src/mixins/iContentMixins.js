import ISubmit from './iSubmitMixins'
import IComponent from "./iComponentMixins";

export default {
    mixins: [ISubmit, IComponent],
    name: 'IContentMixins',
    data() {
        return {
            page: {
                current: 1,
                total: 0,
                per_page: 50
            },
            table: {
                columns: [],
                data: [],
                selections: []
            },
            loading: true,
            search: {},
        }
    },
    mounted() {
        this.$nextTick(() => {
            this.getLists();
        });
    },
    methods: {
        pageChange(v) {
            this.page.per_page = v.per_page;
            this.getLists(v.page);
        },
        getLists() {
        }
    }
}
