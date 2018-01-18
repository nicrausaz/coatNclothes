// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
import Vue from 'vue'
import App from './App'
import router from './router'
import axios from 'axios'
import Buefy from 'buefy'
import 'buefy/lib/buefy.css'
import VueCarousel from 'vue-carousel'

Vue.use(Buefy, {
  defaultIconPack: 'fa'
})

Vue.use(VueCarousel)

Vue.config.productionTip = false

Vue.prototype.axios = axios.create({
  baseURL: 'http://api.coatandclothes.shop:8090'
})

/* eslint-disable no-new */
new Vue({
  el: '#app',
  router,
  template: '<App/>',
  components: { App }
})
