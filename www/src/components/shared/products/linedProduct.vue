<template>
  <div class="box">
  <!-- <product class="media"> -->
    <div class="media-left" @click="isImageModalActive = true">
      <figure class="image is-64x64">
        <img :src="getImage(infos.product_picture)" draggable="false">
      </figure>
    </div>
    <div class="media-content">
      <div class="content">
        <p>
          <strong>{{ infos.product_name }}</strong>
          <br>
          {{infos.product_description}}
        </p>
      </div>
      <nav class="level is-mobile">
        <div class="level-left">
          <a class="level-item">
            <b-icon icon="heart" size="is-small" @click="addToWishlist(infos.product_name)"></b-icon>
          </a>
        </div>
      </nav>
    </div>
  <!-- </product> -->
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
      return picture === '' ? 'https://bulma.io/images/placeholders/1280x960.png' : picture
    }
  }
}
</script>

<style scoped>
.box:hover {
  box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
}
.media-left {
  cursor: pointer;
}
</style>

