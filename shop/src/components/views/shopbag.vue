<template>
  <div class="container">
    <subtitle :name="'Panier'" :text="'Voir votre panier d\'achats'"></subtitle>
    <section class="section">
      <div v-if="!isShopBagEmpty" class="columns">
        <div class="columns column is-multiline is-three-quarter is-mobile">
          <shopBagProduct v-for="product in products" :key="product.products_id" :infos="product" @delete="getBasket"></shopBagProduct>
        </div>
        <div class="column is-one-quarter">
          <sidebarShopbag :products="products" :number="articlesNumberText"></sidebarShopbag>
        </div>
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
    this.getBasket()
  },
  methods: {
    getBasket () {
      this.axios({
        method: 'get',
        url: '/basket/user/' + this.$store.state.user.users_id
      })
      .then((response) => {
        this.products = response.data
      })
    }
  },
  computed: {
    isShopBagEmpty () {
      return this.products.length === 0
    },
    articlesNumberText () {
      switch (this.products.length) {
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