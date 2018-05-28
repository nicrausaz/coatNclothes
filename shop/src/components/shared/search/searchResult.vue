<template>
  <article class="media" @click="goToArticle" style="cursor: pointer;">
    <figure class="media-left">
      <p class="image is-32x32">
        <img :src="picture" :alt="altName">
      </p>
    </figure>
    <div class="media-content">
      <div class="content">
        <p>
          <strong>{{ data.products_name }}</strong>
          <small>{{ data.products_price }} CHF</small>
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
      this.$router.push('/product/' + this.data.products_id)
    }
  },
  computed: {
    picture () {
      return this.data.productsPics_path === null ? '/static/noImgAvailable.png' : this.data.productsPics_path
    },
    altName (altName) {
      return this.data.productsPics_altName === null ? 'noimg' : this.data.productsPics_altName
    }
  }
}
</script>
