export default {
  created () {
    if (Object.keys(this.$store.state.user).length === 0) {
      // User try to access a restricted page, redirection to login
      this.warningToast(this.$store.state.interface.signinOrSignupToAccess)
      this.$router.push('/user')
    } else {
      // check 24h token validity
      if (this.$store.state.tokenExpirationDate < Date.now()) {
        this.warningToast(this.$store.state.interface.expiredSession)
        this.$store.commit('detroyUser')
        this.$router.push('/user')
      }
    }
  }
}
