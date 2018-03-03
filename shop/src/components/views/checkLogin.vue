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
      // check if token in in store.state
      return false
    }
  },
  components: {
    logsign,
    userprofile
  }
}
</script>
