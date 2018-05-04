<template>
  <div class="container">
    <subtitle :name="'Panier'" :text="'Voir votre panier d\'achats'"></subtitle>
    <section class="section">
      <div v-if="!isShopBagEmpty" class="columns">
        <div class="columns column is-multiline is-three-quarter is-mobile">
          <shopBagProduct v-for="product in products" :key="product.products_id" :infos="product" @update="getBasket" @delete="getBasket"></shopBagProduct>
        </div>
        <div class="column is-one-quarter">
          <sidebarShopbag :products="products" :canconfirm="sizesValid"></sidebarShopbag>
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
      sizesValid: false
    }
  },
  created () {
    this.sizesValid = this.getBasket()
  },
  watch: {
    products () {
      this.sizesValid = this.validSizes()
    }
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
  },
  computed: {
    isShopBagEmpty () {
      return this.products.length === 0
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