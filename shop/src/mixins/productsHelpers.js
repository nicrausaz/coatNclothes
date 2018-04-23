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
        .then((response) => {
          this.$toast.open({
            message: response.data.message,
            type: 'is-success'
          })
        })
      } else {
        this.$emit('notloged')
      }
    }
  }
}
