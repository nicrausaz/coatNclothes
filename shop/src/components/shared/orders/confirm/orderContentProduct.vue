<template>
  <div class="card column is-6">
  <article class="media">
    <figure class="media-left">
      <p class="image is-64x64">
        <img :src="picture" :alt="altName" draggable="false">
      </p>
    </figure>
    <div class="media-content">
      <strong>{{ product.products_name }}</strong> <small>20 CHF</small>
    </div>
  </article>
</div>
</template>

<script>
export default {
  props: ['data'],
  data () {
    return {
      product: {},
      loaded: false
    }
  },
  created () {
    this.axios({
      method: 'get',
      url: 'product/' + this.data.products_id
    })
    .then((response) => {
      this.product = response.data
      this.loaded = true
    })
  },
  computed: {
    picture () {
      if (this.loaded) {
        return this.product.products_pictures[0].path || 'static/noImgAvailable.png'
      }
    },
    altName (altName) {
      if (this.loaded) {
        return this.product.products_pictures[0].altName || 'noimg'
      }
    }
  }
}
</script>

<style scoped>
.card {
  height: 100px;
}
img {
  max-height: 70px;
}
</style>
