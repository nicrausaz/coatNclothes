import Vue from 'vue'
import Vuex from 'vuex'
import createPersistedState from 'vuex-persistedstate'

Vue.use(Vuex)

const store = new Vuex.Store({
  strict: process.env.NODE_ENV !== 'production',
  plugins: [createPersistedState()],
  state: {
    userToken: ''
  },
  mutations: {
    setUserToken (state, token) {
      this.state.userToken = token
    },
    detroyUserToken () {
      this.state.userToken = ''
    }
  }
})

export default store
