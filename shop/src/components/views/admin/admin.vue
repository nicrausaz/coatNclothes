<template>
  <div class="container">
    <subtitle :name="'Administration'" :text="'Administration de Coat&Clothes'"></subtitle>
    <section class="section">
    </section>
  </div>
</template>

<script>
import subtitle from '@/components/templates/subtitle'
import checkAccess from '@/mixins/checkAccess'

export default {
  mixins: [checkAccess],
  data () {
    return {
    }
  },
  components: {
    subtitle
  }
}
</script>

<style>

</style>
