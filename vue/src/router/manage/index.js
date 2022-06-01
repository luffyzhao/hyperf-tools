import {common} from "./common";
import {customer} from "./customer";
import {system} from "@/router/manage/system";

export const routes = [
    {
        path: '/',
        name: 'layout',
        component: () => import('../../views/Layout.vue'),
        redirect: 'home',
        children: [
            ...common,...customer
        ]
    },
    {
        path: '/404',
        name: '404',
        component: () => import('../../views/error/404.vue'),
    },{
        path: '/login',
        name: 'login',
        component: () => import('../../views/manage/login')
    }
];
