export default {
  created () {
    if (Object.keys(this.$store.state.user).length === 0) {
      this.$toast.open({
        duration: 3000,
        message: 'Connectez-vous ou créez un compte pour accéder à cette page!',
        position: 'is-top',
        type: 'is-warning'
      })
      this.$router.push('/user')
    }

    // TODO: check if the token is expired
  }
}
