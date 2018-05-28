<template>
  <div class="container">
    <subtitle :name="$store.state.interface.shop" :text="$store.state.interface.viewProduct"></subtitle>
    <div class="columns">
      <div class="column is-3">
        <sidebarproduct></sidebarproduct>
      </div>
      <div class="column">
        <filters @filter="setFilters" :brands="filterableBrands" :maxprice="maxPrice"></filters>
        <div v-if="hasFilteredProducts">
          <div id="cardedproducts" class="columns is-multiline is-mobile productsDiv" v-if="isCardedView">
            <cardedproduct v-for="product in filterProducts" :key="product.product_id" :infos="product" @notloged="openLogin"></cardedproduct>
          </div>
          <div id="linedproducts" class="productsDiv" v-else>
            <linedproduct v-for="product in filterProducts" :key="product.product_id" :infos="product" @notloged="openLogin"></linedproduct>
          </div>
        </div>
        <div class="has-text-centered subtitle is-3" style="padding-top: 100px;" v-else>
          <b-icon icon="inbox" size="is-large"></b-icon>
          <p>{{$store.state.interface.NoProductCoresponding}}</p>
        </div>
      </div>
    </div>
    <b-modal :active.sync="loginModalOn">
      <loginModal></loginModal>
    </b-modal>
  </div>
</template>

<script>
import subtitle from '@/components/templates/subtitle'
import sidebarproduct from '@/components/shared/products/sidebarProducts'
import cardedproduct from '@/components/shared/products/cardedProduct'
import linedproduct from '@/components/shared/products/linedProduct'
import filters from '@/components/shared/products/filters'
import loginModal from '@/components/shared/forms/loginModal'

export default {
  data () {
    return {
      filters: [],
      products_list: [],
      loginModalOn: false
    }
  },
  watch: {
    $route () {
      this.products_list = []
      this.getCategoryProducts(this.$route.params.id)
    }
  },
  created () {
    this.products_list = []
    this.getCategoryProducts(this.$route.params.id)
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
      .catch(() => { this.$router.push('/error') })
    },
    openLogin () {
      this.loginModalOn = true
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
      brands = brands.filter((item, pos) => {
        return brands.indexOf(item) === pos
      })
      return brands
    },
    maxPrice () {
      let biggestPrice = 0
      this.products_list.forEach(product => {
        product.forEach(prod => {
          if (prod.products_price > biggestPrice) {
            biggestPrice = prod.products_price
          }
        })
      })
      return biggestPrice
    }
  },
  components: {
    subtitle,
    sidebarproduct,
    cardedproduct,
    linedproduct,
    filters,
    loginModal
  }
}
</script>

<style scoped>
.productsDiv {
  padding-top: 30px;
}
</style>
