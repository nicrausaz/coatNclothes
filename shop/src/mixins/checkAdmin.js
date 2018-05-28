export default {
  created () {
    if (!this.$store.state.user.users_admin) {
      this.$toast.open({
        message: this.$store.state.interface.notAuthorized,
        type: 'is-warning'
      })
      this.$router.push('/')
    }
  }
}
