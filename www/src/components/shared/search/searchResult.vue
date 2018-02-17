<template>
  <article class="media" @click="goToArticle">
    <figure class="media-left">
      <p class="image is-32x32">
        <img src="https://bulma.io/images/placeholders/128x128.png">
      </p>
    </figure>
    <div class="media-content">
      <div class="content">
        <p>
          <strong>{{ data.products_name }}</strong>
        </p>
      </div>
    </div>
  </article>
</template>

<script>
export default {
  props: ['data'],
  methods: {
    goToArticle () {
      this.$router.push('product/1')
    }
  }
}
</script>

<style>

</style>
