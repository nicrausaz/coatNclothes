<template>
  <nav class="navbar is-primary is-fixed-top">
    <div class="navbar-brand">
      <router-link to="/" class="navbar-item"><img src="/static/favicon.png"></router-link>
      <button class="button navbar-burger is-primary" @click="toggleMenu" :class="{'is-active': navIsActive}" data-target="navMenu">
        <span></span>
        <span></span>
        <span></span>
      </button>
    </div>

    <div class="navbar-menu" id="navMenu" :class="{'is-active': navIsActive}">
      <div class="navbar-start" @click="toggleMenu">
        <router-link to="/category/2" class="navbar-item"><b-icon icon="shopping-bag" style="padding-right: 5px;"></b-icon>{{$store.state.interface.shop}}</router-link>
      </div>
      <div class="navbar-end">
        <search></search>
        <div class="navbar-item has-dropdown is-hoverable">
          <a class="navbar-link">
            <b-icon icon="globe" style="padding-right: 5px;"></b-icon>
            <span>{{$store.state.interface.lang}}</span>
          </a>
          <div class="navbar-dropdown">
            <a class="navbar-item" :class="{'is-active': isLangSelected('fr')}" @click="$store.commit('setLanguage', 'fr')">Français</a>
            <a class="navbar-item" :class="{'is-active': isLangSelected('en')}" @click="$store.commit('setLanguage', 'en')">English</a>
          </div>
        </div>

        <router-link to="/wishlists" class="navbar-item"><b-icon icon="heart" style="padding-right: 5px;"></b-icon>{{$store.state.interface.wishlists}}</router-link>
        <router-link to="/shopbag" class="navbar-item" ><b-icon icon="shopping-cart" style="padding-right: 5px;"></b-icon>{{$store.state.interface.basket}}</router-link>
        <router-link to="/user" class="navbar-item" ><b-icon icon="user" style="padding-right: 5px;"></b-icon>{{$store.state.interface.yourProfile}}</router-link>
      </div>
    </div>
  </nav>
</template>

<script>
import search from '@/components/shared/search/search'

export default {
  data () {
    return {
      navIsActive: false
    }
  },
  methods: {
    toggleMenu () {
      this.navIsActive = !this.navIsActive
    },
    isLangSelected (lang) {
      return this.$store.state.language === lang
    }
  },
  components: {
    search
  }
}
</script>
