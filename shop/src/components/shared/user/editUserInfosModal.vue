<template>
  <div class="modal-card">
    <header class="modal-card-head">
      <p class="modal-card-title">Modifier vos informations</p>
    </header>
    <section class="modal-card-body" v-if="!editPassword">
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
      <a class="is-pulled-right" @click="editPassword = true">Changer de mot de passe ?</a>
    <!-- ajouter le genre -->
    </section>

    <section class="modal-card-body" v-else>
      <b-field label="Mot de passe actuel">
        <b-input type="password" v-model="newPassword.actual" placeholder="Mot de passe actuel" password-reveal icon="key" required></b-input>
      </b-field>
      <b-field label="Nouveau mot de passe">
        <b-input type="password" v-model="newPassword.new" placeholder="Nouveau mot de passe" password-reveal icon="key" required></b-input>
      </b-field>
      <a class="is-pulled-right" @click="editPassword = false">Éditer vos infos ?</a>
    </section>
    <footer class="modal-card-foot">
      <button class="button" type="button" @click="this.$parent.close">Annuler</button>
      <button class="button is-primary" v-if="!editPassword" @click="changeInfos">Changer les infos</button>
      <button class="button is-primary" v-else @click="changePassword">Changer le mot de passe</button>
    </footer>
  </div>
</template>

<script>
export default {
  data () {
    return {
      newData: [],
      newPassword: {
        actual: '',
        new: ''
      },
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
    changePassword () {
      this.axios({
        method: 'post',
        url: '/user/' + this.newData.users_id + '/pass',
        data: {
          users_pass: this.newPassword.actual,
          users_newpass: this.newPassword.new
        }
      })
      .then(response => {
        this.$toast.open({
          message: response.data.message,
          type: 'is-success'
        })
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