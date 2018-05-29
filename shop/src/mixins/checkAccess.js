export default {
  created () {
    if (Object.keys(this.$store.state.user).length === 0) {
      // User try to access a restricted page, redirection to login
      this.$toast.open({
        message: this.$store.state.interface.signinOrSignupToAccess,
        type: 'is-warning'
      })
      this.$router.push('/user')
    } else {
      // check 24h token
      // if (this.$store.state.tokenExpirationDate < Date.now()) {
      //   console.log('expired')
      //   this.$store.commit('detroyUser')
      //   this.$router.push('/user')
      // }
    }
  }
}
