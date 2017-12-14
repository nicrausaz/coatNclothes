<template>
<div class="column is-one-quarter">
  <div class="card">
    <div class="card-image">
      <figure class="image is-square">
        <img src="https://bulma.io/images/placeholders/1280x960.png" alt="alt" draggable="false">
      </figure>
    </div>
    <div class="card-content">
      <div class="media">
        <div class="media-content">
          <p class="title is-4">{{ infos.product_name }}</p>
        </div>
      </div>

      <div class="content">
        {{infos.product_description}}
      </div>
      <hr>
      <div class="btnZone">
        <a class="button is-primary is-outlined is-large" @click="addToWishlist(infos.product_name)">
          <span class="icon">
            <i class="fa fa-heart"></i>
          </span>
        </a>
        <a class="button is-danger is-outlined is-large" @click="addToBasket(infos.product_name)">
          <span class="icon">
            <i class="fa fa-cart-plus"></i>
          </span>
        </a>
      </div>
    </div>
  </div>
</div>
</template>

<script>
export default {
  props: ['infos'],
  methods: {
    addToBasket (article) {
      this.$toast.open(article + ' ajouté au panier!')
    },
    addToWishlist (article) {
      this.$toast.open(article + ' ajouté au la liste de souhait: test!')
    }
  }
}
</script>

<style scoped>
.card {
  height: 600px;
}

.card:hover {
  box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
}
</style>