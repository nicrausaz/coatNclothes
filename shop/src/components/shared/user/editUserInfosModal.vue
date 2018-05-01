<template>
  <div class="modal-card">
    <header class="modal-card-head">
      <p class="modal-card-title">Modifier vos informations</p>
    </header>
    <section class="modal-card-body">
      <b-field label="Nom">
        <b-input v-model="newData.users_name"></b-input>
      </b-field>
      <b-field label="Prénom">
        <b-input v-model="newData.users_fsname"></b-input>
      </b-field>
      <b-field label="Nom de compte">
        <b-input v-model="newData.users_login"></b-input>
      </b-field>
      <b-field label="Email">
        <b-input v-model="newData.users_email"></b-input>
      </b-field>
      <p class="has-text-right">Changer de mot de passe ?</p>
      <!-- edit on click -->
    </section>
    <!-- ajouter le genre -->
    <footer class="modal-card-foot">
      <button class="button" type="button" @click="this.$parent.close">Annuler</button>
      <button class="button is-primary" @click="changeInfos">Confirmer</button>
    </footer>
  </div>
</template>

<script>
export default {
  data () {
    return {
      newData: [],
      editPassword: false
    }
  },
  created () {
    this.getUserInfos()
  },
  methods: {
    changeInfos () {
      this.axios({
        method: 'patch',
        url: '/user/' + this.newData.users_id,
        data: {
          'users_name': this.newData.users_name,
          'users_fsname': this.newData.users_fsname,
          'users_email': this.newData.users_email,
          'users_login': this.newData.users_login
        }
      })
      .then(response => {
        this.$toast.open({
          message: response.data.message,
          type: 'is-success'
        })
        this.$emit('edit')
        this.$parent.close()
      })
      .catch(err => {
        this.$toast.open({
          message: err.response.data.message,
          type: 'is-danger'
        })
      })
    },
    getUserInfos () {
      this.axios({
        method: 'get',
        url: '/user/' + this.$store.state.user.users_id
      })
      .then((response) => {
        this.newData = response.data
      })
    }
  }
}
</script>