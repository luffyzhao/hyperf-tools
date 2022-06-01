export default {
    data() {
        return {
            loading: false,
            data: {},
            ruleValidate: {
                name: [
                    {required: true, message: '客户公司名称必须填写', trigger: 'blur'},
                    {type: 'string', min: 5, max: 20, message: '权限名称字符长度是5-20个字符', trigger: 'blur'}
                ],
                short_name: [
                    {required: true, message: '客户简称必须填写', trigger: 'blur'},
                ]
            }
        }
    }
}