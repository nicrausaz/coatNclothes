<template>
  <div v-if="hasEnoughtSugestions">
    <h1>D'autres produits semblables qui pourraient vous intéresser !</h1>
    <br>
    <carousel :perPage="4" :navigationEnabled="true" paginationActiveColor="#da0f68" paginationColor="#f5f5f5">
      <slide v-for="product in suggestedproducts" :key="product.products_id">
        <figure class="image is-128x128">
          <router-link :to="/product/ + product.products_id">
            <img :src="product.productsPics_path" :alt="product.productsPics_altName">
          </router-link>
        </figure>
      </slide>
    </carousel>
  </div>
</template>

<script>
export default {
  props: ['category'],
  data () {
    return {
      suggestedproducts: []
    }
  },
  created () {
    this.axios({
      method: 'get',
      url: 'category/' + this.category + '/products'
    })
    .then(response => {
      this.suggestedproducts = response.data
    })
  },
  computed: {
    hasEnoughtSugestions () {
      return this.suggestedproducts.length >= 1
      // set to 4
    }
  }
}
</script>
