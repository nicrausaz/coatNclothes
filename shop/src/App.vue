<template>
  <div id="app">
    <navigator></navigator>
    <div class="container"><router-view/></div>
    <!-- <footbar></footbar> -->
  </div>
</template>

<script>
import navigator from '@/components/templates/navigator'
import footbar from '@/components/templates/footbar'
export default {
  name: 'app',
  components: {
    navigator,
    footbar
  }
}
</script>

<style lang="scss">
#app {
  font-family: 'Avenir', Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  padding-top: 50px;
}
// Import Bulma's core
@import "~bulma/sass/utilities/_all";

// Set your colors
$primary: #da0f68;
$primary-invert: findColorInvert($primary);

// Setup $colors to use as bulma classes (e.g. 'is-twitter')
$colors: (
    "white": ($white, $black),
    "black": ($black, $white),
    "light": ($light, $light-invert),
    "dark": ($dark, $dark-invert),
    "primary": ($primary, $primary-invert),
    "info": ($info, $info-invert),
    "success": ($success, $success-invert),
    "warning": ($warning, $warning-invert),
    "danger": ($danger, $danger-invert)
);

// Links
$link: $primary;
$link-invert: $primary-invert;
$link-focus-border: $primary;

// Import Bulma and Buefy styles
@import "~bulma";
@import "~buefy/src/scss/buefy";
</style>
