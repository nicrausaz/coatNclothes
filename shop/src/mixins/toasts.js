export default {
  methods: {
    defaultToast (msg) {
      this.$toast.open(msg)
    },
    successToast (msg) {
      this.$toast.open({
        message: msg,
        type: 'is-success'
      })
    },
    warningToast (msg) {
      this.$toast.open({
        message: msg,
        type: 'is-warning'
      })
    },
    dangerToast (msg) {
      this.$toast.open({
        message: msg,
        type: 'is-danger'
      })
    }
  }
}
