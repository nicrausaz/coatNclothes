<template>
  <div class="column is-12">
    <div v-for="product in products" :key="product.fk_products_id">
      <article class="media">
        <figure class="media-left">
          <p class="image is-64x64">
            <img :src="getPicture(product.fullData.products_pictures)" :alt="getAltName(product.fullData.products_pictures)">
          </p>
        </figure>
        <div class="media-content">
          <strong>{{ product.fullData.products_name }}</strong> <small>{{ product.fullData.products_price }} CHF</small>
          <br>
          Taille: {{product.productsSize_value}}
        </div>
        <b>{{product.ordersContent_quantity}}x</b>
      </article>
    </div>
  </div>
</template>

<script>
export default {
  props: ['orderId'],
  data () {
    return {
      productsData: [],
      products: [],
      loaded: false
    }
  },
  created () {
    this.getOrderProducts()
  },
  methods: {
    getProduct (id, size, quantity) {
      this.axios({
        method: 'get',
        url: 'product/' + id
      })
      .then(response => {
        this.products.push({
          fullData: response.data,
          productsSize_value: size,
          ordersContent_quantity: quantity
        })
        this.loaded = true
      })
    },
    getOrderProducts () {
      this.axios({
        method: 'get',
        url: 'order/' + this.orderId
      })
      .then((response) => {
        this.productsData = response.data
        this.productsData.forEach(product => {
          this.getProduct(product.fk_products_id, product.productsSize_value, product.ordersContent_quantity)
        })
      })
    },
    getPicture (pictures) {
      if (this.loaded) {
        return pictures.length === 0 ? '/static/noImgAvailable.png' : pictures[0].path
      }
    },
    getAltName (pictures) {
      if (this.loaded) {
        return pictures.length === 0 ? 'noimg' : pictures[0].altName
      }
    }
  }
}
</script>

<style scoped>
.media {
  border: none;
  margin: 0px;
  padding-left: 20px;
}
img {
  max-height: 60px;
}
</style>
