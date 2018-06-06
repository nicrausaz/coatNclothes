<template>
<b-dropdown position="is-bottom-left" id="test">
  <a class="navbar-item" slot="trigger" id="searchItem">
    <b-icon icon="search" style="padding-right: 5px;"></b-icon>
    {{$store.state.interface.search}}
  </a>

  <b-dropdown-item custom paddingless>
    <div class="modal-card" style="width: 400px;">
      <section class="modal-card-body">
        <b-field>
          <b-input :placeholder="$store.state.interface.searchProduct" type="search" icon="search" v-model="searchContent" autofocus></b-input>
        </b-field>
        <div id="searchResults" v-if="isFilterValid">
          <searchResult v-for="product in filteredProducts" :key="product.product_id" :data="product"></searchResult>
          <p v-if="!resultHasContent">{{$store.state.interface.NoProductFound}}</p>
        </div>
      </section>
    </div>
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
        if (product.products_name.toLowerCase().includes(this.searchContent.toLowerCase())) {
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
#searchItem {
  color: white;
}
#searchItem:hover {
  background-color: #c20d5d;
}
@media screen and (max-width: 640px) {
  #searchItem {
    color: #4a4a4a;
  }
}
</style>
