export default {
  methods: {
    addProductToBasket (id, size) {
      // add item to basket
      if (this.$store.state.user.users_id) {
        this.axios({
          method: 'put',
          url: '/basket/user/' + this.$store.state.user.users_id,
          data: {
            'product': id,
            'quantity': 1,
            'size': size
          }
        })
        .then(response => {
          this.$store.dispatch('getShopbagQuantity')
          this.successToast(response.data.message)
        })
        .catch(err => {
          this.dangerToast(err.response.data.message)
        })
      } else {
        this.$emit('notloged')
      }
    }
  }
}
