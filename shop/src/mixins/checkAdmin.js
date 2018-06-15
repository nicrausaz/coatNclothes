export default {
  created () {
    if (!this.$store.state.user.users_admin) {
      this.warningToast(this.$store.state.interface.notAuthorized)
      this.$router.push('/')
    }
  }
}
