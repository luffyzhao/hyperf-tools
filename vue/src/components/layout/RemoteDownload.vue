<template>
    <span @click="submitForDownload" class="pointer">{{defaultValue}}</span>
</template>

<script>
    import IJson from '../iJson';
    import FileSaver from "file-saver";

    export default {
        name: "RemoteDownload",
        mixins: [IJson],
        computed: {
            defaultValue() {
                let value = '';
                this.lists.forEach((val) => {
                    if (val.code === this.value) {
                        value = val.name;
                    }
                });
                return value;
            }
        },
        methods: {
            submitForDownload() {
                this.loading = true;
                this.$http.download(`common/download/template`, {
                    file: this.defaultValue
                }).then((res) => {
                    let filename = this.defaultValue.split('/').pop();
                    FileSaver.saveAs(res, filename);
                }).finally(() => {
                    this.loading = false;
                });
            }

        }
    }
</script>

<style scoped>
    span.pointer {
        cursor: pointer;
        color: #3399ff;
    }
</style>
