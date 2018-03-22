import Vue from 'vue'
import Vuex from 'vuex'
import createPersistedState from 'vuex-persistedstate'

Vue.use(Vuex)

const store = new Vuex.Store({
  strict: process.env.NODE_ENV !== 'production',
  plugins: [createPersistedState()],
  state: {
    user: {}
  },
  mutations: {
    setUser (state, user) {
      this.state.user = user
    },
    detroyUser () {
      this.state.user = {}
    }
  }
})

export default store
