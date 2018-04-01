export default {
  created () {
    if (Object.keys(this.$store.state.user).length === 0) {
      // User try to access a restricted page, redirection to login
      this.$toast.open({
        message: 'Connectez-vous ou créez un compte pour accéder à cette page!',
        type: 'is-warning'
      })
      this.$router.push('/user')
    } else {
      // check if the user's token is not expired
      this.axios({
        method: 'get',
        url: '/token'
      })
      .catch(() => {
        this.$toast.open({
          message: 'Session expirée, veuillez vous connecter à nouveau',
          type: 'is-warning'
        })
        this.$store.commit('detroyUser')
        this.$router.push('/user')
      })
    }
  }
}
