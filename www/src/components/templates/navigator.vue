<template>
  <nav class="navbar is-primary is-fixed-top">
    <div class="navbar-brand">
      <router-link to="/" class="navbar-item"><img src="https://bulma.io/images/bulma-logo.png" alt="" width="112" height="28"></router-link>
      <button class="button navbar-burger is-primary"  @click="createMobileMenu" data-target="navMenu">
        <span></span>
        <span></span>
        <span></span>
      </button >
    </div>

    <div class="navbar-menu" id="navMenu">
      <div class="navbar-start">
        <router-link to="/" class="navbar-item">Accueil</router-link>
        <div class="navbar-item has-dropdown is-hoverable">
          <a class="navbar-link">
            Catégories
          </a>
          <div class="navbar-dropdown is-boxed">
            <router-link to="/category/all" class="navbar-item">Toutes</router-link>
            <hr class="navbar-divider">
            <router-link v-for="category in categories" :key="category.id" :to="getCategoryRouteId(category.id)" class="navbar-item">{{category.label}}</router-link>
          </div>
        </div>
        <router-link to="/articles" class="navbar-item">Articles</router-link>
      </div>

      <div class="navbar-end">
        <router-link to="/wishlists" class="navbar-item" ><b-icon icon="heart" size="is-medium"></b-icon></router-link>
        <router-link to="/shopbag" class="navbar-item" ><b-icon icon="shopping-bag" size="is-medium"></b-icon></router-link>
        <router-link to="/user" class="navbar-item" ><b-icon icon="user" size="is-medium"></b-icon></router-link>
      </div>
    </div>
  </nav>
</template>

<script>
export default {
  data () {
    return {
      mobileMenuActive: false,
      categories: [
        { id: 0, name: 'tshirt', label: 'T-Shirt' },
        { id: 1, name: 'pulls', label: 'Pulls' },
        { id: 2, name: 'jeans', label: 'Jeans' },
        { id: 3, name: 'vestes', label: 'Vestes' }
      ]
    }
  },
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
    getCategoryRouteId (id) {
      return '/category/' + id
    }
  }
}
</script>
