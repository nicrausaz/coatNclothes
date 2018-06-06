import Vue from 'vue'
import Vuex from 'vuex'
import axios from 'axios'
import createPersistedState from 'vuex-persistedstate'

Vue.use(Vuex)

const store = new Vuex.Store({
  strict: process.env.NODE_ENV !== 'production',
  plugins: [createPersistedState()],
  state: {
    language: 'fr',
    tokenExpirationDate: null,
    interface: [],
    user: {},
    shopbagQuantity: ''
  },
  mutations: {
    setUser (state, user) {
      this.state.user = user
    },
    setInterfaceTranslation (state, translation) {
      this.state.interface = translation
    },
    detroyUser () {
      this.state.user = {}
    },
    setLanguage (state, lang) {
      this.state.language = lang
      location.reload()
    },
    setTokenExpirationDate (state) {
      let now = Date.now()
      if (this.state.tokenExpirationDate < now) {
        this.state.tokenExpirationDate = now + 86400000
      }
    },
    setShopbagQuantity (state, quantity) {
      this.state.shopbagQuantity = quantity
    }
  },
  actions: {
    getShopbagQuantity (context) {
      if (this.state.user.users_id) {
        axios({
          method: 'get',
          url: 'https://api.coatandclothes.shop/' + this.state.language + '/basket/user/' + this.state.user.users_id + '/count',
          headers: {
            'Authorization': 'Bearer' + this.state.user.token
          }
        })
        .then(response => {
          let value = '(' + response.data + ')'
          context.commit('setShopbagQuantity', value)
        })
      } else {
        context.commit('setShopbagQuantity', null)
      }
    }
  }
})

export default store
