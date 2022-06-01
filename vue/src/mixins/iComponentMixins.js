export default {
    name: 'IComponentMixins',
    props: {
        value: {
            type: Boolean,
            default: false
        },
        props: {
            default: null
        }
    },
    data() {
        return {
            componentProps: {
                view: null,
                props: {},
                value: false
            },
            detailView: null
        }
    },
    methods: {
        currentChange({currentRow, oldCurrentRow}) {
            if(this.detailView  === null){
                this.$Message.error(`程序失败！`);
            }else{
                this.componentProps.value = false;
                setTimeout(() => {
                    this.componentProps.type = 'detail';
                    this.componentProps.view = this.detailView;
                    this.componentProps.props = currentRow;
                    this.componentProps.value = true;
                }, 300);
            }
        },
        openComponent(view, props = null) {
            this.componentProps.type = 'other';
            this.componentProps.view = view;
            this.componentProps.props = props;
            this.componentProps.value = true;
        },
        openComponentSelection(view, table) {
            this._selectionOne(table).then((row) => {
                this.componentProps.view = view;
                this.componentProps.props = row;
                this.componentProps.value = true;
            });
        },
        copySelection(table, key) {
            if (!Boolean(this.$refs[table])) {
                this.$Message.error(`参数错误`);
            } else {
                let selection = this.$refs[table].getSelection();
                let string = '';
                selection.forEach((v) => {
                    string += v[key] + "\n";
                });

                this.$copyText(string).then((e) => {
                    this.$Message.success('复制成功');
                }, (e) => {
                    this.$Message.error('复制失败');
                });
            }

        },
        closeComponent() {
            this.componentProps.view = null;
            this.componentProps.props = null;
        }
    }
}
