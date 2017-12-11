<template>
  <div id="logsign" class="container">
    <b-tabs v-model="activeTab" position="is-centered">
      <b-tab-item label="Connexion" icon-pack="fa" icon="sign-in">
        <loginform></loginform>
      </b-tab-item>
      <b-tab-item label="Créer un compte" icon-pack="fa">
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
