<template>
  <div class="container">
    <subtitle :name="'Panier'" :text="'Voir votre panier d\'achats'"></subtitle>
    <section class="section">
      <div v-if="!isShopBagEmpty" class="columns">
        <div class="columns column is-multiline is-three-quarter is-mobile">
          <shopBagProduct v-for="product in products" :key="product.products_id" :infos="product"></shopBagProduct>
        </div>
        <div class="column is-one-quarter">
          <sidebarShopbag :products="products"></sidebarShopbag>
        </div>
        <!-- <div class="content column is-one-quarter notification" id="summaryDiv">
          <h3>Résumé du panier:</h3>
          <small>{{ articlesNumberText }}</small>
          <ul>
            <li v-for="product in products" :key="product.products_id">{{ product.products_name }} {{ product.products_price }}</li>
          </ul>
          <hr>
          <p class="has-text-right">Prix total: {{totalPrice}} CHF</p>
        </div> -->
      </div>
      <div class="has-text-centered subtitle is-3" v-else>
        <b-icon icon="inbox" size="is-large"></b-icon>
        <p>Votre panier est vide ... Ajoutez-y des produits ! </p>
      </div>
    </section>
  </div>
</template>

<script>
import subtitle from '@/components/templates/subtitle'
import shopBagProduct from '@/components/shared/products/shopbagProduct'
import sidebarShopbag from '@/components/shared/products/sidebarShopbag'
import checkAccess from '@/mixins/checkAccess'

export default {
  mixins: [checkAccess],
  data () {
    return {
      products: [],
      loaded: false
    }
  },
  created () {
    this.axios({
      method: 'get',
      url: '/basket/user/' + this.$store.state.user.users_id
    })
    .then((response) => {
      this.products = response.data
      this.products = this.mergeDuplicate()
    })
  },
  methods: {
    mergeDuplicate () {
      // if product is multiple time, increment quantity and remove duplicates
      let compressed = []

      this.products.forEach((product) => {
        if (!(product.products_id in compressed)) {
          compressed[product.products_id] = { 'products_id': product.products_id, 'basket_quantity': product.basket_quantity }
        } else {
          compressed[product.products_id].basket_quantity += product.basket_quantity
        }
      })
      return compressed.filter((n) => { return n !== undefined })
    }
  },
  computed: {
    isShopBagEmpty () {
      return this.products.length === 0
    },
    articleNumber () {
      return this.products.length
    },
    articlesNumberText () {
      switch (this.articleNumber) {
        case 0:
          return 'Aucun article'
        case 1:
          return '1 article'
        default:
          return this.articleNumber + ' articles'
      }
    },
    totalPrice () {
      let totalPrice = 0
      this.products.forEach((product) => {
        totalPrice += product.products_price
      })
      return totalPrice
    }
  },
  components: {
    subtitle,
    shopBagProduct,
    sidebarShopbag
  }
}
</script>