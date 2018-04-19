<template>
  <div class="modal-card">
    <header class="modal-card-head">
      <p class="modal-card-title">Modifier votre addresse</p>
    </header>
    <section class="modal-card-body">
      <b-field label="Rue n0">
        <b-input v-model="newData.adresses_street"></b-input>
      </b-field>
      <b-field label="NPA">
        <b-input v-model="newData.adresses_npa"></b-input>
      </b-field>
      <b-field label="Localité">
        <b-input v-model="newData.adresses_locality"></b-input>
      </b-field>
    </section>
    <footer class="modal-card-foot">
      <button class="button" type="button" @click="this.$parent.close">Annuler</button>
      <button class="button is-primary">Confirmer</button>
    </footer>
  </div>
</template>

<script>
export default {
  props: ['adress'],
  data () {
    return {
      newData: []
    }
  },
  created () {
    this.newData = this.adress
  }
}
</script>