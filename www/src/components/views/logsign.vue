<template>
  <div id="logsign">
    <b-tabs v-model="activeTab">
      <b-tab-item label="Connexion">
        <loginform></loginform>
      </b-tab-item>
      <b-tab-item label="Créer un compte">
        <signupform></signupform>
      </b-tab-item>
    </b-tabs>
  </div>
</template>

<script>
import loginform from '@/components/shared/loginform'
import signupform from '@/components/shared/signupform'

export default {
  name: 'logsign',
  data () {
    return {
      activeTab: 0
    }
  },
  components: {
    loginform,
    signupform
  }
}
</script>

<style>

</style>
