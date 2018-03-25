<template>
  <b-collapse class="card">
    <div slot="trigger" slot-scope="props" class="card-header">
      <p class="card-header-title">Paiement</p>
      <a class="card-header-icon">
        <b-icon :icon="isOpen ? 'angle-up' : 'angle-down'"></b-icon>
      </a>
    </div>
    <div class="card-content">
      <div class="content">
        <p><i>Pour le moment, seul le paiement en nature est accepté.</i></p>
        <div class="field">
          <b-radio v-model="paymentMethod" native-value="Facture" disabled>Facture</b-radio>
        </div>
        <div class="field">
          <b-radio v-model="paymentMethod" native-value="Virement" disabled>Virement bancaire</b-radio>
        </div>
        <div class="field">
          <b-radio v-model="paymentMethod" native-value="Nature">Nature</b-radio>
        </div>
      </div>
    </div>
    <footer class="card-footer">
      <a class="card-footer-item">Confirmer</a>
    </footer>
  </b-collapse>
</template>

<script>
export default {
  data () {
    return {
      isOpen: true,
      isConfirmed: false,
      paymentMethod: 'Nature'
    }
  }
}
</script>

<style>

</style>
