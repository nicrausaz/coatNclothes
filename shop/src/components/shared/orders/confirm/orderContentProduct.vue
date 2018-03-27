<template>
  <div>
    {{product}}
  </div>
</template>

<script>
export default {
  props: ['data'],
  data () {
    return {
      product: {}
    }
  },
  created () {
    this.axios({
      method: 'get',
      url: 'product/' + this.data.products_id
    })
    .then((response) => {
      this.product = response.data
    })
  }
}
</script>

<style>

</style>
