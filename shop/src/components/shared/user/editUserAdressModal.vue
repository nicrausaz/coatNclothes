<template>
  <div class="modal-card">
    <header class="modal-card-head">
      <p class="modal-card-title">Modifier votre adresse</p>
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
      <b-field>
        <b-checkbox v-model="newData.adresses_main" size="is-small" true-value="1" false-value="0">
          Adresse par défaut ?
        </b-checkbox>
      </b-field>
    </section>
    <footer class="modal-card-foot">
      <button class="button" type="button" @click="this.$parent.close">Annuler</button>
      <button class="button is-primary" @click="updateAdress">Confirmer</button>
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
  },
  methods: {
    updateAdress () {
      this.axios({
        method: 'patch',
        url: '/user/' + this.$store.state.user.users_id + '/adresses',
        data: {
          adresses_id: this.newData.adresses_id,
          adresses_locality: this.newData.adresses_locality,
          adresses_npa: this.newData.adresses_npa,
          adresses_street: this.newData.adresses_street,
          adresses_main: this.newData.adresses_main
        }
      })
      .then(response => {
        this.$toast.open({
          message: response.data.message,
          type: 'is-success'
        })
        this.$emit('update')
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