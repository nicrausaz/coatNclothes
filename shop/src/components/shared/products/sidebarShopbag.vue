<template>
  <aside class="menu">
    <p class="menu-label">{{$store.state.interface.summaryBasket}} - {{productsData.length}} {{$store.state.interface.items}}</p>
    <ul class="menu-list">
      <li v-for="(product, index) in productsData" :key="product.products_id">
        <a>
          <span class="has-text-left">{{products[index].basket_quantity}}x</span>
          <span class="has-text-centered">{{product.products_name}}</span>
          <span class="has-text-centered">{{products[index].fk_productsSize_id}}</span>
          <span class="has-text-right"><small>{{product.products_price}} CHF</small></span>
        </a>
      </li>
    </ul>
    <p class="menu-label has-text-right">{{totalPrice}}</p>
    <b-tooltip class="is-pulled-right" :label="$store.state.interface.chooseSizeAllProducts" position="is-bottom" :active="!validSizes">
      <router-link to="/orderconfirm">
        <button class="button is-primary is-large is-pulled-right" :disabled="!validSizes">{{$store.state.interface.order}}</button>
      </router-link>
    </b-tooltip>
  </aside>
</template>

<script>
export default {
  props: ['products'],
  data () {
    return {
      productsData: [],
      sizesValid: false
    }
  },
  watch: {
    products () {
      this.productsData = []
      this.getProductData()
    }
  },
  created () {
    this.getProductData()
  },
  methods: {
    getProductData () {
      this.products.forEach(product => {
        this.axios({
          method: 'get',
          url: 'product/' + product.products_id
        })
        .then((response) => {
          this.productsData.push(response.data)
        })
      })
    }
  },
  computed: {
    totalPrice () {
      let total = 0
      this.productsData.forEach((product, i) => {
        total += this.products[i].basket_quantity * product.products_price
      })
      return this.$store.state.interface.total + ' ' + total + ' CHF'
    },
    articlesNumberText () {
      // DEPRECATED
      switch (this.productsData.length) {
        case 0:
          return 'Aucun article'
        case 1:
          return '1 article'
        default:
          return this.productsData.length + ' articles'
      }
    },
    validSizes () {
      let valid = []
      this.products.forEach(product => {
        if (product.fk_productsSize_id === null) {
          valid.push('empty')
        }
      })
      return valid.length === 0
    }
  }
}
</script>
