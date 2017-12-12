<template>
  <div id="logsign" class="container">
    <subtitle :name="''" :text="'Connectez-vous ou créez un compte'"></subtitle>
    <b-tabs v-model="activeTab" position="is-centered">
      <b-tab-item label="Connexion" icon-pack="fa" icon="sign-in">
        <loginform></loginform>
      </b-tab-item>
      <b-tab-item label="Créer un compte" icon-pack="fa" icon="user-plus">
        <signupform></signupform>
      </b-tab-item>
    </b-tabs>
  </div>
</template>

<script>
import subtitle from '@/components/templates/subtitle'
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
    subtitle,
    loginform,
    signupform
  }
}
</script>

<style>

</style>
