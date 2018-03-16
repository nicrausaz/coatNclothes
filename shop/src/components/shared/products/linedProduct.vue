<template>
<div class="card">
  <article class="media">
    <figure class="media-left" @click="isImageModalActive = true">
      <p class="image is-64x64">
        <img :src="getImage(infos.productsPics_path)" :alt="infos.productsPics_altName" draggable="false">
      </p>
    </figure>
    <div class="media-content">
      <div class="content">
        <p>
          <strong>{{ infos.products_name }}</strong> <small>20 CHF</small>
          <br>
          Description
        </p>
      </div>
      <nav class="level is-mobile">
        <div class="level-left">
          <button class="button is-outlined is-small">
            <b-icon icon="info" size="is-small"></b-icon>
          </button>
          <button class="button is-outlined is-small" @click="addToWishlist(infos.products_name)">
            <b-icon icon="heart" size="is-small"></b-icon>
          </button>
        </div>
      </nav>
    </div>
  </article>

  <b-modal :active.sync="isImageModalActive">
    <p class="image is-4by4">
      <img :src="getImage(infos.productsPics_path)">
    </p>
  </b-modal>
</div>
</template>

<script>
export default {
  props: ['infos'],
  data () {
    return {
      isImageModalActive: false
    }
  },
  methods: {
    addToBasket (product) {
      this.$toast.open(product + ' ajouté au panier!')
    },
    addToWishlist (product) {
      this.$toast.open(product + ' ajouté au la liste de souhait: test!')
    },
    getImage (picture) {
      console.log(picture)
      return picture === '' ? 'static/noImgAvailable.png' : picture
    }
  }
}
</script>

<style scoped>
.card {
  padding: 10px;
  margin-bottom: 10px;
}
.box:hover {
  box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
}
.media-left {
  cursor: pointer;
}
</style>

