import Vue from 'vue'
import Vuex from 'vuex'
import createPersistedState from 'vuex-persistedstate'

Vue.use(Vuex)

const store = new Vuex.Store({
  strict: process.env.NODE_ENV !== 'production',
  plugins: [createPersistedState()],
  state: {
    language: 'fr',
    tokenExpirationDate: null,
    interface: [],
    user: {}
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
    }
  }
})

export default store
