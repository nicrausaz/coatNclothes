<template>
  <aside class="menu">
  <p class="menu-label">
    Genre
  </p>
  <ul class="menu-list">
    <li><router-link to="/category/6">Hommes</router-link></li>
    <li><router-link to="/category/1">Femmes</router-link></li>
  </ul>
  <p class="menu-label">
    Catégories
  </p>
  <ul class="menu-list">
    <li><router-link to="/category/5">5</router-link></li>
    <li>
      <router-link class="is-active" to="/category/2">2</router-link>
      <ul>
        <li><a>Sous cat 1</a></li>
        <li><a>Sous cat 2</a></li>
        <li><a>Sous cat 3</a></li>
      </ul>
    </li>
    <li><a>Categorie 3</a></li>
  </ul>
</aside>
</template>

<script>
export default {

}
</script>

<style scoped>
.menu {
  margin-top: 30px;
}
</style>
