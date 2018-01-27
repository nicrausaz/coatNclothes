<template>
  <div id="logsign" class="container">
    <subtitle :name="''" :text="'Connectez-vous ou créez un compte'"></subtitle>
    <b-tabs v-model="activeTab" position="is-centered">
      <b-tab-item label="Connexion" icon="sign-in">
        <loginform></loginform>
      </b-tab-item>
      <b-tab-item label="Créer un compte" icon="user-plus">
        <signupform></signupform>
      </b-tab-item>
    </b-tabs>
  </div>
</template>

<script>

import loginform from '@/components/shared/forms/loginform'
import signupform from '@/components/shared/forms/signupform'
import subtitle from '@/components/templates/subtitle'

export default {
  name: 'logsign',
  data () {
    return {
      activeTab: 0
    }
  },
  components: {
    loginform,
    signupform,
    subtitle
  }
}
</script>

<style>

</style>
