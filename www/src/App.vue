<template>
  <div id="app">
    <navigator></navigator>
    <div class="container"><router-view/></div>
    <footbar></footbar>
  </div>
</template>

<script>
import navigator from '@/components/templates/navigator'
import sidebar from '@/components/templates/sidebar'
import footbar from '@/components/templates/footbar'
export default {
  name: 'app',
  components: {
    navigator,
    sidebar,
    footbar
  }
}
</script>

<style>
#app {
  font-family: 'Avenir', Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  padding-top: 50px;
}
</style>
