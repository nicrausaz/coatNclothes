<template>
  <div class="card" @click.stop="showProduct">
    <article class="media">
      <figure class="media-left">
        <p class="image is-64x64">
          <img :src="picture" :alt="altName" draggable="false">
        </p>
      </figure>
      <div class="media-content">
        <strong>{{ infos.products_name }}</strong> <small>{{infos.products_price}} CHF</small>
        <nav class="level is-mobile">
          <div class="media-right">
            <button class="button is-primary is-outlined is-small" @click.stop="addToBasket" style="margin-top: 10px;">
              <b-icon icon="shopping-cart" size="is-small"></b-icon>
              <span>Ajouter</span>
            </button>
          </div>
        </nav>
      </div>
    </article>
  </div>
</template>

<script>
import productshelpers from '@/mixins/productsHelpers'

export default {
  props: ['infos'],
  mixins: [productshelpers],
  computed: {
    picture () {
      return this.infos.productsPics_path || 'static/noImgAvailable.png'
    },
    altName (altName) {
      return this.infos.productsPics_altName || 'noimg'
    }
  },
  methods: {
    addToBasket () {
      this.addProductToBasket(this.infos.products_id)
    },
    showProduct () {
      this.$router.push('/product/' + this.infos.products_id)
    }
  }
}
</script>

<style scoped>
.card {
  padding: 10px;
  margin-bottom: 10px;
  cursor: pointer;
}
.box:hover {
  box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
}
img {
  max-height: 60px;
}
</style>

