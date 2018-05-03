<template>
  <aside class="menu">
    <p class="menu-label">Résumé du panier - {{articlesNumberText}}</p>
    <ul class="menu-list">
      <li v-for="(product, index) in productsData" :key="product.products_id">
        <a>
          <span class="has-text-left">{{products[index].basket_quantity}}x</span>
          <span class="has-text-centered">{{product.products_name}}</span>
          <span class="has-text-right"><small>{{product.products_price}} CHF</small></span>
        </a>
      </li>
    </ul>
    <p class="menu-label has-text-right">{{totalPrice}}</p>
    <b-tooltip class="is-pulled-right" label="Choisissez une taille pour tous les articles" position="is-bottom" :active="!canconfirm">
      <router-link to="/orderconfirm">
        <button class="button is-primary is-large is-pulled-right" :disabled="!canconfirm">Commander</button>
      </router-link>
    </b-tooltip>
  </aside>
</template>

<script>
export default {
  props: ['products', 'number', 'canconfirm'],
  data () {
    return {
      productsData: []
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
      return 'Total ' + total + ' CHF'
    },
    articlesNumberText () {
      switch (this.productsData.length) {
        case 0:
          return 'Aucun article'
        case 1:
          return '1 article'
        default:
          return this.productsData.length + ' articles'
      }
    }
  }
}
</script>
