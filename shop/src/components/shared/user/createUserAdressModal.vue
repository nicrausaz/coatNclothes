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
      <div class="field">
        <b-checkbox v-model="newData.adresses_main" size="is-small" true-value="true" false-value="false">
          Adresse par défaut ?
        </b-checkbox>
      </div>
    </section>
    <footer class="modal-card-foot">
      <button class="button" type="button" @click="this.$parent.close">Annuler</button>
      <button class="button is-primary" @click="create">Confirmer</button>
    </footer>
  </div>
</template>

<script>
export default {
  data () {
    return {
      newData: []
    }
  },
  methods: {
    create () {
      this.axios({
        method: 'put',
        url: '/user/' + this.$store.state.user.users_id + '/adresses',
        data: {
          adresses_locality: this.newData.adresses_locality,
          adresses_npa: this.newData.adresses_npa,
          adresses_street: this.newData.adresses_street
        }
      })
      .then(response => {
        this.$toast.open({
          message: response.data.message,
          type: 'is-success'
        })
      })
    }
  }
}
</script>