<template>
  <div class="list-panel">
    <Table :columns="columns" :loading="loading" size="small" :data="table.data" ref="Table" highlight-row
           @on-current-change="currentChange"
           :height="tableHeight" @on-cell-click="handleCellClick">
      <slot></slot>
    </Table>
    <Page :current="current" :total="total" :page-size="pageSize"
          show-total @on-change="change" size="small" transfer
          show-elevator show-sizer @on-page-size-change="pageSizeChange"
          :page-size-opts="[15, 30,50, 100, 200, 300]"/>
  </div>
</template>

<script>
import ResizeObserver from 'resize-observer-polyfill';
import TableCellRadio from "@/components/layout/table/table-cell-radio";


export default {
  name: "i-table",
  components: {TableCellRadio},
  props: {
    current: {
      type: Number
    },
    total: {
      type: Number
    },
    pageSize: {
      type: Number,
      default: 50
    },
    table: {
      type: Object,
      default: () => {
        return {columns: [], table: []}
      }
    },
    loading: {
      type: Boolean,
      default: false
    },
    selection: {
      type: Boolean,
      default: false
    },
    showRadio: {
      type: Boolean,
      default: false
    }
  },
  data() {
    return {
      tableHeight: 0,
      currentRow: {},
      radioSelectRow: null,
      selectionColumns: {
        type: 'selection',
        width: 60,
        align: 'center'
      },
      radioColumns: {
        title: "选择",
        width: 70,
        align: 'center',
        render: (h, params) => {
          return h(TableCellRadio, {
            props: {
              value: this.isEqual(params.row, this.radioSelectRow)
            },
            on: {
              'on-change': (v) => {
                if(v === true){
                  this.radioSelectRow = params.row;
                }
              }
            }
          })
        }
      }
    }
  },
  computed: {
    columns() {
      if (this.selection === true) {
        this.table.columns.unshift(this.selectionColumns);
      }
      if (this.showRadio === true) {
        this.table.columns.unshift(this.radioColumns);
      }
      return this.table.columns;
    }
  },
  mounted() {
    this.$nextTick(() => {
      this.handleResize();
      this.handleScoped();
    });
  },
  methods: {
    handleResize() {
      const robserver = new ResizeObserver((entries) => {
        const entry = entries[0];
        const {height} = entry.contentRect;
        this.tableHeight = height - 45;
      });
      robserver.observe(this.$el);
    },
    handleScoped() {
      for (let i in this.$scopedSlots) {
        this.table.columns.forEach((val, key) => {
          if (val.slot === i || val.key === i) {
            val.slot = null;
            val.render = (h, {row, column, index}) => {
              return h('div', this.$scopedSlots[i]({row, column, index}))
            };
          }
        });
      }
    },
    change(page) {
      this.$emit('on-page-change', {
        page: page,
        per_page: this.pageSize
      });
    },
    pageSizeChange(pageSize) {
      this.$emit('on-page-change', {
        page: this.current,
        per_page: pageSize
      });
    },
    getSelection() {
      return this.$refs.Table.getSelection();
    },
    getRadioSelectRow(){
      return this.radioSelectRow;
    },
    currentChange(currentRow, oldCurrentRow) {
      this.currentRow = currentRow;
      this.$emit('on-current-change', {
        currentRow,
        oldCurrentRow
      });
    },
    handleCellClick(row, column, data, event) {
    },
    //判断两个对象是否相等
    isEqual(objA,objB){
      //相等
      if(objA === objB) return objA !== 0 || 1/objA === 1/objB;
      //空判断
      if(objA == null || objB == null) return objA === objB;
      //类型判断
      if(Object.prototype.toString.call(objA) !== Object.prototype.toString.call(objB)) return false;

      switch(Object.prototype.toString.call(objA)){
        case '[object RegExp]':
        case '[object String]':
          //字符串转换比较
          return '' + objA ==='' + objB;
        case '[object Number]':
          //数字转换比较,判断是否为NaN
          if(+objA !== +objA){
            return +objB !== +objB;
          }

          return +objA === 0?1/ +objA === 1/objB : +objA === +objB;
        case '[object Date]':
        case '[object Boolean]':
          return +objA === +objB;
        case '[object Array]':
          //判断数组
          for(let i = 0; i < objA.length; i++){
            if (!this.isEqual(objA[i],objB[i])) return false;
          }
          return true;
        case '[object Object]':
          //判断对象
          let keys = Object.keys(objA);
          for(let i = 0; i < keys.length; i++){
            if (!this.isEqual(objA[keys[i]],objB[keys[i]])) return false;
          }

          keys = Object.keys(objB);
          for(let i = 0; i < keys.length; i++){
            if (!this.isEqual(objA[keys[i]],objB[keys[i]])) return false;
          }

          return true;
        default :
          return false;
      }
    }
  }
}
</script>

<style scoped lang="less">
.list-panel {
  background-color: #fff;
  flex: 1;
  position: relative;
  height: 100%;
  overflow: hidden;
}

.ivu-page {
  margin-top: 10px;
  text-align: center;
}
</style>
