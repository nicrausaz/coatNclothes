<template>
  <nav class="navbar is-primary">
  <div class="navbar-brand">
     <router-link to="/" class="navbar-item"><img src="https://bulma.io/images/bulma-logo.png" alt="" width="112" height="28"></router-link>
    <div class="navbar-burger burger" data-target="">
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
      <div class="navbar-item">
        <div class="field is-grouped">
          <p class="control">
            <a class="bd-tw-button button">
              <router-link to="/wishlist" class="navbar-item">
              <span class="icon">
                <i class="fa fa-heart"></i>
              </span>
              </router-link>
            </a>
          </p>
          <p class="control">
            <a class="bd-tw-button button">
              <router-link to="/shopbag" class="navbar-item">
              <span class="icon">
                <i class="fa fa-shopping-bag"></i>
              </span>
              </router-link>
            </a>
          </p>
          <p class="control" slot="trigger">
            <a class="bd-tw-button button" >
              <router-link to="/user" class="navbar-item">
              <span class="icon">
                <i class="fa fa-user"></i>
              </span>
              </router-link>
            </a>
          </p>
        </div>
      </div>
    </div>
  </div>
</nav>
</template>

<script>
export default {
  data () {
    return {
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
