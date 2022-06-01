export default {
    data() {
        return {
            loading: true,
            data: {},
            departments: {
                data: []
            },
            roles: {
                data: []
            },
            ruleValidate: {
                name: [
                    {required: true, message: '用户姓名必须填写', trigger: 'blur'},
                    {type: 'string', min: 2, max: 20, message: '用户姓名字符长度是2-20个字符', trigger: 'blur'}
                ],
                email: [
                    {required: true, message: '用户邮箱不能为空', trigger: 'blur'},
                    {type: 'email', message: '用户邮箱格式不正确', trigger: 'blur'},
                ],
                role_id: [
                    {required: true, type: 'number', message: '所属部门不能为空', trigger: 'change'},
                ],
                status: [
                    {required: true, type: 'enum', enum: [1, 0], message: '用户状态不能为空'}
                ]
            }
        }
    }
}
