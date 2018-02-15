<template>
  <nav class="navbar is-primary is-fixed-top">
    <div class="navbar-brand">
      <router-link to="/" class="navbar-item"><img src="static/favicon.png"></router-link>
      <button class="button navbar-burger is-primary" @click="createMobileMenu" data-target="navMenu">
        <span></span>
        <span></span>
        <span></span>
      </button>
    </div>

    <div class="navbar-menu" id="navMenu" @click="closeMobileMenu">
      <div class="navbar-start">
        <router-link to="/" class="navbar-item">Accueil</router-link>
        <router-link to="/categories" class="navbar-item">Catégories</router-link>
        <router-link to="/products" class="navbar-item">products</router-link>
      </div>

      <div class="navbar-end">
        <search></search>
        <router-link to="/wishlists" class="navbar-item" ><b-icon icon="heart" size="is-medium"></b-icon></router-link>
        <router-link to="/shopbag" class="navbar-item" ><b-icon icon="shopping-bag" size="is-medium"></b-icon></router-link>
        <router-link to="/user" class="navbar-item" ><b-icon icon="user" size="is-medium"></b-icon></router-link>
      </div>
    </div>
  </nav>
</template>

<script>
import search from '@/components/shared/search'

export default {
  methods: {
    createMobileMenu () {
      let navbarBurgers = Array.prototype.slice.call(document.querySelectorAll('.navbar-burger'), 0)
      if (navbarBurgers.length > 0) {
        navbarBurgers.forEach(function (el) {
          let target = el.dataset.target
          let $target = document.getElementById(target)
          el.classList.toggle('is-active')
          $target.classList.toggle('is-active')
        })
      }
    },
    closeMobileMenu () {},
    getCategoryRouteId (id) {
      return '/category/' + id
    }
  },
  components: {
    search
  }
}
</script>
