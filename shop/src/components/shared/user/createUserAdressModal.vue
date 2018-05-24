<template>
  <div class="modal-card">
    <header class="modal-card-head">
      <p class="modal-card-title">Créer une adresse</p>
    </header>
    <section class="modal-card-body">
      <b-field label="Adresse">
        <b-input v-model="newData.adresses_street" placeholder="Rue" required></b-input>
      </b-field>
      <b-field label="NPA">
        <b-input v-model="newData.adresses_npa" placeholder="NPA" max-length="6" required></b-input>
      </b-field>
      <b-field label="Localité">
        <b-input v-model="newData.adresses_locality" placeholder="Localité" required></b-input>
      </b-field>
      <b-field label="Pays">
        <b-input v-model="newData.adresses_state" placeholder="Pays" required></b-input>
      </b-field>
      <b-field>
        <b-checkbox v-model="newData.adresses_main" size="is-small" :checked="newData.adresses_main">
          Adresse par défaut ?
        </b-checkbox>
      </b-field>
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
      newData: {}
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
          adresses_street: this.newData.adresses_street,
          adresses_main: this.newData.adresses_main,
          adresses_state: this.newData.adresses_state
        }
      })
      .then(response => {
        this.$toast.open({
          message: response.data.message,
          type: 'is-success'
        })
        this.$emit('new')
        this.$parent.close()
      })
      .catch(err => {
        this.$toast.open({
          message: err.response.data.message,
          type: 'is-danger'
        })
      })
    }
  }
}
</script>