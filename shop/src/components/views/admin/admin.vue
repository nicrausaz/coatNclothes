<template>
  <div class="container">
    <subtitle :name="'Administration'" :text="'Administration de Coat&Clothes'"></subtitle>
    <section class="section">
      <div class="columns">
        <div class="column is-3">
          <sidebaradmin></sidebaradmin>
        </div>
        <div class="column">
          Gerer les commandes, les utilisateurs et articles
          <productsTable></productsTable>
        </div>
      </div>
    </section>
  </div>
</template>

<script>
import subtitle from '@/components/templates/subtitle'
import sidebaradmin from '@/components/shared/admin/sidebaradmin'
import productsTable from '@/components/shared/admin/products/productstable'
import checkAccess from '@/mixins/checkAccess'

export default {
  mixins: [checkAccess],
  data () {
    return {
    }
  },
  components: {
    subtitle,
    productsTable,
    sidebaradmin
  }
}
</script>

<style>

</style>
