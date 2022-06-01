import Vue from 'vue'
import App from './App.vue'
import router from './router'
import store from './store'
import Http from './plugins/http'
import Cache from './plugins/cache'
import ViewUI from 'view-design'
import VueClipboard from 'vue-clipboard2'
import './assets/app.css'
import 'view-design/dist/styles/iview.css'
import vuePrint from '@theshy/vue-print'

Vue.config.productionTip = false;
Vue.use(Http);
Vue.use(Cache);
Vue.use(ViewUI);
Vue.use(VueClipboard);
Vue.use(vuePrint)

new Vue({
  router,
  store,
  render: h => h(App)
}).$mount('#app');
