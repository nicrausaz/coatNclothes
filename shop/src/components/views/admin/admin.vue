<template>
  <div class="container">
    <subtitle :name="'Administration'" :text="'Administration de Coat&Clothes'"></subtitle>
    <section class="section">
      <div class="columns">
        <div class="column is-3">
          <sidebaradmin></sidebaradmin>
        </div>
        <div class="column">
          <router-view></router-view>
        </div>
      </div>
    </section>
  </div>
</template>

<script>
import subtitle from '@/components/templates/subtitle'
import sidebaradmin from '@/components/shared/admin/sidebarAdmin'
import checkAccess from '@/mixins/checkAccess'

export default {
  mixins: [checkAccess],
  data () {
    return {
    }
  },
  components: {
    subtitle,
    sidebaradmin
  }
}
</script>

<style>

</style>
