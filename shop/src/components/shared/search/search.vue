<template>
<b-dropdown position="is-bottom-left" id="test">
  <a class="navbar-item" slot="trigger">
    <b-icon icon="search" size="is-medium"></b-icon>
  </a>

  <b-dropdown-item custom paddingless>
    <form action="">
      <div class="modal-card" style="width: 400px;">
        <section class="modal-card-body">
          <b-field>
            <b-input placeholder="Chercher un article..." type="search" icon="search" v-model="searchContent"></b-input>
          </b-field>
          <div id="searchResults" v-if="isFilterValid">
            <searchResult v-for="product in filteredProducts" :key="product.product_id" :data="product"></searchResult>
            <p v-if="!resultHasContent">Aucun article trouvé</p>
          </div>
        </section>
      </div>
    </form>
  </b-dropdown-item>
</b-dropdown>
</template>

<script>
import searchResult from '@/components/shared/search/searchResult'

export default {
  data () {
    return {
      searchContent: '',
      fullProducts: []
    }
  },
  computed: {
    isFilterValid () {
      return this.searchContent.length >= 1
    },
    resultHasContent () {
      return this.filteredProducts.length > 0
    },
    filteredProducts () {
      let results = []
      this.fullProducts.forEach(product => {
        if (!product.products_name.toLowerCase().indexOf(this.searchContent.toLowerCase())) {
          results.push(product)
        }
      })
      return results
    }
  },
  created () {
    this.axios({
      method: 'get',
      url: '/products'
    })
    .then((response) => {
      this.fullProducts = response.data
    })
  },
  components: {
    searchResult
  }
}
</script>

<style scoped>

</style>
