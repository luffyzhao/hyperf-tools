import Vue from 'vue'
import VueRouter from 'vue-router'
import $common from '../store';


Vue.use(VueRouter);


const router = new VueRouter();

const modules = document.head.querySelector("[property~='og:modules'][content]").content || null;
let commonModules = import(`./${modules}/index.js`);

/**
 *
 * @returns {string}
 * @constructor
 */
function GetRequest() {
    let str = location.href;
    let num = str.indexOf("#");
    str = str.substr(num + 1);
    return str;
}

const href = GetRequest();


commonModules.then((res) => {
    router.addRoutes(res.routes);
}).finally(() => {
    router.push({path: href});
});

router.beforeEach((to, from, next) => {
    let isLogin = Boolean($common.state.common.token);
    if (!Boolean(to.name) && isLogin) {
        next({name: '404'})
    } else if (!Boolean(to.name) && !isLogin) {
        next({name: '404'})
    } else {
        if (to.name === 'login' && isLogin) {
            next({name: 'home'})
        } else if (to.name !== 'login' && !isLogin) {
            next({name: 'login'})
        } else {
            $common.commit('common/setRouter', to);
            next()
        }
    }
});

export default router
