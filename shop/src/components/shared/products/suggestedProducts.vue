<template>
  <div>
    <h1>D'autres produits semblables qui pourraient vous intéresser !</h1>
    <br>

    <pre>
      {{suggestedproducts}}
    </pre>

    <carousel :perPage="6" :navigationEnabled="true" paginationActiveColor="#da0f68" paginationColor="#f5f5f5">
      <slide v-for="product in suggestedproducts" :key="product.products_id">
        <figure class="image is-128x128">
          <img src="http://dl.coatandclothes.shop:8090/Imports/F/lewisskinnyjeanstaillehaute4.jpg" alt="">
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
  }
}
</script>

<style scoped>

</style>
