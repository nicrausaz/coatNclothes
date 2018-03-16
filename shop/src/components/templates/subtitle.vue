<template>
  <section class="hero is-small is-light">
  <div class="hero-body">
    <div class="container">
      <h1 class="title">{{ name }}</h1>
      <h2 class="subtitle">{{ text }}</h2>
    </div>
  </div>
</section>
</template>

<script>
export default {
  props: ['name', 'text']
}
</script>

<style>

</style>
