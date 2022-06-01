<template>
    <IModal v-model="defaultValue" :loading="loading" :width="550" :title="props.title" class="distribution-table">
        <IContent ref="IContent">
            <Form :model="data" :label-width="0" :rules="ruleValidate" ref="formCreate">
                <FormItem label="" prop="file">
                    <UploadFile :format="['xlsx']"
                                v-model="data.file"
                                :url="uploadUrl"
                                @on-success="handleUpload"
                                @on-progress="handleProgress"
                    ></UploadFile>
                </FormItem>
            </Form>
            <Table :columns="columns" size="small" :data="error" ref="Table" :stripe="true" :height="tableHeight" border>
            </Table>
        </IContent>
        <div slot="footer">
            <Button type="primary" icon="md-attach" v-if="error.length > 0" @click="exportError()">导出</Button>
        </div>
    </IModal>
</template>

<script>
import IDrawerMixins from "@/mixins/iDrawerMixins";
import IModal from "@/components/layout/IModal";
import UploadFile from "@/components/form/uploadFile";
import IContent from "@/components/layout/IContent";

export default {
    name: "Export",
    components: {IContent, UploadFile, IModal},
    mixins: [IDrawerMixins],
    props: {
      uploadUrl: {
        type: String,
        default: "/api/common/upload/files"
      }
    },
    data() {
        return {
            tableHeight: 0,
            loading: false,
            data: {},
            ruleValidate: {
                file: [{required: true, message: "文件不能为空！"}]
            },
            columns:[{
                title: '单号',
                key: 'key'
            },{
                title: '错误信息',
                key: 'message'
            }],
            error:[]
        }
    },
    mounted() {
        this.$nextTick(() => {
            this.tableHeight = this.$refs['IContent'].$el.clientHeight - this.$refs['formCreate'].$el.clientHeight;
        });
    },
    methods: {
        submit(name) {
            this.validate(name).then(() => {
                this.loading = true;
                this.$http.post(this.props.url, this.data).then((res) => {
                    this.error = res;
                    this.$Message.success(`上传成功`);
                }).finally(() => {
                    this.loading = false;
                });
            });
        },
        exportError(){
            this.exportExcel(this.columns, this.error, '失败信息导出.xlsx');
        },
        handleProgress(){
            this.loading = true;
        },
        handleUpload(){
            this.loading = false;
            this.submit('formCreate');
        }
    }
}
</script>

<style lang="less">
.distribution-table {
    .modal-body {
        height: calc(100vh - 350px) !important;
    }
}
</style>

