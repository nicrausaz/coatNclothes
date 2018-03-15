export default {
  created () {
    if (this.$store.state.userToken === '') {
      this.$toast.open({
        duration: 3000,
        message: 'Connectez-vous ou créez un compte pour accéder à cette page!',
        position: 'is-top',
        type: 'is-warning'
      })
      this.$router.push('/user')
    }
  }
}
