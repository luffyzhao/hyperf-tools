export default {
    data() {
        return {
            loading: true,
            data: {
                authorities: [],
                menus: []
            },
            authorities: {
                data: []
            },
            menus: {
                data: []
            },
            ruleValidate: {
                name: [
                    {required: true, message: '部门名称不能为空', trigger: 'blur'},
                    {type: 'string', min: 2, max: 20, message: '权限名称字符长度是2-20个字符', trigger: 'blur'}
                ],
                description: [
                    {type: 'string', max: 255, message: '权限描述最长255个字符', trigger: 'blur'}
                ]
            }
        }
    },
    methods: {
        handleChange(newTargetKeys) {
            this.data.authorities = newTargetKeys
        },
        change(menus) {
            this.authorities.data = menus;
        }
    }
}