<template>
  <aside class="menu">
  <p class="menu-label">
    Genre
  </p>
  <ul class="menu-list">
    <li><a>Hommes</a></li>
    <li><a>Femmes</a></li>
  </ul>
  <p class="menu-label">
    Catégories
  </p>
  <ul class="menu-list">
    <li><a>Categorie 1</a></li>
    <li>
      <a class="is-active">Categorie 2</a>
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
