export default {
  methods: {
    addProductToBasket (id, size) {
      // add item to basket
      this.axios({
        method: 'put',
        url: '/basket/user/' + this.$store.state.user.users_id,
        data: {
          'product': id,
          'quantity': 1,
          'size': size
        }
      })
      .then((response) => {
        this.$toast.open({
          message: response.data.message,
          type: 'is-success'
        })
      })
      .catch((err) => {
        this.$toast.open({
          message: err.response.data.message,
          type: 'is-warning'
        })
      })
    }
  }
}
