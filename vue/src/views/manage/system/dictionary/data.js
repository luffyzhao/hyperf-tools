export default {
    name: "i-data",
    data() {
        return {
            loading: false,
            data: {element: []},
            ruleValidate: {
                code: [{required: true, message: "代码必须填写"}],
                name: [{required: true, message: "名称必须填写"}],
                element: [{required: true, type: 'array', message: "名称必须填写"}]
            }
        }
    },
    methods: {
        addElementHandle() {
            this.data.element.push({
                code: '',
                name: ''
            })
        },
        deleteElementHandle(index){
            this.data.element.splice(index, 1);
        }
    }
}
