<template>
  <div class="container">
    <subtitle :name="'Magasin'" :text="'Consulter les produits'"></subtitle>
    <div class="columns">
      <div class="column is-3">
        <sidebarproduct></sidebarproduct>
      </div>
      <div class="column" id="filtersDiv">
        <filters @filter="setFilters" :brands="filterableBrands"></filters>
        <div v-if="hasFilteredProducts">
        {{filterableBrands}}
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
  watch: {
    $route () {
      this.products_list = []
      this.getCategoryProducts(this.$route.params.id)
    }
  },
  methods: {
    setFilters (filters) {
      this.filters = filters
    },
    getCategoryProducts (id) {
      this.axios({
        method: 'get',
        url: '/category/' + id + '/subs/products'
      })
      .then((response) => {
        if (response.data.length > 0) {
          this.products_list.push(response.data)
        }
      })
    }
  },
  computed: {
    isCardedView () {
      return this.filters.selectedView !== 'listedView'
    },
    filterProducts () {
      let filteredProducts = []
      this.products_list.forEach(product => {
        product.forEach(prod => {
          if (prod.products_price >= this.filters.price[0] && prod.products_price <= this.filters.price[1]) {
            filteredProducts.push(prod)
          }
        })
      })
      return filteredProducts
    },
    hasFilteredProducts () {
      return this.filterProducts.length > 0
    },
    filterableBrands () {
      let brands = []
      this.products_list.forEach(product => {
        product.forEach(prod => {
          brands.push(prod.fk_brand_id)
        })
      })
      return brands
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
