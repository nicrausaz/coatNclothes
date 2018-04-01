export default {
  created () {
    if (!this.$store.state.user.users_admin) {
      this.$toast.open({
        message: 'Accès non-autorisé!',
        type: 'is-warning'
      })
      this.$router.push('/')
    }
  }
}
