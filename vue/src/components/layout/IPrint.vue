<template>
    <div ref="print">
        <H3 class="print">{{ title }}</H3>
        <slot></slot>
    </div>
</template>

<script>
export default {
    name: "IPrint",
    props: {
        title: {
            type: String,
            required: true
        }
    }
}
</script>

<style>
@media print {
    * {
        font-size: 12px;
    }
    h3{
        text-align: center;
        font-size: 20px !important;
    }

    body {
        -webkit-print-color-adjust: exact;
        -moz-print-color-adjust: exact;
        -ms-print-color-adjust: exact;
        print-color-adjust: exact;
    }

    @page {
        size: a5 landscape;
        margin-left: 30px;
        margin-right: 30px;
        margin-top: 30px;
        @bottom-center {
            content: "第" counter(page) "页";
        }
    }

    .ivu-table {
        height: auto;
    }
    .on-print {
        display: none;
    }
    .print {
        display: block;
    }
    .ivu-table-wrapper {
        display: inline-block;
    }
}

</style>
