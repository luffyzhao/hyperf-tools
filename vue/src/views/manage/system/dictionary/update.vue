<template>
    <IDrawer v-model="defaultValue" :loading="loading" :width="400">
        <Form :model="data" :rules="ruleValidate" ref="formCreate" label-position="top">
            <FormItem label="代码" prop="code">
                <Input v-model="data.code"></Input>
            </FormItem>
            <FormItem label="名称" prop="name">
                <Input v-model="data.name"></Input>
            </FormItem>
            <Row :gutter="20">
                <template v-for="(item, index) in data.element">
                    <Col :span="10">
                        <FormItem label="代码" :prop="`element.${index}.code`"
                                  :rules="[{required: true, message: '代码必须填写'}]">
                            <Input v-model="data.element[index].code"></Input>
                        </FormItem>
                    </Col>
                    <Col :span="10">
                        <FormItem label="名称" :prop="`element.${index}.name`"
                                  :rules="[{required: true, message: '名称必须填写'}]">
                            <Input v-model="data.element[index].name"></Input>
                        </FormItem>
                    </Col>
                    <Col :span="4">
                        <FormItem label="操作">
                            <Button size="small" @click="deleteElementHandle(index)">删除</Button>
                        </FormItem>
                    </Col>
                </template>
                <Col :span="24">
                    <Button size="small" long type="dashed" @click="addElementHandle">添加字典</Button>
                </Col>
            </Row>
        </Form>
        <div slot="footer">
            <Button type="primary" icon="ios-add" @click="submit('formCreate')">提交</Button>
            <Button type="warning" icon="md-log-out" @click="defaultValue = false">返回</Button>
        </div>
    </IDrawer>
</template>

<script>
    import IDrawerMixins from "@/mixins/iDrawerMixins";
    import IDrawer from "@/components/layout/IDrawer";
    import IData from "./data"

    export default {
        name: "update",
        components: {IDrawer},
        mixins: [IDrawerMixins, IData],
        mounted(){
            this.getData();
        },
        methods: {
            getData() {
                this.loading = true;
                this.$http.get(`system/dictionary/${this.props.code}/edit`).then((res) => {
                    this.data = res;
                }).finally(() => {
                    this.loading = false;
                });
            },
            submit(name) {
                this.validate(name).then(() => {
                    this.loading = true;
                    this.$http.put(`system/dictionary/${this.props.code}`, this.data).then((res) => {
                        this.defaultValue = false;
                    }).finally(() => {
                        this.loading = false;
                    });
                });
            }
        }
    }
</script>

<style scoped>

</style>
