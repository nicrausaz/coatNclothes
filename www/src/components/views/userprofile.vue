<template>
  <div>
    <subtitle :name="''" :text="'Connectez-vous ou créez un compte'"></subtitle>
    <input type="checkbox" v-model="isUserLogedIn">
      {{isUserLogedIn}}
    <logsign v-if="!isUserLogedIn"></logsign>
    <div v-else>
      Connected
    </div>
  </div>
</template>

<script>
import logsign from '@/components/views/logsign'
import subtitle from '@/components/templates/subtitle'
export default {
  data () {
    return {
      isUserLogedIn: false
    }
  },
  components: {
    logsign,
    subtitle
  }
}
</script>

<style>

</style>
