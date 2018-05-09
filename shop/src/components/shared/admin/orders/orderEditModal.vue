<template>
  <div class="modal-card">
    <header class="modal-card-head">
      <p class="modal-card-title">Info & édition de commande</p>
    </header>
    <section class="modal-card-body">
      <!-- <b-field label="Nom">
        <b-input></b-input>
      </b-field> -->
    </section>
    <footer class="modal-card-foot">
      <button class="button" @click="this.$parent.close">Annuler</button>
      <button class="button is-primary" @click="updateOrder">Confirmer</button>
    </footer>
  </div>
</template>

<script>
export default {
  props: ['id'],
  data () {
    return {
      orderData: {}
    }
  },
  created () {

  },
  methods: {
    updateOrder () {}
  }
}
</script>
