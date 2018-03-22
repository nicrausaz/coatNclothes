<template>
  <div>
    <logsign v-if="!isUserLogedIn"></logsign>
    <userprofile v-else></userprofile>
  </div>
</template>

<script>
import logsign from '@/components/views/logsign'
import userprofile from '@/components/views/userprofile'

export default {
  computed: {
    isUserLogedIn () {
      return Object.keys(this.$store.state.user).length > 0
    }
  },
  components: {
    logsign,
    userprofile
  }
}
</script>
