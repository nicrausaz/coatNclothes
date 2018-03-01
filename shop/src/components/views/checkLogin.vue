<template>
  <div>
    <logsign v-if="!isUserLogedIn"></logsign>
    <userprofile v-else></userprofile>
    <input type="checkbox" v-model="isUserLogedIn">
      {{isUserLogedIn}}
  </div>
</template>

<script>
import logsign from '@/components/views/logsign'
import userprofile from '@/components/views/userprofile'

export default {
  data () {
    return {
      isUserLogedIn: false
    }
  },
  components: {
    logsign,
    userprofile
  }
}
</script>

<style>

</style>
