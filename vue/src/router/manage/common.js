export const common = [

    {
        path: 'home',
        name: 'home',
        meta: {name: "首页", history: true},
        component: () => import('../../views/manage/index'),
    },
    {
        path: 'authorities.user',
        name: 'authorities.user',
        meta: {name: "用户管理", history: true},
        component: () => import('../../views/manage/authorities/user'),
    },
    {
        path: 'authorities.role',
        name: 'authorities.role',
        meta: {name: "角色管理", history: true},
        component: () => import('../../views/manage/authorities/role'),
    },
    {
        path: 'authorities.menu',
        name: 'authorities.menu',
        meta: {name: "菜单管理", history: true},
        component: () => import('../../views/manage/authorities/menu'),
    },
    {
        path: 'authorities.authority',
        name: 'authorities.authority',
        meta: {name: "权限管理", history: true},
        component: () => import('../../views/manage/authorities/authority'),
    },
    {
        path: 'profile',
        name: 'profile',
        meta: {name: "个人中心", history: true},
        component: () => import('../../views/manage/index/profile.vue'),
    }
];
