import Vue from 'vue'
import router from './router'
import store from './store'
import './registerServiceWorker'
import VueCookies from 'vue-cookies'
import axios from 'axios'
import VueAxios from 'vue-axios'
import ElementUI from 'element-ui';
import 'element-ui/lib/theme-chalk/index.css';
import App from './App.vue';

Vue.config.productionTip = false
Vue.use(VueCookies)
Vue.use(VueAxios, axios)
Vue.use(ElementUI);

new Vue({
  store,
  router,
  components: {App},
}).$mount('#my-app')