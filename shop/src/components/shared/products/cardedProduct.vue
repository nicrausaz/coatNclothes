<template>
  <div class="column is-one-quarter">
    <div class="card" @mouseover="hover = true" @mouseout="hover = false">
      <div class="card-image" @click="isImageModalActive = true">
        <figure class="image is-square">
          <img :src="picture" :alt="altName" draggable="false">
        </figure>
      </div>
      <div class="card-content">
        <div class="media description">
          <div class="media-content">
            <ul>
              <li>{{ infos.products_name }}</li>
              <li class="has-text-right">
                <small>{{infos.products_price}} CHF</small>
              </li>
            </ul>
          </div>
        </div>
        <div v-if="hover">
          <router-link :to="/product/ + infos.products_id">
            <button class="button is-outlined">
              <b-icon icon="info" size="is-small"></b-icon>
            </button>
          </router-link>
          <button class="button is-primary is-outlined" @click="addToBasket">
            <b-icon icon="shopping-cart" size="is-small"></b-icon>
          </button>
        </div>
      </div>
    </div>
    <b-modal :active.sync="isImageModalActive">
      <p class="image is-4by4">
        <img :src="picture">
      </p>
    </b-modal>
  </div>
</template>

<script>
export default {
  props: ['infos'],
  data () {
    return {
      isImageModalActive: false,
      hover: false
    }
  },
  methods: {
    addToBasket () {
      // add item to basket
    }
  },
  computed: {
    picture () {
      return this.infos.productsPics_path === null ? 'static/noImgAvailable.png' : this.infos.productsPics_path
    },
    altName (altName) {
      return this.infos.productsPics_altName === null ? 'noimg' : this.infos.productsPics_altName
    }
  }
}
</script>

<style scoped>
.card {
  height: 350px;
  width: 200px;
}
.card-image {
  cursor: pointer;
}
.card:hover {
  box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
}
.description {
  padding-bottom: 50px;
  max-height: 60px;
}
</style>