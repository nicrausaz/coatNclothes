<template>
  <b-collapse class="card">
    <div class="card-header">
      <p class="card-header-title">{{$store.state.interface.payment}}</p>
      <a class="card-header-icon">
        <b-icon :icon="isConfirmed ? 'check' : 'times'" :class="{'confirmed': isConfirmed}"></b-icon>
      </a>
    </div>
    <div class="card-content">
      <div class="content">
        <p><i>{{$store.state.interface.forTheMomentPaymentInKind}}</i></p>
        <div class="field">
          <b-radio v-model="paymentMethod" native-value="Facture" disabled>{{$store.state.interface.bill}}</b-radio>
        </div>
        <div class="field">
          <b-radio v-model="paymentMethod" native-value="Virement" disabled>{{$store.state.interface.bankTransfer}}</b-radio>
        </div>
        <div class="field">
          <b-radio v-model="paymentMethod" native-value="Nature">{{$store.state.interface.paymentInKind}}</b-radio>
        </div>
      </div>
    </div>
    <footer class="card-footer">
      <a class="card-footer-item" @click="valid">{{$store.state.interface.confirm}}</a>
    </footer>
  </b-collapse>
</template>

<script>
export default {
  data () {
    return {
      isConfirmed: false,
      paymentMethod: 'Nature'
    }
  },
  methods: {
    valid () {
      this.isConfirmed = true
      this.$emit('confirm', 'payment')
    }
  }
}
</script>

<style scoped>
.confirmed {
  color: #23d160;
}
</style>
