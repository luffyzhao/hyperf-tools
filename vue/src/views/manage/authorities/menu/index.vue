<template>
  <IContent :loading="loading" class="wrapper-menu" @on-change="getLists">
    <Card shadow class="remark">
      <div>
        <h3>菜单管理</h3>
        <p>菜单管理页面：从菜单列表选择一项后，可以进行编辑。</p>
      </div>
    </Card>
    <Row class="cards">
      <Col span="11">
        <Card>
          <div slot="title">
            <Dropdown @on-click="createMenu" class="dropdown-button">
              <Button size="small">
                添加菜单
                <Icon type="ios-arrow-down"></Icon>
              </Button>
              <DropdownMenu slot="list">
                <DropdownItem name="parent">添加顶级菜单</DropdownItem>
                <DropdownItem :disabled="!Boolean(selectNode.id)" name="children">添加子菜单</DropdownItem>
              </DropdownMenu>
            </Dropdown>
            <Button size="small" type="error" v-if="checkNodes.length > 0" @click="remove">
              <Icon type="ios-clipboard"/>
              批量删除
            </Button>
          </div>
          <Tree :data="data" show-checkbox @on-select-change="selectChange" :check-strictly="true"
                @on-check-change="checkChange"></Tree>
        </Card>
      </Col>
      <Col span="11" push="1">
        <Card>
          <div slot="title">{{ title }}</div>
          <transition name="slot-transition">
            <component v-if="componentProps.value" :is="componentProps.view" v-model="componentProps.value"
                       :props="componentProps.props" @on-refresh="getLists"></component>
          </transition>
        </Card>
      </Col>
    </Row>
  </IContent>
</template>

<script>
import IContent from "@/components/layout/IContent";
import IContentMixins from "@/mixins/iContentMixins"
import ICreate from './create'
import IUpdate from './update'

export default {
  name: "index",
  mixins: [IContentMixins],
  components: {
    ICreate, IUpdate,
    IContent
  },
  data() {
    return {
      title: '编辑菜单',
      data: [],
      selectNode: {},
      checkNodes: []
    }
  },
  methods: {
    createMenu(name) {
      switch (name) {
        case 'parent':
          this.openComponent('ICreate', {id: 0, title: '顶级菜单'});
          this.title = '添加顶级菜单';
          break;
        case 'children' :
          this.openComponent('ICreate', this.selectNode);
          this.title = '添加[' + this.selectNode.title + ']子菜单';
          break;
      }
    },
    remove() {
      this.loading = true;
      let nodes = this.checkNodes.map(val => val.id);
      this.$http.delete(`authorities/menu/${nodes.join('|')}`).then((res) => {
        this.getLists();
      }).finally(() => {
        this.loading = false
      });
    },
    getLists() {
      this.loading = true;
      this.$http.get(`authorities/menu`).then((data) => {
        this.data = this.setTreeData(data);
        this.checkNodes = [];
        this.selectNode = {};
      }).finally(() => {
        this.loading = false;
      });
    },
    selectChange(nodes, node) {
      this.closeComponent();
      if (nodes.length === 1) {
        this.openComponent('IUpdate', nodes[0]);
        this.title = '修改[' + nodes[0].title + ']菜单';
        this.selectNode = nodes[0];
      }
    },
    checkChange(nodes, node) {
      this.checkNodes = nodes;
    },
    setTreeData(source) {
      let cloneData = JSON.parse(JSON.stringify(source))
      let tree = cloneData.filter(father => {
        father.expand = true;
        let branchArr = cloneData.filter(child => {
          return father['id'] == child['parent_id']
        });
        if (branchArr.length > 0) {
          father['children'] = branchArr
        }
        return father['parent_id'] == 0
      })
      return tree
    }
  }
}
</script>

<style lang="less">
.wrapper-menu {
  display: flex;
  flex-flow: column;

  .remark {
    margin-bottom: 15px;
  }

  .cards {
    flex: 1;
    overflow: hidden;

    .dropdown-button {
      margin-right: 15px;
    }

    .ivu-col {
      height: 100%;

      .ivu-card {
        height: 100%;

        .ivu-card-body {
          height: calc(100% - 51px);
          overflow-y: auto;
        }
      }
    }
  }
}

</style>
