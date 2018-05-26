// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
import Vue from 'vue'
import App from './App'

import router from './router'
import Vuex from 'vuex'
import store from './store/store.js'
import axios from 'axios'
import VueAnalytics from 'vue-analytics'

import Buefy from 'buefy'
import VueCarousel from 'vue-carousel'

import Chartkick from 'chartkick'
import VueChartkick from 'vue-chartkick'

Vue.use(Buefy, {
  defaultIconPack: 'fas'
})

Vue.use(VueCarousel)
Vue.use(Vuex)
Vue.use(VueChartkick, { Chartkick })

Vue.use(VueAnalytics, {
  id: 'UA-119016799-1'
})

Vue.config.productionTip = false

Vue.prototype.axios = axios.create({
  baseURL: 'https://api.coatandclothes.shop/' + store.state.language,
  headers: {
    'Authorization': 'Bearer' + store.state.user.token
  }
})

/* eslint-disable no-new */
new Vue({
  el: '#app',
  router,
  store: store,
  template: '<App/>',
  components: { App }
})
