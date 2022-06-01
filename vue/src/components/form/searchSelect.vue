<template>
  <div @keydown.enter="handleEnter">
    <Select
        ref="select"
        v-model="defaultValue"
        filterable
        transfer
        clearable
        :size="size"
        :remote-method="remoteMethod"
        :loading="loading"
        @on-change="change"
    >
      <Option v-for="(option, index) in options" :value="option.code" :key="index">
        <template v-if="showCode">{{ Boolean(option.showCode) ? option.showCode : option.code }}</template>
        <template v-else>{{ option.name }}</template>
      </Option>
    </Select>
  </div>
</template>
<script>
import Emitter from 'view-design/src/mixins/emitter';
import url from "url";

export default {
  name: "search-select",
  mixins: [Emitter],
  props: {
    value: {
      type: [Number, String],
      default: ''
    },
    url: {
      type: String,
      required: true,
    },
    query: {
      type: String,
      default: 'search'
    },
    showCode: {
      type: Boolean,
      default: false
    },
    size: {
      type: String,
      default: 'default'
    },
    useBase: {
      type: Boolean,
      default: false
    }
  },
  computed: {
    defaultValue: {
      get() {
        return this.value;
      },
      set(value) {
        this.$emit('input', value);
        this.dispatch('FormItem', 'on-form-change', value);
      }
    },
    action() {
      return url.resolve(this.$http.defaults.baseURL, this.url);
    },
  },
  data() {
    return {
      loading: false,
      options: []
    }
  },
  methods: {
    change(value) {
      let item = this.options.find((res) => res.code === value || res.showCode === value);
      this.$emit('on-change', item)
    },
    remoteMethod(query) {
      if (query !== '') {
        this.loading = true;
        let params = {};
        params[this.query] = query;
        this.$http.get(this.action, {
          params
        }).then((res) => {
          this.options = res;
        }).finally(() => {
          this.loading = false;
        });
      } else {
        this.options = [];
      }
    },
    handleEnter(e) {
      e.preventDefault();
      if (this.$refs['select'].flatOptions.length === 1) {
        const optionComponent = this.$refs['select'].flatOptions[0];
        if (optionComponent) {
          const option = this.$refs['select'].getOptionData(optionComponent.componentOptions.propsData.value);
          this.$refs['select'].onOptionClick(option);
        } else {
          this.$refs['select'].hideMenu();
        }
        e.stopPropagation();
      } else {
        e.stopPropagation();
      }
    },
    focus() {
      this.$refs['select'].toggleHeaderFocus({type: 'focus'});
    }
  }
}
</script>
