<template>
  <div class="container">
    <subtitle :name="'Magasin'" :text="'Consulter les produits'"></subtitle>
    <div class="columns">
      <div class="column is-3">
        <sidebarproduct></sidebarproduct>
      </div>
      <div class="column" id="filtersDiv">
        <filters @filter="setFilters"></filters>
        <div v-if="hasFilteredProducts">
          <div id="cardedproducts" class="columns is-multiline is-mobile" v-if="isCardedView">
            <cardedproduct v-for="product in filterProducts" :key="product.product_id" :infos="product"></cardedproduct>
          </div>
          <div id="linedproducts" v-else>
            <linedproduct v-for="product in filterProducts" :key="product.product_id" :infos="product"></linedproduct>
          </div>
        </div>
        <div class="has-text-centered subtitle is-3" style="padding-top: 50px;" v-else>
          <b-icon icon="inbox" size="is-large"></b-icon>
          <p>Aucun produit correspondant aux filtres n'a été trouvé ...</p>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import subtitle from '@/components/templates/subtitle'
import sidebarproduct from '@/components/shared/products/sidebarProducts'
import cardedproduct from '@/components/shared/products/cardedProduct'
import linedproduct from '@/components/shared/products/linedProduct'
import filters from '@/components/shared/products/filters'

export default {
  data () {
    return {
      filters: [],
      products_list: []
    }
  },
  methods: {
    setFilters (filters) {
      this.filters = filters
    },
    getCategoryProducts () {
      this.axios({
        method: 'get',
        url: '/category/' + this.$route.params.id + '/products'
      })
      .then((response) => {
        this.products_list = response.data
        // TODO : get children products
        // this.getCategoryChildrenProducts(this.$route.params.id)
      })
    },
    getCategoryChildrenProducts (categoryId) {
      console.log(this.products_list)
    }
  },
  watch: {
    $route () { this.getCategoryProducts() }
  },
  created () {
    this.getCategoryProducts()
  },
  computed: {
    isCardedView () {
      return this.filters.selectedView !== 'listedView'
    },
    filterProducts () {
      let filteredProducts = []
      this.products_list.forEach(product => {
        if (product.products_price >= this.filters.price[0] && product.products_price <= this.filters.price[1]) {
          filteredProducts.push(product)
        }
      })
      return filteredProducts
    },
    hasFilteredProducts () {
      return this.filterProducts.length > 0
    }
  },
  components: {
    subtitle,
    sidebarproduct,
    cardedproduct,
    linedproduct,
    filters
  }
}
</script>

<style scoped>
#filtersDiv {
  margin-top: 20px;
}
</style>
