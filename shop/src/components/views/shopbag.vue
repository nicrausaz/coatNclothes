<template>
  <div class="container">
    <subtitle :name="'Panier'" :text="'Voir votre panier d\'achats'"></subtitle>
    <section class="section">
      <div v-if="!isShopBagEmpty" class="columns">
        <div class="columns is-multiline is-three-quarter">
          <shopBagProduct v-for="product in products" :key="product.products_id" :infos="product"></shopBagProduct>
        </div>
        <div class="content column is-one-quarter notification" id="summaryDiv">
          <h3>Résumé du panier:</h3>
          <small>{{ articlesNumberText }}</small>
          <ul>
            <li v-for="product in products" :key="product.products_id">{{ product.products_name }} {{ product.products_price }}</li>
          </ul>
          <hr>
          <p class="has-text-right">Prix total: {{totalPrice}}</p>
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
import shopBagProduct from '@/components/shared/products/shopbagproduct'
import checkAccess from '@/mixins/checkAccess'

export default {
  mixins: [checkAccess],
  data () {
    return {
      products: []
    }
  },
  created () {
    this.axios({
      method: 'get',
      url: '/products'
    })
    .then((response) => {
      this.products = response.data
    })
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
        totalPrice += product.products_price // will work when data will be on good format
      })
      return totalPrice
    }
  },
  components: {
    subtitle,
    shopBagProduct
  }
}
</script>