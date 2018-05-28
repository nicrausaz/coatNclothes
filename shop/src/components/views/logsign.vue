<template>
  <div id="logsign" class="container">
    <subtitle :name="''" :text="$store.state.interface.signinOrSignup"></subtitle>
    <b-tabs v-model="activeTab" position="is-centered">
      <b-tab-item :label="$store.state.interface.signin" icon="sign-in-alt">
        <loginform></loginform>
      </b-tab-item>
      <b-tab-item :label="$store.state.interface.signup" icon="user-plus">
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
