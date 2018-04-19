<template>
  <div class="modal-card">
    <header class="modal-card-head">
      <p class="modal-card-title">Créer une addresse</p>
    </header>
    <section class="modal-card-body">
      <b-field label="Rue n0">
        <b-input v-model="newData.adresses_street" placeholder="Rue"></b-input>
      </b-field>
      <b-field label="NPA">
        <b-input v-model="newData.adresses_npa" placeholder="NPA"></b-input>
      </b-field>
      <b-field label="Localité">
        <b-input v-model="newData.adresses_locality" placeholder="Localité"></b-input>
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
  data () {
    return {
      newData: []
    }
  }
}
</script>