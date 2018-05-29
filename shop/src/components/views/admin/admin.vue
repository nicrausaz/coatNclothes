<template>
  <div class="container">
    <subtitle :name="$store.state.interface.administration" :text="''"></subtitle>
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
import checkAdmin from '@/mixins/checkAdmin'

export default {
  mixins: [checkAccess, checkAdmin],
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
