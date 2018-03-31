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
      <button class="button is-primary is-large is-pulled-right" :disabled="!fullConfirmed" >Terminer</button>
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
      console.log(this.confirmed)
      this.confirmed[item] = true
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
