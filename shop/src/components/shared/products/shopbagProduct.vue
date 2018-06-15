<template>
  <div class="column is-one-third">
    <div class="card">
      <button class="delete" @click="removeProductFromShopBag"></button>
      <div class="card-image" @click="$router.push('/product/' + product.products_id)">
        <figure class="image is-square">
          <img :src="picture" :alt="altName" draggable="false">
        </figure>
      </div>
        <div class="card-content notification">
          <div class="media">
            <div class="media-content">
              <ul>
                <li><small>{{product.products_brand}}</small></li>
                <li><b>{{product.products_name}}</b></li>
                <li class="has-text-right">{{formatedprice}}</li>
              </ul>
            </div>
          </div>
        </div>
        <div class="actions columns">
          <div class="column">
            <b-select :placeholder="$store.state.interface.size" v-model="infos.fk_productsSize_id" style="padding-left: 5px;">
              <option v-for="size in product.products_size" :key="size">
                {{ size }}
              </option>
            </b-select>
          </div>
          <div class="column">
            <div class="has-text-centered">
              <button class="button is-small is-primary is-outlined" :disabled="!isEnabledMin" @click="decrement">
                <b-icon icon="minus" size="is-small"></b-icon>
              </button>
                <b>{{infos.basket_quantity}}</b>
              <button class="button is-small is-primary is-outlined" :disabled="!isEnabledMax" @click="increment">
                <b-icon icon="plus" size="is-small"></b-icon>
              </button>
            </div>
          </div>
        </div>
    </div>
  </div>
</template>

<script>
export default {
  props: ['infos'],
  data () {
    return {
      product: [],
      loaded: false
    }
  },
  watch: {
    'infos.fk_productsSize_id' () { this.updateBasket() }
  },
  created () {
    this.axios({
      method: 'get',
      url: 'product/' + this.infos.products_id
    })
    .then((response) => {
      this.product = response.data
      this.loaded = true
    })
  },
  computed: {
    picture () {
      if (this.loaded) {
        return this.product.products_pictures.length === 0 ? '/static/noImgAvailable.png' : this.product.products_pictures[0].path
      }
    },
    altName () {
      if (this.loaded) {
        return this.product.products_pictures.length === 0 ? 'noImg' : this.product.products_pictures[0].altName
      }
    },
    isEnabledMin () {
      return this.infos.basket_quantity > 1
    },
    isEnabledMax () {
      return this.infos.basket_quantity < 30
    },
    formatedprice () {
      return this.product.products_price + ' CHF'
    }
  },
  methods: {
    decrement () {
      this.infos.basket_quantity -= 1
      this.updateBasket()
    },
    increment () {
      this.infos.basket_quantity += 1
      this.updateBasket()
    },
    updateBasket () {
      this.axios({
        method: 'patch',
        url: '/basket/user/' + this.$store.state.user.users_id,
        data: {
          'basketItemID': this.infos.basket_id,
          'size': this.infos.fk_productsSize_id,
          'quantity': this.infos.basket_quantity
        }
      })
      .catch((err) => { this.dangerToast(err.response.data) })
    },
    removeProductFromShopBag () {
      this.axios({
        method: 'delete',
        url: '/basket/user/' + this.$store.state.user.users_id,
        data: {
          'product': this.infos.products_id
        }
      })
      .then(response => {
        this.defaultToast(response.data.message)
        this.$store.dispatch('getShopbagQuantity')
        this.$emit('delete')
      })
    }
  }
}
</script>

<style scoped>
.card {
  height: 390px;
  width: 200px;
  margin-bottom: 10px;
}
.card-image {
  cursor: pointer;
}
.card:hover {
  box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
}
.delete {
  position: absolute;
  margin: 5px;
  z-index: 1;
}
.notification {
  padding-top: 15px;
  margin-bottom: 10px;
  height: 135px;
}
</style>