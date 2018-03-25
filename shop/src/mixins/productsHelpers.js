export default {
  methods: {
    addProductToBasket (id) {
      // add item to basket
      this.axios({
        method: 'put',
        url: '/basket/user/' + this.$store.state.user.users_id,
        data: {
          'product': id,
          'quantity': 1
        }
      })
      .then((response) => {
        this.$toast.open({
          duration: 2000,
          message: response.data.message,
          position: 'is-top',
          type: 'is-success'
        })
      })
      .catch((err) => {
        this.$toast.open({
          duration: 2000,
          message: err.response.data.message,
          position: 'is-top',
          type: 'is-warning'
        })
      })
    }
  }
}
