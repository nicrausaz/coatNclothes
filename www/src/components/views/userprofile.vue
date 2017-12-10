<template>
  <div>
    <logsign v-if="!isUserLogedIn"></logsign>
    <div v-else>
      Connected
    </div>
  </div>
</template>

<script>
import logsign from '@/components/views/logsign'
export default {
  data () {
    return {
      isUserLogedIn: false
    }
  },
  components: {
    logsign
  }
}
</script>

<style>

</style>
