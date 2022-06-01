import {$cache} from '../../plugins/cache';
import router from "../../router";


let state = {
    token: null,
    menus: [],
    usedRouter: []
};

let mutations = {
    // 设置token
    setToken(state, token) {
        state.token = token;
        $cache.set('$store/auth/token', token);
        router.push({name: 'home'});
    },
    setMenus(state, menus) {
        state.menus = menus;
        $cache.set('$store/auth/menus', menus);
    },
    setRouter(state, {name, meta}) {
        if (meta && meta.history) {
            let index = state.usedRouter.findIndex((val) => val.name === name);
            if (index === -1) {
                state.usedRouter.unshift({name, meta});
            }
            $cache.set('$store/auth/usedRouter', state.usedRouter);
        }
    },
    logout(state) {
        $cache.clear();
        state.token = null;
        state.menus = [];
        state.usedRouter = [];
        if (router.currentRoute.name !== 'login') {
            router.push({name: 'login'});
        }
    }
};

state.token = $cache.get('$store/auth/token') || null;
state.menus = $cache.get('$store/auth/menus') || [];
state.usedRouter = $cache.get('$store/auth/usedRouter') || [];

export default {
    namespaced: true,
    state,
    mutations
}
