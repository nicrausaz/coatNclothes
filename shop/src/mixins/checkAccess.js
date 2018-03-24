export default {
  created () {
    if (Object.keys(this.$store.state.user).length === 0) {
      // User try to access a restricted page, redirection to login
      this.$toast.open({
        duration: 3000,
        message: 'Connectez-vous ou créez un compte pour accéder à cette page!',
        position: 'is-top',
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
        // this.$toast.open({
        //   duration: 3000,
        //   message: 'Session expirée, veuillez vous connecter à nouveau',
        //   position: 'is-top',
        //   type: 'is-warning'
        // })
        // this.$store.commit('detroyUser')
        // this.$router.push('/user')
      })
    }
  }
}
