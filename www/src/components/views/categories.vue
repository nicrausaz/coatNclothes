<template>
<div class="container">
  <subtitle :name="'Catégories'" :text="''"></subtitle>
  <section class="section">
    {{ categories }} Request not active yet
  </section>
</div>
</template>

<script>
import subtitle from '@/components/templates/subtitle'

export default {
  data () {
    return {
      categories: []
    }
  },
  created () {
    this.axios({
      method: 'get',
      url: '/categories'
    })
    .then((response) => {
      this.categories = response.data
    })
  },
  components: {
    subtitle
  }
}
</script>

<style scoped>

</style>
