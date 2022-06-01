export const system = [
    {
        path: 'system.dictionary',
        name: 'system.dictionary',
        meta: {name: "字典管理", history: true},
        component: () => import('../../views/manage/system/dictionary/index'),
    },
]