<template>
<div class="column is-one-third">
  <div class="card">
    <div class="card-image" @click="isImageModalActive = true">
      <figure class="image is-square">
        <!-- <img :src="getImage(infos.product_picture)" alt="alt" draggable="false"> -->
        <img src="static/noImgAvailable.png" draggable="false">
      </figure>
    </div>
    <div class="card-content">
      <div class="media">
        <div class="media-content">
          <p class="title is-4">{{ infos.product_name }}test</p>
        </div>
      </div>

      <div class="content">
        {{infos.product_description}}
        test
      </div>
      <hr>
      <div class="btnZone">
        <router-link to="/product/1">
          <a class="button is-outlined is-large">
            <span class="icon">
              <i class="fa fa-info"></i>
            </span>
          </a>
        </router-link>
        <a class="button is-primary is-outlined is-large" @click="addToWishlist(infos.product_name)">
          <span class="icon">
            <i class="fa fa-heart"></i>
          </span>
        </a>
      </div>
    </div>
  </div>
  <b-modal :active.sync="isImageModalActive">
    <p class="image is-4by4">
      <img :src="getImage(infos.product_picture)">
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
      return picture === '' ? 'static/noImgAvailable.png' : picture
    }
  }
}
</script>

<style scoped>
.card {
  height: 500px;
  width: 250px;
}
.card-image {
  cursor: pointer;
}
.card:hover {
  box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
}
</style>