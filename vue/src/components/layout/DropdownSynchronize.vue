<template>
        <div v-if="children.children.length === 0" @click="topChange(children)" >
            <Icon :type="children.icon"></Icon> {{children.title}}
        </div>
        <Dropdown v-else :placement="placement" class="menu-box">
            <div >
                <Icon :type="children.icon"></Icon>
                {{children.title}}
                <Icon :type="icon"></Icon>
            </div>
            <DropdownMenu slot="list">
                <DropdownItem v-for="(v, k) in children.children" :key="k" :selected="v.name===$route.name" class="menu-item">
                    <DropdownSynchronize :children="v"></DropdownSynchronize>
                </DropdownItem>
            </DropdownMenu>
        </Dropdown>
</template>

<script>
export default {
    name: "DropdownSynchronize",
    props: {
        children: {
            type: Object,
            default: () => {},
            required: true
        },
        placement:{
            type:String,
            default: 'right-start'
        },
        icon: {
            type:String,
            default: 'ios-arrow-forward'
        }
    },
    methods: {
        topChange(item) {
            if(item.children.length === 0){
                if (this.$route.name !== item.name) this.$router.push({name: item.name});
            }
        }
    }
}
</script>

<style scoped>
.menu-item{
    min-width: 150px;
}
</style>
