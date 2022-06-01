import {writeFile} from 'xlsx';

export default {
    name: 'ISubmitMixins',
    data() {
        return {
            loading: false
        }
    },
    methods: {
        validate(name) {
            return new Promise((resolve, reject) => {
                this.$refs[name].validate((valid) => {
                    valid ? resolve() : reject();
                });
            });
        },
        print(ref) {
            this.$p({
                el: this.$refs[ref].$el,   //打印目标dom节点，eg: this.refs.view
                debug: false,             //打开调试模式，会显示iframe,
                importCss: true,         //引入head 中的link stylesheet
                importStyle: true,       //引入style标签中的样式
                loadCss: document.querySelectorAll("link[as = 'style']"),             //需要载入的第三方样式表
                delay: 300,              //延迟打印时间，确保iframe中的静态资源加载完成
                beforePrinfHandle: null, //打开打印窗口前的钩子函数,可以针对打印文档进行自定义调整，接受一个document参数
                afterPrintHandle: null,  //打印完成的钩子函数,
            });
        },
        Boolean(v) {
            return Boolean(v);
        },
        _lists(url, page) {
            this.loading = true;
            this.$http.get(url, {
                params: Object.assign({}, this.search, {page: page, per_page: this.page.per_page})
            }).then((data) => {
                this.table.data = data.data;
                this.page.total = data.total;
                this.page.current = data.current_page;
            }).finally(() => {
                this.loading = false;
            });
        },
        _confirm(r = (h) => {
            return h('p', '该操作是不可逆，确认进行这个操作吗？')
        }) {
            let render;
            if (typeof r === 'string') {
                render = (h) => {
                    return h('p', r)
                }
            } else {
                render = r;
            }
            return new Promise((resolve, reject) => {
                this.$Modal.confirm({
                    title: '警告',
                    render,
                    className: 'ivu-modal-wrap',
                    lockScroll: true,
                    onOk: () => {
                        resolve();
                    }
                });
            });
        },
        _download(url, file = '下载的文件.txt') {
            return this.$http.download(url).then((res) => {
                let url = window.URL.createObjectURL(new Blob([res]));
                let link = document.createElement('a');
                link.style.display = 'none';
                link.href = url;
                link.setAttribute('download', file);
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
                window.URL.revokeObjectURL(url);
            });
        },
        _selectionOne(table) {
            return new Promise((resolve, reject) => {
                if (!Boolean(this.$refs[table])) {
                    this.$Message.error(`参数错误`);
                } else {
                    let selection = this.$refs[table].getRadioSelectRow();

                    if (!Boolean(selection)) {
                        this.$Message.error(`请先选择一条数据！`);
                    } else {
                        resolve(selection);
                    }
                }
            });
        },
        getFileName(o) {
            let pos = o.lastIndexOf('/');
            return o.substring(pos + 1);
        },
        exportExcel(headers, data, fileName = '导出结果.xlsx') {
            let _headers = headers
                .map((item, i) => Object.assign({}, {
                    key: item.key,
                    title: item.title,
                    position: String.fromCharCode(65 + i) + 1
                }))
                .reduce((prev, next) => Object.assign({}, prev, {[next.position]: {key: next.key, v: next.title}}), {})
            let _data = data
                .map((item, i) =>
                        headers.map((key, j) => Object.assign({}, {
                            content: item[key.key],
                            position: String.fromCharCode(65 + j) + (i + 2)
                        }))
                )
                // 对刚才的结果进行降维处理（二维数组变成一维数组）
                .reduce((prev, next) => prev.concat(next))
                // 转换成 worksheet 需要的结构
                .reduce((prev, next) => Object.assign({}, prev, {[next.position]: {v: next.content}}), {})
            console.log(_data)
            // 合并 headers 和 data
            let output = Object.assign({}, _headers, _data)
            // 获取所有单元格的位置
            let outputPos = Object.keys(output)
            // 计算出范围 ,["A1",..., "H2"]
            let ref = `${outputPos[0]}:${outputPos[outputPos.length - 1]}`

            // 构建 workbook 对象
            let wb = {
                SheetNames: ['mySheet'],
                Sheets: {
                    mySheet: Object.assign(
                        {},
                        output,
                        {
                            '!ref': ref,
                            '!cols': [{wpx: 45}, {wpx: 100}, {wpx: 200}, {wpx: 80}, {wpx: 150}, {wpx: 100}, {wpx: 300}, {wpx: 300}]
                        }
                    )
                }
            }

            // 导出 Excel
            writeFile(wb, fileName)
        }
    }
}
