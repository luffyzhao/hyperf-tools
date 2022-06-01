<template>
    <IDrawer v-model="defaultValue" width="500" :loading="loading">
        <Form :model="data" :rules="ruleValidate" ref="formCreate" label-position="top">
            <Row :gutter="12">
                <Col span="12">
                    <FormItem label="姓名" prop="name">
                        <Input placeholder="请输入姓名" v-model="data.name" readonly></Input>
                    </FormItem>
                </Col>
                <Col span="12">
                    <FormItem label="邮箱" prop="email">
                        <Input placeholder="请输入邮箱" v-model="data.email" readonly></Input>
                    </FormItem>
                </Col>
                <Col span="12">
                    <FormItem label="用户状态" prop="status">
                        <Select v-model="data.status">
                            <Option :value="1">开启</Option>
                            <Option :value="0">关闭</Option>
                        </Select>
                    </FormItem>
                </Col>
                <Col span="12">
                    <FormItem label="所属部门" prop="role_id">
                        <Select v-model="data.role_id">
                            <Option v-for="(item) in roles.data" :key="item.id" :value="item.id">
                                {{item.name}}
                            </Option>
                        </Select>
                    </FormItem>
                </Col>
                <Col span="24">
                    <FormItem label="说明" prop="remark">
                        <Input v-model="data.remark" type="textarea" :autosize="{minRows: 7,maxRows: 7}"
                               placeholder="Enter something..."/>
                    </FormItem>
                </Col>
                <Col span="24">
                    <Alert>提示<template slot="desc">密码是系统自动生成并发送到用户邮件。</template></Alert>
                </Col>
            </Row>
        </Form>
        <div slot="footer">
            <Button type="primary" icon="ios-add" @click="submit('formCreate')">提交</Button>
        </div>
    </IDrawer>
</template>

<script>
    import IDrawerMixins from "@/mixins/iDrawerMixins";
    import IDrawer from "@/components/layout/IDrawer";
    import data from "./data";

    export default {
        name: "update",
        components: {IDrawer},
        mixins: [IDrawerMixins, data],
        mounted() {
            this.$http(`authorities/user/${this.props.id}/edit`).then((res) => {
                this.data = res.row
                this.roles.data = res.roles;
                this.loading = false
            });
        },
        methods: {
            submit(name) {
                this.loading = true;
                this.validate(name).then(() => {
                    this.$http.put(`authorities/user/${this.props.id}`, this.data).then(() => {
                        this.$Message.success('更新成功')
                    }).finally(() => {
                        this.loading = false;
                    });
                }).catch();
            }
        }
    }
</script>

<style scoped>

</style>
