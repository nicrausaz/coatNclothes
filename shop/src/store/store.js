import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

const store = new Vuex.Store({
  strict: process.env.NODE_ENV !== 'production',
  state: {
    userToken: ''
  },
  mutations: {
    setUserToken (token) {
      this.state.userToken = token
    }
  }
})

export default store
