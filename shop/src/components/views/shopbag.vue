<template>
  <div class="container">
    <subtitle :name="'Panier'" :text="'Voir votre panier d\'achats'"></subtitle>
    <section class="section">
      <div v-if="!isShopBagEmpty" class="columns">
        <!-- <shopBagProduct v-for="product in products" :key="product.product_id"></shopBagProduct> -->
        <div class="columns is-multiline is-three-quarter">
          <shopBagProduct v-for="i in 10" :key="i"></shopBagProduct>
        </div>
        <div class="content column is-one-quarter notification" id="summaryDiv">
          <h3>Résumé du panier</h3>
          <!-- listes des articles et prix total -->
        </div>
      </div>
      <div v-else>
        Panier vide
      </div>
    </section>
  </div>
</template>

<script>
import subtitle from '@/components/templates/subtitle'
import shopBagProduct from '@/components/shared/products/shopbagproduct'

export default {
  data () {
    return {
      products: []
    }
  },
  computed: {
    isShopBagEmpty () {
      return false
      // return this.products.length === 0
    },
    totalPrice () {
      return 100
    }
  },
  components: {
    subtitle,
    shopBagProduct
  }
}
</script>