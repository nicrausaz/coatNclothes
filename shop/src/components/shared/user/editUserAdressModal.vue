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
        <b-checkbox v-model="newData.adresses_main" size="is-small" true-value="1" false-value="0" :disabled="isMain">
          Adresse par défaut ?
        </b-checkbox>
      </b-field>
        <a class="button is-danger is-outlined is-pulled-right" @click.stop="deleteAdress()">
          <span>Supprimer</span>
          <b-icon icon="trash" size="is-small"></b-icon>
        </a>
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
  computed: {
    isMain () {
      return this.newData.adresses_main === 1
    }
  },
  methods: {
    getData () {
      let data = {
        adresses_locality: this.newData.adresses_locality,
        adresses_npa: this.newData.adresses_npa,
        adresses_street: this.newData.adresses_street
      }
      if (this.newData.adresses_main) {
        data.adresses_main = 1
      }
      return data
    },
    updateAdress () {
      this.axios({
        method: 'patch',
        url: '/user/' + this.$store.state.user.users_id + '/adresse/' + this.newData.adresses_id,
        data: this.getData()
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
    },
    deleteAdress () {
      this.axios({
        method: 'delete',
        url: '/user/' + this.$store.state.user.users_id + '/adresse/' + this.newData.adresses_id
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