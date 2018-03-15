<template>
<div class="container">
  <subtitle :name="'Catégories'" :text="''"></subtitle>
  <div class="columns">
    <div class="column is-3">
      <sidebar></sidebar>
    </div>
    <div class="column" id="filtersDiv">
      <filters @filter="setFilters"></filters>
      <div id="cardedproducts" class="columns is-multiline" v-if="isCardedView">
        <cardedproduct v-for="product in products_list" :key="product.product_id" :infos="product"></cardedproduct>
      </div>
      <div id="linedproducts" v-else>
        <linedproduct v-for="product in products_list" :key="product.product_id" :infos="product"></linedproduct>
      </div>
    </div>
  </div>
</div>
</template>

<script>
import subtitle from '@/components/templates/subtitle'
import sidebar from '@/components/shared/products/sidebarProducts'
import cardedproduct from '@/components/shared/products/cardedproduct'
import linedproduct from '@/components/shared/products/linedproduct'
import filters from '@/components/shared/products/filters'

export default {
  data () {
    return {
      filters: [],
      categories: [],
      products_list: []
    }
  },
  methods: {
    setFilters (filters) {
      this.filters = filters
    }
  },
  created () {
    this.axios({
      method: 'get',
      url: '/products'
    })
    .then((response) => {
      this.products_list = response.data
    })
    this.axios({
      method: 'get',
      url: '/categories'
    })
    .then((response) => {
      this.categories = response.data
    })
  },
  computed: {
    isCardedView () {
      return this.filters.selectedView !== 'listedView'
    }
  },
  components: {
    subtitle,
    sidebar,
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
