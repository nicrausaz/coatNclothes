<template>
  <div class="container">
    <subtitle :name="'Confirmation'" :text="'Confirmez votre commande pour terminer'"></subtitle>
    <section class="section">
      <orderContentCard></orderContentCard>
      <div class="columns">
        <div class="column">
          <addressCard></addressCard>
        </div>
        <div class="column">
          <paymentCard></paymentCard>
        </div>
      </div>
      <button class="button is-primary is-large is-pulled-right" disabled>Terminer</button>
    </section>
  </div>
</template>

<script>
import subtitle from '@/components/templates/subtitle'
import orderContentCard from '@/components/shared/orders/confirm/orderContentCard'
import addressCard from '@/components/shared/orders/confirm/addressCard'
import paymentCard from '@/components/shared/orders/confirm/paymentCard'

export default {
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
