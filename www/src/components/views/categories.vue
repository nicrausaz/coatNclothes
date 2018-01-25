<template>
<div class="container">
  <subtitle :name="'Catégories'" :text="category"></subtitle>
  <section class="section">
  </section>
</div>
</template>

<script>
import subtitle from '@/components/templates/subtitle'

export default {
  data () {
    return {
      categoryText: '',
      selectedCategory: ''
    }
  },
  computed: {
    category () {
      if (this.$route.params.id !== 'all') {
        this.selectedCategory = this.$route.params.id
        this.categoryText = 'Liste de ' + this.selectedCategory
      } else {
        this.selectedCategory = ''
        this.categoryText = 'Liste de toutes les catégories'
      }
      return this.categoryText
    }
  },
  components: {
    subtitle
  }
}
</script>

<style>

</style>
