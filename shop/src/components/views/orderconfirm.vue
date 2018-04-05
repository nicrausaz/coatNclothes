<template>
  <div class="container">
    <subtitle :name="'Confirmation'" :text="'Confirmez votre commande pour terminer'"></subtitle>
    <section class="section">
      <orderContentCard @confirm="setConfirmed"></orderContentCard>
      <div class="columns">
        <div class="column">
          <addressCard @confirm="setConfirmed"></addressCard>
        </div>
        <div class="column">
          <paymentCard @confirm="setConfirmed"></paymentCard>
        </div>
      </div>
      <button class="button is-primary is-large is-pulled-right" :disabled="!fullConfirmed" @click="finishOrder">Terminer</button>
    </section>
  </div>
</template>

<script>
import subtitle from '@/components/templates/subtitle'
import orderContentCard from '@/components/shared/orders/confirm/orderContentCard'
import addressCard from '@/components/shared/orders/confirm/addressCard'
import paymentCard from '@/components/shared/orders/confirm/paymentCard'

export default {
  data () {
    return {
      confirmed: {
        orderContent: false,
        address: false,
        payment: false
      }
    }
  },
  computed: {
    fullConfirmed () {
      return Object.keys(this.confirmed).every((k) => { return this.confirmed[k] })
    }
  },
  methods: {
    setConfirmed (item) {
      this.confirmed[item] = true
    },
    finishOrder () {
      this.axios({
        method: 'put',
        url: 'orders/user/' + this.$store.state.user.users_id,
        headers: {
          'Content-type': 'application/json'
        },
        data: this.orderContent
      })
      .then((response) => {
        this.$router.push('/orders') // add id to open the orders on this new
        this.$toast.open({
          message: response.data.message,
          type: 'is-success',
          duration: 5000
        })
      })
    }
  },
  components: {
    subtitle,
    orderContentCard,
    addressCard,
    paymentCard
  }
}
</script>

<style scoped>
.card {
  margin-bottom: 30px;
}
</style>
