<template>
  <div class="modal-card">
    <header class="modal-card-head">
      <p class="modal-card-title">Nouvelle liste de souhait</p>
    </header>
    <section class="modal-card-body">
      <b-field label="Nom">
        <b-input type="text" v-model="name" required></b-input>
      </b-field>
      <b-field label="Description">
        <b-input type="textarea" v-model="description" maxlength="100"></b-input>
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
      name: '',
      description: ''
    }
  },
  methods: {
    create () {
      this.axios({
        method: 'put',
        url: 'wishlist/user/' + this.$store.state.user.users_id,
        data: {
          'name': this.name,
          'description': this.description
        }
      })
      .then((response) => {
        this.$parent.close()
        this.$toast.open({
          message: response.data.message,
          type: 'is-success'
        })
        this.$emit('new')
      })
      .catch((err) => {
        this.$toast.open({
          message: err.response.data.message,
          type: 'is-danger'
        })
      })
    }
  }
}
</script>