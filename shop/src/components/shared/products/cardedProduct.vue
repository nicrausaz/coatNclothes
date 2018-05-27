<template>
  <div class="column is-one-quarter">
    <div class="card" @click.stop="showProduct">
      <div class="card-image">
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
                <small><b>{{infos.products_price}} CHF</b></small>
              </li>
            </ul>
          </div>
        </div>
        <b-tooltip :label="$store.state.interface.addToBasket" position="is-bottom">
          <button class="button is-primary is-outlined" @click.stop="addToBasket" style="margin-top: 10px;">
            <b-icon icon="shopping-cart" size="is-small"></b-icon>
            <span>{{$store.state.interface.add}}</span>
          </button>
        </b-tooltip>
      </div>
    </div>
  </div>
</template>

<script>
import productshelpers from '@/mixins/productsHelpers'

export default {
  props: ['infos'],
  mixins: [productshelpers],
  data () {
    return {
      hover: false
    }
  },
  methods: {
    addToBasket () {
      this.addProductToBasket(this.infos.products_id)
    },
    showProduct () {
      this.$router.push('/product/' + this.infos.products_id)
    }
  },
  computed: {
    picture () {
      return this.infos.productsPics_path || 'static/noImgAvailable.png'
    },
    altName (altName) {
      return this.infos.productsPics_altName || 'noimg'
    }
  }
}
</script>

<style scoped>
.card {
  height: 350px;
  width: 200px;
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