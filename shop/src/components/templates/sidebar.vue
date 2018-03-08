<template>
  <div class="notification">
    <div class="content">
      <router-link to="">
        Catégorie choisie
      </router-link>
      <ul>
        <li><router-link to=""> Sous catégorie 1</router-link></li>
      </ul>
    </div>
  </div>
</template>

<script>
export default {

}
</script>

<style scoped>
.notification {
  margin-top: 10px;
}
ul {
  list-style-type: none;
}
</style>
