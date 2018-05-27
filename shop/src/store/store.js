import Vue from 'vue'
import Vuex from 'vuex'
import createPersistedState from 'vuex-persistedstate'

Vue.use(Vuex)

const store = new Vuex.Store({
  strict: process.env.NODE_ENV !== 'production',
  plugins: [createPersistedState()],
  state: {
    language: 'fr',
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
    }
  }
})

export default store
