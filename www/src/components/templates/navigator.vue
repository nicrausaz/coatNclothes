<template>
  <nav class="navbar is-primary is-fixed-top">
  <div class="navbar-brand">
     <router-link to="/" class="navbar-item"><img src="https://bulma.io/images/bulma-logo.png" alt="" width="112" height="28"></router-link>
    <div class="navbar-burger burger" :class="{'is-active': mobileMenuActive}" @click="mobileMenuActive = !mobileMenuActive" data-target="">
      <span></span>
      <span></span>
      <span></span>
    </div>
  </div>

  <div class="navbar-menu">
    <div class="navbar-start">
      <router-link to="/" class="navbar-item">Acceuil</router-link>
      <div class="navbar-item has-dropdown is-hoverable">
        <a class="navbar-link">
          Catégories
        </a>
        <div class="navbar-dropdown is-boxed">
          <router-link to="/category/all" class="navbar-item">Toutes</router-link>
          <hr class="navbar-divider">
          <router-link v-for="category in categories" :key="category.id" to="/category/1" class="navbar-item">{{category.label}}</router-link>
        </div>
      </div>
      <router-link to="/articles" class="navbar-item">Articles</router-link>
    </div>

    <div class="navbar-end">
      <router-link to="/wishlists" class="navbar-item" ><b-icon pack="fa" icon="heart" size="is-medium"></b-icon></router-link>
      <router-link to="/shopbag" class="navbar-item" ><b-icon pack="fa" icon="shopping-bag" size="is-medium"></b-icon></router-link>
      <router-link to="/user" class="navbar-item" ><b-icon pack="fa" icon="user" size="is-medium"></b-icon></router-link>
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
  }
}
</script>
