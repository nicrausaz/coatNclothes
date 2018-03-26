export default {
  created () {
    if (!this.$store.state.user.users_admin) {
      this.$toast.open({
        duration: 2000,
        message: 'Accès non-autorisé!',
        position: 'is-top',
        type: 'is-warning'
      })
      this.$router.push('/')
    }
  }
}
